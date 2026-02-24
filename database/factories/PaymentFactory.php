<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'direction'   => $this->faker->randomElement(['to', 'from']),
            'amount'      => $this->faker->randomFloat(2, 0.01, 150000),
            'currency'    => $this->faker->randomElement(['RUB', 'USD', 'EUR', 'USDT']),
            'status'      => $this->faker->randomElement([
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'refunded',
            ]),
            'description' => $this->faker->optional(0.65)->sentence(5),
        ];
    }

    // Состояния — очень удобно в тестах и сидах
    public function incoming(): static   // деньги приходят пользователю
    {
        return $this->state(fn () => ['direction' => 'to']);
    }

    public function outgoing(): static   // деньги уходят от пользователя
    {
        return $this->state(fn () => ['direction' => 'from']);
    }

    public function completed(): static
    {
        return $this->state(fn () => ['status' => 'completed']);
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function failed(): static
    {
        return $this->state(fn () => ['status' => 'failed']);
    }

    public function large(): static
    {
        return $this->state(fn () => [
            'amount' => $this->faker->randomFloat(2, 5000, 99999),
        ]);
    }
}
