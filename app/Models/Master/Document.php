<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        //        'board_id',
        'leed_id',
        'template_id',
        'name',
        'content',
        //        'url_template',
    ];

    public function leed()
    {
        return $this->belongsTo(LeedRecord::class, 'leed_id');
    }

    public function template()
    {
        return $this->belongsTo(BoardDocumentTemplate::class, 'template_id');
    }

}
