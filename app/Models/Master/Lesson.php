<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Lesson extends Model
{
    protected $fillable = [
        'board_id',      // к какой доске/группе относится
        'column_id',     // опционально, если нужно для отдельной колонки
        'name',          // название занятия
        'date',          // дата проведения
        'start_time',    // время начала
        'end_time',      // время окончания
        'description',   // комментарий
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Отношение к доске
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    // Опционально к колонке
    public function column(): BelongsTo
    {
        return $this->belongsTo(LeedColumn::class);
    }

    // Посещаемость
    public function attendance(): HasMany
    {
        return $this->hasMany(LessonAttendance::class);
    }

    // студенты на занятии
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(LeedRecord::class, LessonAttendance::class, 'lesson_id', 'id', 'id', 'leed_record_id');
    }

}
