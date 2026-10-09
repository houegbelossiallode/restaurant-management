<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = ['libelle', 'icone', 'module_id', 'actif'];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function sousmenus(): HasMany
    {
        return $this->hasMany(Sousmenu::class);
    }
}
