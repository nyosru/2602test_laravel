<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeedMoneyMovement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'leed_record_id',
        'amount',
        'user_id',
        'operation_date',
        'comment',
        'type',
    ];

    //    protected $casts = [
    //        'operation_date',
    //    ];

    public function leedRecord()
    {
        return $this->belongsTo(LeedRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
