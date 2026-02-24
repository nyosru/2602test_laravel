<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * Атрибуты для массового заполнения
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'direction',
        'amount',
        'currency',
        'status',
        'description',
    ];

    /**
     * Пользователь, к которому относится платёж
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

