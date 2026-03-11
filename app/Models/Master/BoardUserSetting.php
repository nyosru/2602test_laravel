<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardUserSetting extends Model
{
    use HasFactory;
    protected $connection = 'second_db';
    protected $table = 'board_user_settings';

    protected $fillable = [
        'board_id',
        'user_id',
        'setting',
        'numeric_value',
        'string_value',
    ];

    protected $casts = [
        'numeric_value' => 'integer',
        'string_value' => 'string',
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getValue()
    {
        return $this->numeric_value ?? $this->string_value;
    }

    /**
     * Scope для поиска по доске и пользователю.
     */
    public function scopeForBoardAndUser($query, int $boardId, int $userId)
    {
        return $query->where('board_id', $boardId)->where('user_id', $userId);
    }

    /**
     * Scope для поиска конкретной настройки.
     */
    public function scopeForSetting($query, string $setting)
    {
        return $query->where('setting', $setting);
    }
}
