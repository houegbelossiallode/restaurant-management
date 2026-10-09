<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Serveuse;
use App\Models\Boisson;
use App\Models\Distribution;
use App\Exports\PaiementsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with(['serveuse', 'boisson']);

        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('serveuse', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('date_debut') && !empty($request->date_debut)) {
            $query->where('date_paiement', '>=', $request->date_debut);
        }

        if ($request->has('date_fin') && !empty($request->date_fin)) {
            $query->where('date_paiement', '<=', $request->date_fin . ' 23:59:59');
        }

        $paiements = $query->orderBy('date_paiement', 'desc')->paginate(20);

        return view('paiements.index', compact('paiements'));
    }

    public function create()
    {
        $serveuses = Serveuse::all();
        $boissons = Boisson::select('id', 'nom', 'prix_unitaire')->get();
        return view('paiements.create', compact('serveuses', 'boissons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serveuse_id' => 'required|exists:serveuses,id',
            'paiements' => 'required|array|min:1',
            'paiements.*.boisson_id' => 'required|exists:boissons,id',
            'paiements.*.quantite' => 'required|integer|min:1',
        ], [
            'paiements.required' => 'Vous devez configurer au moins un paiement.',
            'paiements.*.boisson_id.required' => 'Vous devez sélectionner une boisson pour chaque paiement.',
            'paiements.*.quantite.required' => 'La quantité est requise pour chaque paiement.',
        ]);

        $serveuse = Serveuse::find($validated['serveuse_id']);

        // Récupérer toutes les distributions de la serveuse
        $distributions = Distribution::where('serveuse_id', $validated['serveuse_id'])
            ->get()
            ->keyBy('boisson_id');

        // Calculer les quantités déjà payées par boisson
        $paiementsExistants = Paiement::where('serveuse_id', $validated['serveuse_id'])
            ->get()
            ->groupBy('boisson_id')
            ->map(function($paiements) {
                return $paiements->sum('quantite');
            });

        foreach ($validated['paiements'] as $paiementData) {
            $boissonId = $paiementData['boisson_id'];
            $quantiteDemandee = $paiementData['quantite'];
            $boisson = Boisson::find($boissonId);

            // Vérifier si la boisson existe dans les distributions
            if (!$distributions->has($boissonId)) {
                return redirect()->back()->with('error', "La boisson \"{$boisson->nom}\" n'a pas été distribuée à cette serveuse.")->withInput();
            }

            // Calculer la quantité totale déjà payée pour cette boisson
            $quantiteDejaPayee = $paiementsExistants->get($boissonId, 0);

            // Calculer la quantité disponible (distribuée - déjà payée)
            $quantiteDisponible = $distributions->get($boissonId)->quantite - $quantiteDejaPayee;

            // Vérifier si la quantité demandée est disponible
            if ($quantiteDemandee > $quantiteDisponible) {
                return redirect()->back()->with('error', "Quantité insuffisante pour \"{$boisson->nom}\". Disponible: {$quantiteDisponible}, Demandé: {$quantiteDemandee}.")->withInput();
            }
        }

        foreach ($validated['paiements'] as $paiementData) {
            $boisson = Boisson::find($paiementData['boisson_id']);
            $montant = $paiementData['quantite'] * $boisson->prix_unitaire;

            Paiement::create([
                'serveuse_id' => $validated['serveuse_id'],
                'boisson_id' => $paiementData['boisson_id'],
                'quantite' => $paiementData['quantite'],
                'montant' => $montant,
                'description' => null,
                'date_paiement' => now(),
            ]);
        }

        return redirect()->route('dashboard')->with('success', count($validated['paiements']) . ' paiement(s) enregistré(s) avec succès.');
    }

    public function exportExcel(Request $request)
    {
        $search = $request->get('search');
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');
        return Excel::download(new PaiementsExport($search, $dateDebut, $dateFin), 'paiements_' . now()->format('Y-m-d_H-i') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Paiement::with(['serveuse', 'boisson']);

        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('serveuse', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('date_debut') && !empty($request->date_debut)) {
            $query->where('date_paiement', '>=', $request->date_debut);
        }

        if ($request->has('date_fin') && !empty($request->date_fin)) {
            $query->where('date_paiement', '<=', $request->date_fin . ' 23:59:59');
        }

        $paiements = $query->orderBy('date_paiement', 'desc')->get();

        $pdf = PDF::loadView('paiements.pdf', compact('paiements'));
        return $pdf->download('paiements_' . now()->format('Y-m-d_H-i') . '.pdf');
    }
}
