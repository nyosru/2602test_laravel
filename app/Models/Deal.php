<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    /** @use HasFactory<\Database\Factories\DealFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = ['client_id', 'total_price'];
    public function client() {
        return $this->belongsTo(Client::class);
    }
    public function items() {
        return $this->hasMany(DealItem::class);
    }
}
