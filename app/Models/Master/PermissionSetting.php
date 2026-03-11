<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission;

class PermissionSetting extends Model
{
    protected $fillable = [
        'permission_id',
        'for_start',
    ];

    protected $casts = [
        'for_start' => 'boolean',
    ];

    // Связь с Permission
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
