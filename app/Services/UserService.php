<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Регистрация нового пользователя.
     *
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
     * Аутентификация пользователя и выдача токена.
     *
     * @return null|array{user: User, token: string}
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
     * Создание API-токена с правильными правами в зависимости от роли.
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
     * Выход — удаление текущего токена.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    /**
     * Отзыв всех токенов пользователя кроме текущего.
     */
    public function revokeOtherTokens(User $user): void
    {
        $user->revokeOtherTokens();
    }

    /**
     * Отзыв всех токенов пользователя.
     */
    public function revokeAllTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Получение текущего пользователя (для /api/user).
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
