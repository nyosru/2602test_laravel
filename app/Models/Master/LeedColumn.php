<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeedColumn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'leed_columns';
    protected $connection = 'second_db';
    protected $fillable = [
        'name',
        'user_id',
        'board_id',
        'order',
        'can_move',
        'can_delete',
        'head_type',
        'type_otkaz',
        'can_create',
        'can_accept_contract',
        'can_get',
        'bg_color', // новое поле
        'border_color', // новое поле
    ];

    protected $casts = [
        'can_move' => 'boolean',
        'can_delete' => 'boolean',
        'can_create' => 'boolean',
        'can_accept_contract' => 'boolean',
        'can_get' => 'boolean',
        'order' => 'integer',
        'deleted_at' => 'datetime',
        'bg_color' => 'string', // новое
        'border_color' => 'string', // новое
    ];

    /**
     * вытаскиваем только колонки очереди.
     *
     * @if($column->is_queue) ** @endif
     */
    public function getIsQueueAttribute()
    {
        return $this->settings->pluck('key')->intersect(['preparation', 'arrived', 'departed'])->isNotEmpty();
    }

    public function getQueueTypeAttribute(): ?string
    {
        return $this->settings
            ->where('boolean_value', true)
            ->first()?->key;
    }

    /**
     * Дополнительные настройки колонки.
     */
    public function settings()
    {
        return $this->hasMany(LeedColumnSetting::class, 'leed_column_id');
    }

    /**
     * Отношение к записям лидов.
     */
    public function records(): HasMany
    {
        return $this->hasMany(LeedRecord::class);
    }

    /**
     * Отношение к ролям с доступом к колонке.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'column_role', 'column_id', 'role_id')
            ->withTimestamps();
    }

    /**
     * Отношение к доске.
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Отношение к пользователю (создателю колонки).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope для колонок определенной доски.
     */
    public function scopeForBoard(Builder $query, int $boardId): Builder
    {
        return $query->where('board_id', $boardId);
    }

    /**
     * Scope для активных колонок (не удаленных).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope для колонок с возможностью создания.
     */
    public function scopeCanCreate(Builder $query): Builder
    {
        return $query->where('can_create', true);
    }

    /**
     * Проверка, может ли колонка принимать контракты.
     */
    public function canAcceptContract(): bool
    {
        return (bool) $this->can_accept_contract;
    }

    // Если у вас связь many-to-one (каждая колонка имеет один цвет)
    public function backgroundColor()
    {
        return $this->belongsToMany(
            LeedColumnBackgroundColor::class,
            'leed_column_color_assignments', // имя таблицы связи
            'leed_column_id',
            'background_color_id'
        )->withTimestamps();
    }

    // Если предполагается, что одна колонка имеет ровно один цвет, и таблица связи есть
    public function currentBackgroundColor()
    {
        return $this->backgroundColor()->first();
    }

    /**
     * Проверка, можно ли перемещать лиды из этой колонки.
     */
    public function canMoveLeeds(): bool
    {
        return (bool) $this->can_move;
    }

    /**
     * Получить следующее значение порядка для новой колонки.
     */
    public static function getNextOrder(int $boardId): int
    {
        return static::where('board_id', $boardId)->max('order') + 1;
    }

    /**
     * Переместить колонку в новую позицию.
     */
    public function moveToPosition(int $newPosition): void
    {
        // Логика изменения порядка колонок
        $currentOrder = $this->order;

        if ($newPosition > $currentOrder) {
            static::where('board_id', $this->board_id)
                ->where('order', '>', $currentOrder)
                ->where('order', '<=', $newPosition)
                ->decrement('order');
        } else {
            static::where('board_id', $this->board_id)
                ->where('order', '>=', $newPosition)
                ->where('order', '<', $currentOrder)
                ->increment('order');
        }

        $this->order = $newPosition;
        $this->save();
    }

    /**
     * Проверить, имеет ли колонка указанную роль.
     */
    public function hasRole($role): bool
    {
        if (is_numeric($role)) {
            return $this->roles()->where('id', $role)->exists();
        }

        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }

        if ($role instanceof Role) {
            return $this->roles()->where('id', $role->id)->exists();
        }

        return false;
    }

    /**
     * Добавить роль к колонке.
     */
    public function assignRole($role): void
    {
        if (is_numeric($role)) {
            $this->roles()->attach($role);
        } elseif (is_string($role)) {
            $roleModel = Role::where('name', $role)->first();
            if ($roleModel) {
                $this->roles()->attach($roleModel->id);
            }
        } elseif ($role instanceof Role) {
            $this->roles()->attach($role->id);
        }
    }

    /**
     * Удалить роль из колонки.
     */
    public function removeRole($role): void
    {
        if (is_numeric($role)) {
            $this->roles()->detach($role);
        } elseif (is_string($role)) {
            $roleModel = Role::where('name', $role)->first();
            if ($roleModel) {
                $this->roles()->detach($roleModel->id);
            }
        } elseif ($role instanceof Role) {
            $this->roles()->detach($role->id);
        }
    }

    /**
     * Синхронизировать роли колонки.
     */
    public function syncRoles(array $roleIds): void
    {
        $this->roles()->sync($roleIds);
    }

    /**
     * Получить ID ролей, имеющих доступ к колонке.
     */
    public function getRoleIdsAttribute(): array
    {
        return $this->roles->pluck('id')->toArray();
    }

    // //
    // //    /**
    // //     * Отношение к макросам
    // //     */
    // //    public function macros(): BelongsToMany
    // //    {
    // //        return $this->belongsToMany(
    // //            Macros::class,
    // //            'macro_column',
    // //            'column_id',
    // //            'macro_id'
    // //        )
    // //    }
    //    public function macros()
    //    {
    //        // Связь многие ко многим через таблицу macro_columns
    //        return $this->belongsToMany(Macros::class,
    //            'macro_columns',
    //            'column_id',
    //            'macro_id'
    //        )->withTimestamps();
    //    }

    /**
     * Макросы-условия, привязанные к этой колонке.
     */
    public function macroConditions()
    {
        return $this->hasMany(MacroCondition::class, 'column_id');
    }

}
