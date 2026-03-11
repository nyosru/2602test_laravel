<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequestsRename extends Model
{
    use HasFactory;
    protected $table = 'order_requests_renames';

    protected $fillable = [
        'board_id',
        'order_requests_id',
        'name',
        'description',
    ];

    /**
     * Связь с доской.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Связь с заявкой.
     */
    public function orderRequest()
    {
        return $this->belongsTo(OrderRequest::class, 'order_requests_id');
    }

}
