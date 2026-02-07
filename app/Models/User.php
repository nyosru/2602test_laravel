<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'api_limit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'tokens',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'api_limit' => 'integer',
        ];
    }

    /**
     * Получить продукты пользователя
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    /**
     * Проверить, является ли пользователь администратором
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Проверить лимит API запросов
     */
    public function hasApiLimitExceeded(): bool
    {
        if (is_null($this->api_limit)) {
            return false;
        }

        // Пример: считаем количество запросов за последние 24 часа
        // $count = $this->apiRequests()
        //     ->where('created_at', '>=', now()->subDay())
        //     ->count();

        // return $count >= $this->api_limit;

        // Пока заглушка
        return false;
    }

    /**
     * Создать токен с определенными разрешениями
     */
    public function createApiToken(string $name = 'api-token'): string
    {
        // Для администраторов даем полные права
        if ($this->isAdmin()) {
            return $this->createToken($name, ['*'])->plainTextToken;
        }

        // Для обычных пользователей ограниченные права
        return $this->createToken($name, [
            'products:read',
            'products:create',
            'products:update:own',
            'products:delete:own',
        ])->plainTextToken;
    }

    /**
     * Отозвать все токены, кроме текущего
     */
    public function revokeOtherTokens(): void
    {
        if ($this->currentAccessToken?->exists) {
            $this->tokens()
                ->where('id', '!=', $this->currentAccessToken->id)
                ->delete();
        } else {
            // Если нет текущего токена — отзываем все
            $this->tokens()->delete();
        }
    }

    /**
     * Отозвать ВСЕ токены пользователя
     */
    public function revokeAllTokens(): void
    {
        $this->tokens()->delete();
    }

    /**
     * Получить количество активных токенов
     */
    public function getActiveTokensCount(): int
    {
        return $this->tokens()
            ->whereNull('expires_at')
            ->orWhere('expires_at', '>', now())
            ->count();
    }

}
