<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealItem extends Model
{
    /** @use HasFactory<\Database\Factories\DealItemFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = ['deal_id', 'item_id', 'item_type', 'quantity', 'price'];
    public function item() {
        return $this->morphTo();
    }
    public function deal() {
        return $this->belongsTo(Deal::class);
    }

}
