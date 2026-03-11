<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class LeedColumnBackgroundColor extends Model
{
    protected $fillable = [
        'name',
        'html_code',
        'tailwind_classes',
        'style_string',
    ];
}
