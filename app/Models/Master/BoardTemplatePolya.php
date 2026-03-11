<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class BoardTemplatePolya extends Model
{
    protected $table = 'board_template_polyas';
    protected $connection = 'second_db';
    protected $fillable = [
        'board_template_id',
        'name',
        'description',
        'pole',
        'sort',
        'is_enabled',
        'show_on_start',
        'in_telega_msg',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'show_on_start' => 'boolean',
        'in_telega_msg' => 'boolean',
        'sort' => 'integer',
    ];

    // Связь с BoardTemplate (многие к одному)
    public function boardTemplate()
    {
        return $this->belongsTo(BoardTemplate::class);
    }

}
