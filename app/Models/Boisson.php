<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boisson extends Model
{
    protected $fillable = ['nom', 'prix_unitaire', 'stock_actuel'];

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}
