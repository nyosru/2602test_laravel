<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        //  более реалистичные данные по пользователям
        $users = User::all();

        foreach ($users as $user) {

            // Входящие платежи (to) — депозиты, выплаты, возвраты и т.д.
            Payment::factory()->count(rand(20, 50))->create([
                'user_id' => $user->id,
            ]);


        }

    }
}
