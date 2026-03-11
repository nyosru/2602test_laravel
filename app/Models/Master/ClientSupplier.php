<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientSupplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'second_db';
    protected $fillable = [
        'name',
        'phone',
        'title',
    ];
}
