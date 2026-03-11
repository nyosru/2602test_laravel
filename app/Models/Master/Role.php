<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasPermissions;

class Role extends SpatieRole
{
    use HasPermissions;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'name_ru',
        'guard_name',
        'board_id',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Записи в pivot-таблице board_users (многие записи на одну роль).
     */
    public function boardUsers(): HasMany
    {
        return $this->hasMany(BoardUser::class);
    }

    //    /**
    //     * Метод для мягкого удаления роли с дополнительной логикой.
    //     *
    //     * @return void
    //     */
    //    public function softDelete()
    //    {
    //        // Дополнительная логика перед удалением, если нужна
    //        // Например, можно удалить или обновить связанные записи, связанные с этой ролью.
    //
    //        $this->delete(); // Это выполнит soft delete
    //    }

    //    /**
    //     * Восстановление удалённой роли.
    //     *
    //     * @return void
    //     */
    //    public function restoreRole()
    //    {
    //        $this->restore(); // Это восстановит удалённую роль
    //    }

    //    public function columns(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //    {
    //        return $this->belongsToMany(LeedColumn::class, 'column_role', 'role_id', 'column_id');
    //    }

    public function columns(): BelongsToMany
    {
        return $this->belongsToMany(LeedColumn::class, 'column_role', 'role_id', 'column_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function macroses()
    {
        return $this->belongsToMany(Macros::class, 'macro_role', 'role_id', 'macro_id');
    }

}
