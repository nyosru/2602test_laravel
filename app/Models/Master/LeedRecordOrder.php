<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeedRecordOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['text', 'reminder_at', 'status', 'user_id', 'leed_record_id', 'close_comment', 'close_at',
        'user_worker_id',
        'worker_comment',
        'worker_comment_at',
        'worker_job_status',
    ];
    protected $dates = ['reminder_at'];
    protected function casts(): array
    {
        return [
            'reminder_at' => 'datetime',
            'close_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leedRecord()
    {
        return $this->belongsTo(LeedRecord::class);
    }

    public function userWorker()
    {
        return $this->belongsTo(User::class, 'user_worker_id');
    }

    // Также добавьте отношение для переносов, если необходимо
    public function transfers()
    {
        return $this->hasMany(LeedRecordOrderTransfer::class);
    }

}
