<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['libelle', 'actif'];

    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }
}
