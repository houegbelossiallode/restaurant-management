<?php

namespace App\Http\Controllers;

use App\Models\Boisson;
use App\Models\Paiement;
use App\Models\Serveuse;
use App\Models\Distribution;
use App\Http\Controllers\Controller;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $totalBoissons = Boisson::count();
        $totalDistributions = Distribution::sum('montant_total');
        $totalPaiements = Paiement::sum('montant');
        $totalServeuses = Serveuse::count();

        // Données pour le graphique des boissons les plus distribuées
        $boissonsStats = Distribution::with('boisson')
            ->selectRaw('boisson_id, SUM(quantite) as total_quantite, SUM(montant_total) as total_montant')
            ->groupBy('boisson_id')
            ->orderByDesc('total_quantite')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'nom' => $item->boisson->nom ?? 'Inconnu',
                    'quantite' => $item->total_quantite,
                    'montant' => $item->total_montant,
                ];
            });

        // Données pour le graphique des paiements par mois
        $paiementsParMois = Paiement::selectRaw('DATE_FORMAT(date_paiement, "%Y-%m") as mois, SUM(montant) as total')
            ->where('date_paiement', '>=', now()->subMonths(6))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Données pour le graphique des distributions par serveuse
        $distributionsParServeuse = Distribution::with('serveuse')
            ->selectRaw('serveuse_id, SUM(montant_total) as total_montant, COUNT(*) as nb_distributions')
            ->groupBy('serveuse_id')
            ->orderByDesc('total_montant')
            ->get()
            ->map(function ($item) {
                return [
                    'nom' => $item->serveuse->nom ?? 'Inconnu',
                    'montant' => $item->total_montant,
                    'nb_distributions' => $item->nb_distributions,
                ];
            });

        // Données pour le graphique comparatif distributions vs paiements
        $comparatif = [];
        for ($i = 5; $i >= 0; $i--) {
            $mois = now()->subMonths($i)->format('Y-m');
            $dist = Distribution::whereRaw('DATE_FORMAT(date_distribution, "%Y-%m") = ?', [$mois])->sum('montant_total');
            $pai = Paiement::whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$mois])->sum('montant');
            $comparatif[] = [
                'mois' => now()->subMonths($i)->format('M Y'),
                'distributions' => $dist,
                'paiements' => $pai,
            ];
        }

        return view('statistiques.index', compact(
            'totalBoissons',
            'totalDistributions',
            'totalPaiements',
            'totalServeuses',
            'boissonsStats',
            'paiementsParMois',
            'distributionsParServeuse',
            'comparatif'
        ));
    }
}
