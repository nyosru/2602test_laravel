<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardFieldSetting extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'second_db';
    protected $fillable = [
        'board_id',
        'field_name',
        'is_enabled',
        'show_on_start',
        'in_telega_msg',
        'show_in_notification',
        'sort_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'show_on_start' => 'boolean',
        'in_telega_msg' => 'boolean',
        'show_in_notification' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function orderRequest(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderRequest::class, 'pole', 'field_name');
    }

}
