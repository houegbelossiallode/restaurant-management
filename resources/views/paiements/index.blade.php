@extends('layouts.app')

@section('title', 'Historique des Paiements')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Historique des Paiements</h1>
            <p class="text-slate-500">Consultez et exportez l'historique des paiements</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('paiements.export.excel', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white hover:bg-green-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </a>
            <a href="{{ route('paiements.export.pdf', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white hover:bg-red-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white shadow-xl border border-slate-100 p-6">
        <form action="{{ route('paiements.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Rechercher une serveuse</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Nom de la serveuse">
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Date de début</label>
                <input type="date" name="date_debut" value="{{ request('date_debut') }}" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>
            <div class="flex-1">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Date de fin</label>
                <input type="date" name="date_fin" value="{{ request('date_fin') }}" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg">
                    Rechercher
                </button>
                @if(request('search') || request('date_debut') || request('date_fin'))
                    <a href="{{ route('paiements.index') }}" class="ml-3 px-6 py-3 bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition-all duration-300">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Paiements Table -->
    <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Liste des Paiements</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Serveuse</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Boisson</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Quantité</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($paiements as $paiement)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-slate-600">{{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($paiement->serveuse->nom, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $paiement->serveuse->nom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $paiement->boisson->nom }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $paiement->quantite }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-emerald-600 bg-emerald-50">
                                    {{ number_format($paiement->montant, 0) }} FCFA
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">Aucun paiement trouvé</p>
                                <p class="text-sm">Commencez par enregistrer des paiements</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($paiements->hasPages())
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                {{ $paiements->appends(request()->all())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
