<?php

namespace App\Http\Controllers;

use App\Models\Serveuse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            ->select('id', 'nom')
            ->withSum('distributions', 'montant_total')
            ->withSum('paiements', 'montant')
            ->limit(10)
            ->get()
            ->map(fn (Serveuse $serveuse) => [
                'id' => $serveuse->id,
                'nom' => $serveuse->nom,
                'solde' => (float) ($serveuse->distributions_sum_montant_total ?? 0)
                    - (float) ($serveuse->paiements_sum_montant ?? 0),
            ]);

        return response()->json($serveuses);
    }

    public function dettes(Request $request)
    {
        $sixMonthsAgo = now()->subMonths(6);

        $query = Serveuse::select('serveuses.*')
            ->selectRaw('COALESCE((SELECT SUM(montant_total) FROM distributions WHERE serveuse_id = serveuses.id AND date_distribution >= ?), 0) as total_distributions', [$sixMonthsAgo])
            ->selectRaw('COALESCE((SELECT SUM(montant) FROM paiements WHERE serveuse_id = serveuses.id AND date_paiement >= ?), 0) as total_paiements', [$sixMonthsAgo]);

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . trim($request->search) . '%');
        }

        $serveuses = $query->orderBy('nom')
            ->get()
            ->map(function ($serveuse) {
                $serveuse->solde = $serveuse->total_distributions - $serveuse->total_paiements;
                return $serveuse;
            });

        return view('serveuses.dettes', compact('serveuses'));
    }
}
