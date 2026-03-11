<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        //        'user_id',
        'name',
        'type',
    ];
    protected $guarded = [
        'deleted_at',
    ];

    /**
     * Пользователи проекта (многие-ко-многим).
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot(
                'role_id'
                //                , 'deleted'
            )
//            ->wherePivot('deleted', false) // только активные
            ->withTimestamps();
    }

    /**
     * Все записи в pivot (включая отключённых).
     */
    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }

    /**
     * Владелец проекта (первый добавленный или с role = 'owner').
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id'); // если оставили поле user_id как "создатель"
        // Или через pivot:
        // return $this->users()->wherePivot('role', 'owner')->first();
    }

    public function boards()
    {
        return $this->belongsToMany(Board::class)
            ->withPivot('for_project_sort')
            ->orderByPivot('for_project_sort', 'asc');
    }
}
