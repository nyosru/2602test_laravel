<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

class UserService
{
    /**
     * Регистрация нового пользователя
     *
     * @param array $data
     * @return array{user: User, token: string}
     */
    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            // можно добавить 'is_admin' => false по умолчанию, если нужно
        ]);

        $token = $this->createApiToken($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Аутентификация пользователя и выдача токена
     *
     * @param array $credentials
     * @return array{user: User, token: string}|null
     */
    public function login(array $credentials): ?array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $token = $this->createApiToken($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Создание API-токена с правильными правами в зависимости от роли
     *
     * @param User $user
     * @param string $tokenName
     * @return string
     */
    public function createApiToken(User $user, string $tokenName = 'api-token'): string
    {
        if ($user->isAdmin()) {
            return $user->createToken($tokenName, ['*'])->plainTextToken;
        }

        return $user->createToken($tokenName, [
            'products:read',
            'products:create',
            'products:update:own',
            'products:delete:own',
        ])->plainTextToken;
    }

    /**
     * Выход — удаление текущего токена
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    /**
     * Отзыв всех токенов пользователя кроме текущего
     *
     * @param User $user
     * @return void
     */
    public function revokeOtherTokens(User $user): void
    {
        $user->revokeOtherTokens();
    }

    /**
     * Отзыв всех токенов пользователя
     *
     * @param User $user
     * @return void
     */
    public function revokeAllTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Получение текущего пользователя (для /api/user)
     *
     * @param User $user
     * @return User
     */
    public function getCurrentUser(User $user): User
    {
        return $user;
    }

    // Можно добавить другие методы в будущем, например:
    // updateProfile(User $user, array $data)
    // changePassword(User $user, string $oldPassword, string $newPassword)
    // incrementApiUsage(User $user)
}
