<?php

namespace App\Http\Controllers;

use App\Models\Serveuse;
use Illuminate\Http\Request;

class ServeuseController extends Controller
{
    public function index()
    {
        $serveuses = Serveuse::with(['distributions', 'paiements'])->get();
        return view('serveuses.index', compact('serveuses'));
    }

    public function create()
    {
        return view('serveuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        Serveuse::create($validated);
        return redirect()->route('serveuses.index')->with('success', 'Serveuse ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $serveuse = Serveuse::findOrFail($id);
        $serveuse->update($validated);
        return redirect()->route('serveuses.index')->with('success', 'Serveuse modifiée avec succès.');
    }

    public function destroy(Serveuse $serveuse)
    {
        $serveuse->delete();
        return redirect()->route('serveuses.index')->with('success', 'Serveuse supprimée avec succès.');
    }

    public function show($id)
    {
        $serveuse = Serveuse::with(['distributions' => function($q) {
            $q->with('boisson')->orderBy('date_distribution', 'desc');
        }, 'paiements' => function($q) {
            $q->with('boisson')->orderBy('date_paiement', 'desc');
        }])->findOrFail($id);

        return view('serveuses.show', compact('serveuse'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $serveuses = Serveuse::where('nom', 'like', '%' . $query . '%')
            ->select('id', 'nom', 'solde')
            ->limit(10)
            ->get();
        return response()->json($serveuses);
    }
}
