<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boisson;
use App\Http\Controllers\Controller;

class BoissonController extends Controller
{
    public function index()
    {
        $boissons = Boisson::all();
        return view('boissons.index', compact('boissons'));
    }

    public function create()
    {
        return view('boissons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'stock_actuel' => 'required|integer|min:0',
        ]);

        Boisson::create($validated);
        return redirect()->route('boissons.index')->with('success', 'Boisson ajoutée avec succès.');
    }

    public function edit(Boisson $boisson)
    {
        return view('boissons.edit', compact('boisson'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
            'stock_actuel' => 'required|integer|min:0',
        ]);

        $boisson = Boisson::findOrFail($id);
        $boisson->update($validated);
        return redirect()->route('boissons.index')->with('success', 'Boisson modifiée avec succès.');
    }

    public function destroy(Boisson $boisson)
    {
        $boisson->delete();
        return redirect()->route('boissons.index')->with('success', 'Boisson supprimée avec succès.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $boissons = Boisson::where('nom', 'like', '%' . $query . '%')
            ->select('id', 'nom', 'prix_unitaire')
            ->groupBy('id', 'nom', 'prix_unitaire')
            ->limit(10)
            ->get();
        return response()->json($boissons);
    }
}
