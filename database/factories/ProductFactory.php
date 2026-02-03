<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->unique()->catchPhrase(),
            'description' => $this->faker->realTextBetween(50, 250),
            'price'       => $this->faker->randomFloat(2, 9.99, 2499.99),
        ];
    }

    /**
     * Состояние для дорогих товаров
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $this->faker->randomFloat(2, 800, 5000),
        ]);
    }

    /**
     * Состояние для товаров без описания
     */
    public function withoutDescription(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => null,
        ]);
    }

}
