<?php

namespace App\Models\Master;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MacrosAction extends Model
{
    use SoftDeletes;

    protected $table = 'macros_actions'; // Явно указываем таблицу (если не указана в БД)

    protected $fillable = [
        'macro_id',
        'message',
        'move_to_column_id',
    ];

    /**
     * Связь с макросом
     */
    public function macro(): BelongsTo
    {
        return $this->belongsTo(Macros::class, 'macro_id');
    }

    /**
     * Связь с целевой колонкой для перемещения.
     */
    public function targetColumn(): BelongsTo
    {
        return $this->belongsTo(LeedColumn::class, 'move_to_column_id');
    }

    /**
     * Проверяет, является ли действие перемещением в колонку.
     */
    public function getIsMoveActionAttribute(): bool
    {
        return !empty($this->move_to_column_id);
    }

    /**
     * Проверяет, является ли действие отправкой сообщения.
     */
    public function getIsMessageActionAttribute(): bool
    {
        return !empty($this->message);
    }

    /**
     * Валидация при сохранении: действие должно иметь хотя бы одно назначение.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($action) {
            if (empty($action->move_to_column_id) && empty($action->message)) {
                throw new Exception('Действие макроса должно включать хотя бы перемещение или сообщение.');
            }
        });
    }
}
