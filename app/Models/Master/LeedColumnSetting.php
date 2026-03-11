<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeedColumnSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'leed_column_id',
        'name',
        'key',
        'boolean_value',
        'numeric_value',
        'string_value',
    ];

    protected $casts = [
        //        'boolean_value' => 'boolean',
        'numeric_value' => 'integer',
    ];

    public function column(): BelongsTo
    {
        return $this->belongsTo(LeedColumn::class, 'leed_column_id');
    }
}
