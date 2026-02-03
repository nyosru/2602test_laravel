<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Deal;
use App\Models\DealItem;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $deal = Deal::create(['client_id' => $client->id]);
            $product = Product::inRandomOrder()->first();
            $service = Service::inRandomOrder()->first();
            DealItem::create(['deal_id' => $deal->id, 'item_id' => $product->id, 'item_type' => Product::class, 'price' => $product->price]);
            DealItem::create(['deal_id' => $deal->id, 'item_id' => $service->id, 'item_type' => Service::class, 'price' => $service->price]);
            $deal->update(['total_price' => $deal->items->sum('price')]);
        }
    }
}
