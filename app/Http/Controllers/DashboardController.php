<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serveuse;
use App\Models\Boisson;
use App\Models\Distribution;
use App\Models\Paiement;

class DashboardController extends Controller
{
    public function index()
    {
        $serveuses = Serveuse::with(['distributions', 'paiements'])->get();
        $totalDistributions = Distribution::sum('montant_total');
        $totalPaiements = Paiement::sum('montant');
        $soldeGlobal = $totalDistributions - $totalPaiements;
        $boissons = Boisson::all();

        return view('dashboard', compact('serveuses', 'totalDistributions', 'totalPaiements', 'soldeGlobal', 'boissons'));
    }
}
