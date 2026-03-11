<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'pole',
        'description',
        'number',
        'date',
        'text',
        'string',
        'nullable',
        'is_web_link',
        'rules',
    ];

    public function boardFieldSetting(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BoardFieldSetting::class, 'pole', 'field_name');
    }

    /**
     * Отношение "один к одному" к OrderRequestsRename
     * Связь по полю order_requests_id в таблице order_requests_rename.
     */
    public function rename()
    {
        return $this->hasOne(OrderRequestsRename::class, 'order_requests_id', 'id');
    }

}
