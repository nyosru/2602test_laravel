<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->words(3, true),      // ← $this->faker здесь работает
            'description' => $this->faker->paragraph(),
            'price'       => $this->faker->randomFloat(2, 10, 2000),
            'stock'       => $this->faker->numberBetween(0, 100),
            'is_active'   => $this->faker->boolean(80),
            // ... остальные поля
        ];
    }

    // Пример state с unique
    public function expensive()
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => $this->faker->randomFloat(2, 500, 5000),  // ← здесь faker должен быть доступен
            ];
        });
    }

    public function withoutDescription()
    {
        return $this->state([
            'description' => null,
        ]);
    }
}
