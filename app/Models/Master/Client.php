<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;
    protected $connection = 'second_db';
    protected $fillable = [
        'name_i',
        'name_f',
        'name_o',
        'phone',
        'extra_contacts',
        'address',
        'city',
        'street',
        'building',
        'building_part',
        'cvartira',
        'floor',
        'lift',
        'email',
        'comment',
        'physical_person',
        'status',
        'forma',
        'avatar',

        'passport',
        'seria_passport',
        'nomer_passport',
        'date_passport',
        'cod_passport',

        'ur_passport',
        'ur_name',
        'name_company',
        'active',
    ];

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date_passport' => 'date',
        //        'lift' => 'boolean',
        //        'physical_person' => 'boolean',
        //        'active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function leedRecords()
    {
        return $this->hasMany(LeedRecord::class);
    }
}
