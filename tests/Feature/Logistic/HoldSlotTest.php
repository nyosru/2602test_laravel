<?php

namespace Tests\Feature\Logistic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HoldSlotTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_availability_is_cached_until_invalidated(): void
    {
        DB::table('slot')->insert([
            'slot_id' => 1,
            'capacity' => 10,
            'remaining' => 6,
        ]);

        $this->getJson('/api/logistic/slots/availability')
            ->assertOk()
            ->assertJson([
                ['slot_id' => 1, 'capacity' => 10, 'remaining' => 6],
            ]);

        DB::table('slot')
            ->where('slot_id', 1)
            ->update(['remaining' => 3]);

        $this->getJson('/api/logistic/slots/availability')
            ->assertOk()
            ->assertJson([
                ['slot_id' => 1, 'capacity' => 10, 'remaining' => 6],
            ]);
    }

    public function test_hold_is_created_and_invalidates_availability_cache(): void
    {
        DB::table('slot')->insert([
            'slot_id' => 3,
            'capacity' => 10,
            'remaining' => 9,
        ]);

        $this->getJson('/api/logistic/slots/availability')->assertOk();

        $response = $this->postJson('/api/logistic/slots/3/hold', [
            'UUID' => 222,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('message', 'ok')
            ->assertJsonPath('status', 'held')
            ->assertJsonStructure(['id', 'expires_at']);

        $this->assertDatabaseHas('holds', [
            'to_slot' => 3,
            'UUID' => 222,
            'status' => 'held',
        ]);

        $this->getJson('/api/logistic/slots/availability')
            ->assertOk()
            ->assertJson([
                ['slot_id' => 3, 'capacity' => 10, 'remaining' => 8],
            ]);
    }

    public function test_hold_returns_conflict_when_no_remaining_capacity(): void
    {
        DB::table('slot')->insert([
            'slot_id' => 2,
            'capacity' => 10,
            'remaining' => 0,
        ]);

        $this->postJson('/api/logistic/slots/2/hold', [
            'UUID' => 111,
        ])
            ->assertStatus(409)
            ->assertJson([
                'message' => 'Slot has no remaining capacity',
            ]);

        $this->assertDatabaseCount('holds', 0);
    }

    public function test_confirm_hold_updates_status(): void
    {
        DB::table('slot')->insert([
            'slot_id' => 11,
            'capacity' => 10,
            'remaining' => 2,
        ]);

        $holdId = DB::table('holds')->insertGetId([
            'to_slot' => 11,
            'at_end' => now()->addMinutes(5),
            'status' => 'held',
            'UUID' => 11111,
        ]);

        $this->postJson("/api/logistic/holds/{$holdId}/confirm")
            ->assertOk()
            ->assertJsonPath('status', 'confirmed');

        $this->assertDatabaseHas('holds', [
            'id' => $holdId,
            'status' => 'confirmed',
        ]);
    }

    public function test_cancel_hold_returns_slot_capacity_back(): void
    {
        DB::table('slot')->insert([
            'slot_id' => 12,
            'capacity' => 10,
            'remaining' => 5,
        ]);

        $holdId = DB::table('holds')->insertGetId([
            'to_slot' => 12,
            'at_end' => now()->addMinutes(5),
            'status' => 'held',
            'UUID' => 12121,
        ]);

        $this->deleteJson("/api/logistic/holds/{$holdId}")
            ->assertOk()
            ->assertJsonPath('status', 'cancelled');

        $this->assertDatabaseHas('slot', [
            'slot_id' => 12,
            'remaining' => 6,
        ]);
    }
}
