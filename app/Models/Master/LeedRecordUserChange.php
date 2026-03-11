<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class LeedRecordUserChange extends Model
{
    protected $fillable = [
        'leed_record_id',
        'new_user_id',
    ];

    public function leedRecord()
    {
        return $this->belongsTo(LeedRecord::class);
    }

    public function newUser()
    {
        return $this->belongsTo(User::class, 'new_user_id');
    }

}
