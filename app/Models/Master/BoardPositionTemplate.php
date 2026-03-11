<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class BoardPositionTemplate extends Model
{
    protected $connection = 'second_db';
    protected $fillable = ['board_template_id', 'name', 'description', 'sorting', 'extra_params'];

    // Должность принадлежит одному шаблону доски
    public function boardTemplate()
    {
        return $this->belongsTo(BoardTemplate::class);
    }
}
