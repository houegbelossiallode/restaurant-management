<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = ['libelle', 'actif'];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
