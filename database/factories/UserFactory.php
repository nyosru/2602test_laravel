<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('password123'), // или Str::random(12)
            'remember_token'    => Str::random(10),
            'is_admin'          => false,
            'api_limit'         => null,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    /**
     * Состояние: пользователь с подтверждённым email
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Состояние: пользователь без подтверждённого email
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Состояние: администратор
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
            'api_limit' => null, // админам обычно без лимита
        ]);
    }

    /**
     * Состояние: пользователь с ограниченным API-лимитом
     */
    public function limited(int $limit = 100): static
    {
        return $this->state(fn (array $attributes) => [
            'api_limit' => $limit,
            'is_admin'  => false,
        ]);
    }

    /**
     * Состояние: пользователь с конкретным паролем (удобно для тестов авторизации)
     */
    public function withPassword(string $password): static
    {
        return $this->state(fn (array $attributes) => [
            'password' => Hash::make($password),
        ]);
    }

    /**
     * Состояние: пользователь с конкретным email (удобно для тестов логина/регистрации)
     */
    public function withEmail(string $email): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => $email,
        ]);
    }
}
