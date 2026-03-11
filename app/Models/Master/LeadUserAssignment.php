<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadUserAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
    ];

    public function lead()
    {
        return $this->belongsTo(LeedRecord::class, 'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
