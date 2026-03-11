<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeedRecordOrderTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'msg',
        'leed_record_order_id',
        'transferred_at',
    ];

    protected $dates = ['transferred_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leedRecordOrder(): BelongsTo
    {
        return $this->belongsTo(LeedRecordOrder::class);
    }
}
