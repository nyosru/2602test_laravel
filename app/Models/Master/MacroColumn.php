<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class MacroColumn extends Model
{
    //    protected $table = 'macro_column';

    protected $fillable = [
        'macro_id',
        'column_id',
    ];

    public $timestamps = true;

    // Связь с макросом
    public function macro()
    {
        return $this->belongsTo(Macros::class, 'macro_id');
    }

    // Связь с колонкой
    public function column()
    {
        return $this->belongsTo(LeedColumn::class, 'column_id');
    }
}
