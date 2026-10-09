<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Serveuse;
use App\Models\Boisson;
use App\Exports\DistributionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $distributions = $this->filteredDistributions($request)
            ->orderBy('date_distribution', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('distributions.index', compact('distributions'));
    }

    public function create()
    {
        $serveuses = Serveuse::select('id', 'nom')->get();
        $boissons = Boisson::select('id', 'nom', 'prix_unitaire')->get();
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

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new DistributionsExport($request->get('search'), $request->get('date_debut'), $request->get('date_fin')),
            'distributions_' . now()->format('Y-m-d_H-i') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $distributions = $this->filteredDistributions($request)
            ->orderBy('date_distribution', 'desc')
            ->get();
        $totalMontant = $distributions->sum(fn ($distribution) => $distribution->prix_unitaire * $distribution->quantite);

        return Pdf::loadView('distributions.pdf', compact('distributions', 'totalMontant'))
            ->download('distributions_' . now()->format('Y-m-d_H-i') . '.pdf');
    }

    private function filteredDistributions(Request $request)
    {
        $query = Distribution::with(['serveuse', 'boisson']);
        $search = trim((string) $request->get('search', ''));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->whereHas('serveuse', function ($serveuseQuery) use ($search) {
                    $serveuseQuery->where('nom', 'like', '%' . $search . '%');
                })->orWhereHas('boisson', function ($boissonQuery) use ($search) {
                    $boissonQuery->where('nom', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('date_debut')) {
            $query->where('date_distribution', '>=', $request->get('date_debut'));
        }

        if ($request->filled('date_fin')) {
            $query->where('date_distribution', '<=', $request->get('date_fin') . ' 23:59:59');
        }

        return $query;
    }
}
