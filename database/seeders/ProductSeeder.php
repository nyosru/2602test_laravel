<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Product::factory(10)->create();

        // Вариант 1: Просто 30 случайных товаров
        Product::factory()
            ->count(30)
            ->create();

        // Вариант 2: Более разнообразные данные (рекомендую)
        Product::factory()
            ->count(15)
            ->create();

        Product::factory()
            ->expensive()
            ->count(10)
            ->create();

        Product::factory()
            ->withoutDescription()
            ->count(5)
            ->create();

        // Вариант 3: Если хотите конкретные записи + случайные
        Product::factory()->create([
            'name'        => 'iPhone 16 Pro Max',
            'description' => 'Самый мощный iPhone на сегодня',
            'price'       => 1599.00,
        ]);

        Product::factory()->create([
            'name'        => 'PlayStation 5 Pro',
            'description' => 'Новая версия с улучшенной графикой',
            'price'       => 699.99,
        ]);

        $this->command->info('Добавлено ' . Product::count() . ' товаров в базу данных.');
    }
}
