<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'domain',
        'domain_ru',
        'admin_user_id',
    ];

    /**
     * Связь с администратором домена (пользователем).
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Связь с досками, использующими этот домен.
     */
    public function boards(): HasMany
    {
        return $this->hasMany(Board::class, 'domain_id');
    }

}
