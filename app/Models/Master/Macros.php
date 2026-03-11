<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Macros extends Model
{
    use SoftDeletes;

    protected $table = 'macros';

    protected $fillable = [
        'leed_id',
        'name',
        'comment',
        'type_id',
        'to_telegrams',
        'message',
        'day',
        'status',
    ];

    public function columns(): BelongsToMany
    {
        // Связь многие ко многим через таблицу macro_columns
        return $this->belongsToMany(
            LeedColumn::class,
            'macro_columns',
            'macro_id',
            'column_id'
        );
    }

    // Связь с лидом
    public function leed(): BelongsTo
    {
        return $this->belongsTo(LeedRecord::class, 'leed_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'macro_role', 'macro_id', 'role_id');
    }

    public function macroType(): BelongsTo
    {
        return $this->belongsTo(MacroType::class, 'type_id');
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(MacroCondition::class, 'macro_id');
    }

    public function macrosActions(): HasMany
    {
        return $this->hasMany(MacrosAction::class, 'macro_id');
    }

    public function getColumnIdsAttribute(): array
    {
        return $this->columns->pluck('id')->toArray();
    }

    public function getActionColumnIdsAttribute(): array
    {
        return $this->macrosActions
            ->whereNotNull('move_to_column_id')
            ->pluck('move_to_column_id')
            ->toArray();
    }
}
