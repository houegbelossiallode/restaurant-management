<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sousmenu extends Model
{
    protected $fillable = ['libelle', 'route', 'menu_id', 'is_show', 'actif'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'sous_menu_id');
    }
}
