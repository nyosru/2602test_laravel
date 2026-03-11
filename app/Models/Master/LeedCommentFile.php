<?php

namespace App\Models\Master;

use App\Http\Controllers\FileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeedCommentFile extends Model
{
    use HasFactory;

    protected $table = 'leed_comment_files';

    protected $fillable = [
        'leed_record_comment_id',
        'user_id',
        'file_name',
        'path',
        'mini',
    ];

    public function getSecretAttribute()
    {
        return FileController::secretCreate('\App\Models\LeedCommentFile', $this->id);
    }

    /**
     * Комментарий, к которому прикреплен файл.
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(LeedRecordComment::class, 'leed_record_comment_id');
    }

    /**
     * Пользователь, загрузивший файл.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
