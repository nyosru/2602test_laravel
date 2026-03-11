<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'project_user';

    protected $fillable = [
        'project_id',
        'user_id',
        'role_id',
        'deleted',
    ];

    // Связь с проектом
    public function project()
    {
        return $this->belongsTo(Project::class);
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
