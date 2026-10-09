<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermission extends Model
{
    protected $fillable = ['sous_menu_id', 'role_id', 'is_granted', 'actif'];

    protected $casts = [
        'is_granted' => 'boolean',
    ];

    public function sousmenu(): BelongsTo
    {
        return $this->belongsTo(Sousmenu::class, 'sous_menu_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
