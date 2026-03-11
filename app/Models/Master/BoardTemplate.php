<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardTemplate extends Model
{
    use SoftDeletes;
    protected $connection = 'second_db';
    protected $fillable = ['name', 'status', 'price',
        'start_template',
    ];

    protected $casts = [
        'start_template' => 'boolean',
        // другие casts...
    ];

    // Шаблон доски имеет множество колонок
    public function columns()
    {
        return $this->hasMany(BoardColumnTemplate::class);
    }

    // Шаблон доски имеет множество должностей
    public function positions()
    {
        return $this->hasMany(BoardPositionTemplate::class);
    }

    // Один BoardTemplate может иметь много полей (BoardTemplatePolya)
    public function polya()
    {
        return $this->hasMany(BoardTemplatePolya::class);
    }

    /**
     * Scope для получения стартовых шаблонов.
     */
    public function scopeStartTemplates($query)
    {
        return $query->where('start_template', true);
    }

}
