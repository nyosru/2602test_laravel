<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class BoardColumnTemplate extends Model
{
    protected $connection = 'second_db';

    protected $fillable = ['board_template_id', 'name', 'description', 'sorting'];

    // Колонка принадлежит одному шаблону доски
    public function boardTemplate()
    {
        return $this->belongsTo(BoardTemplate::class);
    }

}
