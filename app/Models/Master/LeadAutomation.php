<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadAutomation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'board_id',
        'source_column_id',
        'target_column_id',
        'action',
        'string1',
        'string2',
        'integer1',
        'integer2',
        'delay_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Отношения
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function sourceColumn(): BelongsTo
    {
        return $this->belongsTo(LeedColumn::class, 'source_column_id');
    }

    public function targetColumn(): BelongsTo
    {
        return $this->belongsTo(LeedColumn::class, 'target_column_id');
    }

}
