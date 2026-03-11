<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MacroCondition extends Model
{
    use SoftDeletes;

    protected $table = 'macro_conditions';

    protected $fillable = [
        'macro_id',
        'order_request_id',
        'column_id',
        'days_before',
        'days_after',
        'days_pause',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function macro(): BelongsTo
    {
        return $this->belongsTo(Macros::class, 'macro_id');
    }

    public function orderRequest(): BelongsTo
    {
        return $this->belongsTo(BoardFieldSetting::class, 'order_request_id');
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(LeedColumn::class, 'column_id');
    }

    public function getIsColumnSpecificAttribute(): bool
    {
        return (bool) $this->column_id;
    }

    public function getIsFieldSpecificAttribute(): bool
    {
        return (bool) $this->order_request_id;
    }

    //    protected static function boot()
    //    {
    //        parent::boot();
    //
    //        static::saving(function ($condition) {
    //            if (empty($condition->column_id) && empty($condition->order_request_id)) {
    //                throw new \Exception('Условие должно быть привязано хотя бы к одной колонке или полю лида.');
    //            }
    //        });
    //    }

}
