<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductType extends Model
{
    use HasFactory;

    protected $table = 'order_product_types';

    protected $fillable = [
        'name',
        'order',
        'types',
    ];

    // Обратная связь с Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_product_type_id');
    }
}
