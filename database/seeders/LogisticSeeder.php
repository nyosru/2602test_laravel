<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LogisticSeeder extends Seeder
{
    /**
     * Seed logistic module data.
     */
    public function run(): void
    {
        $this->call([
            SlotSeeder::class,
        ]);
    }
}
