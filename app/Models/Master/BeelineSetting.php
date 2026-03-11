<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class BeelineSetting extends Model
{
    protected $connection = 'second_db';
    protected $fillable = ['webhook_url'];
}
