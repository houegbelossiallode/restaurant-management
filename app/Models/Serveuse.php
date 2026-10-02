<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Serveuse extends Model
{
    protected $fillable = ['nom', 'telephone'];

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function getSoldeAttribute(): float
    {
        $totalDistributions = $this->distributions()->sum('montant_total');
        $totalPaiements = $this->paiements()->sum('montant');
        return $totalDistributions - $totalPaiements;
    }
}
