<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distribution extends Model
{
    protected $fillable = ['serveuse_id', 'boisson_id', 'quantite', 'prix_unitaire', 'montant_total', 'date_distribution'];

    protected $casts = [
        'date_distribution' => 'datetime',
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
