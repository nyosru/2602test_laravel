<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 30 обычных товаров
        Product::factory()->count(30)->create();

        // 10 дорогих товаров
        Product::factory()->expensive()->count(10)->create();

        // 5 товаров без описания
        Product::factory()->withoutDescription()->count(5)->create();

        // Конкретные известные товары
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
