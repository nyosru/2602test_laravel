<?php

namespace App\Models\Master;

use App\Jobs\ProcessLeedNotificationJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeedNotification extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'leed_id',
        'message',

        'once_at',

        'weekly_day',
        'weekly_time',

        'monthly_day',
        'monthly_time',

        'yearly_day',
        'yearly_month',
        'yearly_time',

        //        'telegram_id',

        'user_id',
        'position_id',

    ];

    protected $dates = [
        'once_at',
        'weekly_time',
        'monthly_time',
        'yearly_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    //    protected $casts = [
    //        'once_at',
    //        'weekly_time',
    //        'monthly_time',
    //        'yearly_time',
    //        'created_at',
    //        'updated_at',
    //        'deleted_at',
    //    ];

    public function leed()
    {
        return $this->belongsTo(LeedRecord::class, 'leed_id');
    }

    //    public function telegramUser()
    //    {
    //        return $this->belongsTo(TelegramUser::class, 'telegram_id');
    //    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Role::class, 'position_id');
    }

    protected static function booted()
    {
        static::created(function ($notification) {
            ProcessLeedNotificationJob::dispatch($notification);
        });
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LeedNotificationLog::class);
    }

}
