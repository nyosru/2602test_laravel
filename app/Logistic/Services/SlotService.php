<?php

namespace App\Logistic\Services;

use App\Logistic\Models\Hold;
use App\Logistic\Models\Slot;
use Closure;
use Illuminate\Contracts\Cache\LockProvider as LockProviderContract;
use Illuminate\Database\QueryException;
use Illuminate\Support\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SlotService
{
    public string $cacheKey = 'logistic.slots.availability';

    private const AVAILABILITY_CACHE_TTL_SECONDS = 10;

    private object $missingValue;

    public function __construct()
    {
        $this->missingValue = new \stdClass();
    }

    public function getAvailability(): Collection
    {
        return collect($this->getCachedValue(
            $this->cacheKey,
            fn (): array => Slot::query()
                ->orderBy('slot_id')
                ->get()
                ->all(),
            self::AVAILABILITY_CACHE_TTL_SECONDS,
        ));
    }

    public function createHold(int $slotId, int $uuid): array
    {
        return DB::transaction(function () use ($slotId, $uuid) {
            $existingHold = Hold::query()
                ->where('UUID', $uuid)
                ->first();

            if ($existingHold) {
                return [
                    'status' => 200,
                    'cached' => true,
                    'data' => $this->mapHoldResponse($existingHold),
                ];
            }

            $slot = Slot::query()
                ->where('slot_id', $slotId)
                ->lockForUpdate()
                ->first();

            if (! $slot) {
                return [
                    'status' => 404,
                    'data' => ['message' => 'Slot not found'],
                ];
            }

            if ((int) $slot->remaining === 0) {
                return [
                    'status' => 409,
                    'data' => ['message' => 'Slot has no remaining capacity'],
                ];
            }

            $atHold = now()->addMinutes(5);

            try {
                $hold = Hold::query()->create([
                    'to_slot' => $slotId,
                    'at_end' => $atHold,
                    'UUID' => $uuid,
                    'status' => 'held',
                ]);
            } catch (QueryException) {
                $duplicate = Hold::query()
                    ->where('UUID', $uuid)
                    ->first();

                if ($duplicate) {
                    return [
                        'status' => 200,
                        'cached' => true,
                        'data' => $this->mapHoldResponse($duplicate),
                    ];
                }

                return [
                    'status' => 500,
                    'data' => ['message' => 'Unable to create hold'],
                ];
            }

            $hold->slot->decrement('remaining');

            return [
                'status' => 200,
                'cached' => false,
                'data' => $this->mapHoldResponse($hold),
            ];
        });
    }

    public function getCurrentHolds(): Collection
    {
        return Hold::query()
            ->orderBy('at_end')
            ->get()
            ->map(fn (Hold $hold): array => [
                'id' => (int) $hold->id,
                'to_slot' => (int) $hold->to_slot,
                'UUID' => (int) $hold->UUID,
                'status' => (string) $hold->status,
                'at_end' => (string) $hold->at_end,
            ]);
    }

    public function confirmHold(int $holdId): array
    {
        return DB::transaction(function () use ($holdId) {
            $hold = Hold::query()
                ->with('slot')
                ->where('status', '!=', 'cancelled')
                ->lockForUpdate()
                ->find($holdId);

            if (! $hold) {
                return [
                    'status' => 404,
                    'data' => ['message' => 'Hold not found'],
                ];
            }

            if ((string) $hold->status === 'confirmed') {
                return [
                    'status' => 200,
                    'data' => $this->mapHoldResponse($hold),
                ];
            }

            if ((string) $hold->status !== 'held') {
                return [
                    'status' => 409,
                    'data' => ['message' => 'Invalid hold state for confirmation'],
                ];
            }

            $hold->status = 'confirmed';
            $hold->save();

            return [
                'status' => 200,
                'cached' => false,
                'data' => $this->mapHoldResponse($hold),
            ];
        });
    }

    public function cancelHold(int $holdId): array
    {
        return DB::transaction(function () use ($holdId) {
            $hold = Hold::query()
                ->with('slot')
                ->where('status', '=', 'held')
                ->lockForUpdate()
                ->find($holdId);

            if (! $hold) {
                return [
                    'status' => 404,
                    'data' => ['message' => 'Hold not found'],
                ];
            }

            $hold->slot->increment('remaining');
            $hold->status = 'cancelled';
            $hold->save();

            return [
                'status' => 200,
                'cached' => false,
                'data' => $this->mapHoldResponse($hold),
            ];
        });
    }

    public function invalidateAvailabilityCache(): void
    {
        Cache::forget($this->cacheKey);
    }

    private function mapHoldResponse(Hold $hold): array
    {
        return [
            'message' => 'ok',
            'id' => (int) $hold->id,
            'status' => (string) $hold->status,
            'expires_at' => $hold->at_end instanceof CarbonInterface
                ? $hold->at_end->toISOString()
                : (string) $hold->at_end,
        ];
    }

    private function getCachedValue(
        string $key,
        Closure $resolver,
        int $ttlSeconds,
        int $lockSeconds = 10,
        int $waitAttempts = 5,
        int $waitMs = 100
    ): mixed {
        $cached = Cache::get($key, $this->missingValue);
        if ($cached !== $this->missingValue) {
            return $cached;
        }

        $store = Cache::getStore();
        if (! $store instanceof LockProviderContract) {
            $fresh = $resolver();
            $this->putCachedValue($key, $fresh, $ttlSeconds);

            return $fresh;
        }

        $lock = Cache::lock("cache:stampede:{$key}", $lockSeconds);

        if ($lock->get()) {
            try {
                $cached = Cache::get($key, $this->missingValue);
                if ($cached !== $this->missingValue) {
                    return $cached;
                }

                $fresh = $resolver();
                $this->putCachedValue($key, $fresh, $ttlSeconds);

                return $fresh;
            } finally {
                $lock->release();
            }
        }

        for ($i = 0; $i < max(1, $waitAttempts); $i++) {
            usleep(max(1, $waitMs) * 1000);

            $cached = Cache::get($key, $this->missingValue);
            if ($cached !== $this->missingValue) {
                return $cached;
            }
        }

        $fresh = $resolver();
        $this->putCachedValue($key, $fresh, $ttlSeconds);

        return $fresh;
    }

    private function putCachedValue(string $key, mixed $data, int $ttlSeconds): bool
    {
        if ($ttlSeconds <= 0) {
            return false;
        }

        return Cache::put($key, $data, $ttlSeconds);
    }
}
