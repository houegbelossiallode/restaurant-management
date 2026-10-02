<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Serveuse;
use App\Models\Boisson;

class DistributionController extends Controller
{
    public function create()
    {
        $serveuses = Serveuse::all();
        $boissons = Boisson::all();
        return view('distributions.create', compact('serveuses', 'boissons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serveuse_id' => 'required|exists:serveuses,id',
            'distributions' => 'required|array|min:1',
            'distributions.*.boisson_id' => 'required|exists:boissons,id',
            'distributions.*.quantite' => 'required|integer|min:1',
        ], [
            'distributions.required' => 'Vous devez configurer au moins une distribution.',
            'distributions.*.boisson_id.required' => 'Vous devez sélectionner une boisson pour chaque distribution.',
            'distributions.*.quantite.required' => 'La quantité est requise pour chaque distribution.',
        ]);

        foreach ($validated['distributions'] as $distributionData) {
            $boisson = Boisson::find($distributionData['boisson_id']);
            $montantTotal = $boisson->prix_unitaire * $distributionData['quantite'];

            Distribution::create([
                'serveuse_id' => $validated['serveuse_id'],
                'boisson_id' => $distributionData['boisson_id'],
                'quantite' => $distributionData['quantite'],
                'prix_unitaire' => $boisson->prix_unitaire,
                'montant_total' => $montantTotal,
                'date_distribution' => now(),
            ]);
        }

        return redirect()->route('dashboard')->with('success', count($validated['distributions']) . ' distribution(s) enregistrée(s) avec succès.');
    }
}
