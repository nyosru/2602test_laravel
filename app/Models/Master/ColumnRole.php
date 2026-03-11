<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnRole extends Model
{
    use HasFactory;
    protected $connection = 'second_db';
    protected $table = 'column_role';

    protected $fillable = [
        'column_id',
        'role_id',
    ];

    public function column()
    {
        return $this->belongsTo(LeedColumn::class, 'column_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
