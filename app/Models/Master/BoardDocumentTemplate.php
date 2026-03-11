<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardDocumentTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'second_db';
    protected $fillable = [
        'board_id',
        'name',
        'file_path',
        'content',
        'description',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
