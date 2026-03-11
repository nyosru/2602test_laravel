<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileUpload extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'leed_record_id',
        'user_id',
        'name',
        'file_name',

        'path',
        's3_path',

        'mini',
        'img_mini',
    ];

    // Связь с лидом
    public function leed(): BelongsTo
    {
        return $this->belongsTo(LeedRecord::class);
    }

    // Связь с пользователем
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
