<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPaymentType extends Model
{
    use HasFactory;
    use SoftDeletes; // Добавляем поддержку мягкого удаления

    protected $table = 'order_payment_types';

    protected $fillable = [
        'name', // Поле для названия
        'var_to_one',
        'prepay',
    ];
    // Обратная связь с Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_payment_type_id');
    }
}
