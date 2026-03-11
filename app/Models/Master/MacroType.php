<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MacroType extends Model
{
    use SoftDeletes; // если в миграции добавляли

    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * Отношение с моделью Macros.
     */
    public function macros(): HasMany
    {
        return $this->hasMany(Macros::class, 'type_id'); // type_id - внешний ключ (создадим ниже)
    }
}
