<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'second_db';
    protected $table = 'board_users';

    protected $fillable = [
        'board_id',
        'user_id',
        'role_id',
        'deleted',
    ];

    // Связь с доской
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с ролью
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
