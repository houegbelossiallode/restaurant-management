<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = ['serveuse_id', 'boisson_id', 'quantite', 'montant', 'date_paiement', 'description'];

    protected $casts = [
        'date_paiement' => 'datetime',
    ];

    public function serveuse(): BelongsTo
    {
        return $this->belongsTo(Serveuse::class);
    }

    public function boisson(): BelongsTo
    {
        return $this->belongsTo(Boisson::class);
    }
}
