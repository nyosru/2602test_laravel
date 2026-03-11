<?php

namespace App\Models\Master;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\SendsVkNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    //    use HasRoles;
    use SoftDeletes;
    //    use SendsVkNotifications;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_board_id',
        'phone_number',
        'telegram_id',
        'vk_id',
        'vk_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'vk_token' => 'encrypted',
    ];

    public function getRoleNameInProject($projectId): string
    {
        $pivot = $this->projectUsers()
            ->where('project_id', $projectId)
            ->where('deleted', false)
            ->first();

        return $pivot?->role?->name_ru ?? '—';
    }

    // Связь с досками (многие ко многим)
    //    public function boards()
    //    {
    //        return $this->belongsToMany(Board::class)
    //            ->withPivot('role_id');
    //    }

    /**
     * Проекты, в которых участвует пользователь.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withPivot('role_id', 'deleted')
            ->wherePivot('deleted', false)
            ->withTimestamps();
    }

    /**
     * Проекты, где пользователь — владелец (по роли).
     */
    public function ownedProjects()
    {
        return $this->projects()->wherePivot('role_id', Role::where('name', 'owner')->first()?->id);
    }

    /**
     * Все записи связки пользователя с проектами (pivot)
     * Включает отключённых (deleted = true).
     */
    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }

    /**
     * Активные записи связки (пользователь участвует в проекте).
     */
    public function activeProjectUsers()
    {
        return $this->hasMany(ProjectUser::class)
            ->where('deleted', false);
    }

    /**
     * Получить роль пользователя в конкретном проекте.
     *
     * @param int|Project $project
     */
    public function getRoleInProject($project): ?Role
    {
        $projectId = $project instanceof Project ? $project->id : $project;

        return $this->projects()
            ->where('project_id', $projectId)
            ->first()
            ?->pivot
            ?->role;
    }

    public function boardUser()
    {
        return $this->hasMany(BoardUser::class);
    }

    // Связь с доской (current_board)
    public function currentBoard()
    {
        return $this->belongsTo(Board::class, 'current_board_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Домены, которыми управляет пользователь (администратор).
     */
    public function domains()
    {
        return $this->hasMany(Domain::class, 'admin_user_id');
    }

    /**
     * Отношение к новостям, которые пользователь создал.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_user_id');
    }

    /**
     * Отношение к опубликованным новостям
     */
    public function publishedNews(): HasMany
    {
        return $this->news()->published();
    }

    // В модели User добавляем:
    public function boardSettings(): HasMany
    {
        return $this->hasMany(BoardUserSetting::class);
    }

    /**
     * Получить все доски, к которым пользователь имеет доступ
     * (либо он администратор доски, либо добавлен как участник).
     */
    public function accessibleBoards()
    {
        return \App\Models\Board::where(function ($query) {
            $query->where('admin_user_id', $this->id)
                ->orWhereHas('boardUsers', function ($q) {
                    $q->where('user_id', $this->id)
                        ->whereNull('deleted_at'); // учитываем soft delete в board_users, если есть
                });
        });
    }

    public function hasPermission($permissionName)
    {
        return $this->roles
            ->flatMap->permissions
            ->pluck('name')
            ->contains($permissionName);
    }

}
