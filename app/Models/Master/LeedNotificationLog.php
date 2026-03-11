<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeedNotificationLog extends Model
{
    protected $fillable = [
        'leed_notification_id',
        'started_at',
        'finished_at',
        'result',
        'error',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function leedNotification(): BelongsTo
    {
        return $this->belongsTo(LeedNotification::class);
    }

}
