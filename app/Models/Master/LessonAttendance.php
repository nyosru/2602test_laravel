<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonAttendance extends Model
{
    /**
     * новая.
     */
    public const STATUS_NEW      = 'new';
    /**
     * был.
     */
    public const STATUS_ATTENDED = 'attended';
    /**
     * пропустил.
     */
    public const STATUS_MISSED   = 'missed';
    /**
     * болел.
     */
    public const STATUS_SICK     = 'sick';

    protected $fillable = [
        'lesson_id',
        'lead_id',       // ссылается на LeedRecord
        'status',        // был / пропустил / больничный
        'comment',       // опционально
    ];

    // Отношение к занятию
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    // Отношение к ребенку (лиду)
    public function leed(): BelongsTo
    {
        return $this->belongsTo(LeedRecord::class);
    }

    // 4. Пример использования (в контроллере или Livewire)
    // PHP// Создать запись посещаемости
    // $attendance = LessonAttendance::create([
    // 'lesson_id'      => $lesson->id,
    // 'leed_record_id' => $leedRecord->id,
    // 'status'         => 'new', // или 'attended', 'missed', 'sick'
    // 'comment'        => 'Ребёнок был активен',
    // 'paid'           => true,
    // 'paid_amount'    => 500,
    // ]);
    //
    // // Получить всех учеников урока
    // $students = $lesson->attendances()->with('leedRecord')->get();
    //
    // // Получить все уроки ученика
    // $lessons = $leedRecord->lessons()->get();
    //
    // // Обновить статус
    // $attendance->update(['status' => 'attended']);
}
