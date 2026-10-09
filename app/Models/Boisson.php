<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Distribution;
use App\Models\Paiement;

class Boisson extends Model
{
    protected $fillable = ['nom', 'prix_unitaire'];

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}
