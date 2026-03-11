<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'second_db';

    protected $fillable = [
        'name',
        'is_paid',
        'admin_user_id',
        'admin_user_id',
        'domain_id',
        'view',
        'can_get_copy_other_board',
        'show_roles_for_transfer',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'show_roles_for_transfer' => 'boolean',
        'can_get_copy_other_board' => 'boolean',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    // Связь с пользователями (многие ко многим)
    public function users()
    {
        return $this->belongsToMany(User::class, 'board_users')
            ->withPivot('role_id');
    }

    // Обратная связь с пользователями через current_board_id
    public function currentUsers()
    {
        return $this->hasMany(User::class, 'current_board_id');
    }

    //    // Связь с ролью через pivot-таблицу
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Связь с записями в таблице board_user (один ко многим)
    public function boardUsers(): HasMany
    {
        return $this->hasMany(BoardUser::class);
    }

    // Связь с записями в таблице board_user (один ко многим)
    public function columns(): HasMany
    {
        return $this->hasMany(LeedColumn::class);
    }

    /**
     * конфиг полей для показа в лидах.
     */
    public function fieldSettings(): HasMany
    {
        return $this->hasMany(BoardFieldSetting::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Связь с доменом (один к одному, domain_id может быть null).
     */
    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    /**
     * Связь с пользовательскими настройками доски.
     */
    public function userSettings(): HasMany
    {
        return $this->hasMany(BoardUserSetting::class);
    }

    /**
     * Связь с новостями доски.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function documentTemplates()
    {
        return $this->hasMany(BoardDocumentTemplate::class);
    }

}
