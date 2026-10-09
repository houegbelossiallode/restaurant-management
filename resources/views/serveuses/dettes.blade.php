@extends('layouts.app')

@section('title', 'Dettes des Serveuses')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Dettes des Serveuses</h1>
        <p class="text-slate-500">Récapitulatif des montants dus par chaque serveuse</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:gap-6 xl:grid-cols-4">
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total des dettes</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">{{ number_format($serveuses->where('solde', '>', 0)->sum('solde'), 0) }} FCFA</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Serveuses en dette</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">{{ $serveuses->where('solde', '>', 0)->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total distributions</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ number_format($serveuses->sum(function($s) { return $s->distributions->sum('montant_total'); }), 0) }} FCFA</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total paiements</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ number_format($serveuses->sum(function($s) { return $s->paiements->sum('montant'); }), 0) }} FCFA</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des dettes -->
    <div class="bg-white shadow-xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Détail des dettes par serveuse</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Serveuse</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Téléphone</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Total Distributions</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Total Paiements</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Solde (Dette)</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Statut</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($serveuses as $serveuse)
                        @php
                            $totalDistributions = $serveuse->distributions->sum('montant_total');
                            $totalPaiements = $serveuse->paiements->sum('montant');
                            $solde = $serveuse->solde;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors duration-200 {{ $solde > 0 ? 'bg-red-50/50' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold rounded-lg">
                                        {{ substr($serveuse->nom, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $serveuse->nom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $serveuse->telephone ?? '-' }}</td>
                            <td class="px-6 py-4 text-right text-slate-700 font-medium">{{ number_format($totalDistributions, 0) }} FCFA</td>
                            <td class="px-6 py-4 text-right text-slate-700 font-medium">{{ number_format($totalPaiements, 0) }} FCFA</td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold rounded-lg {{ $solde > 0 ? 'text-red-600 bg-red-100' : ($solde < 0 ? 'text-emerald-600 bg-emerald-100' : 'text-slate-600 bg-slate-100') }}">
                                    {{ number_format($solde, 0) }} FCFA
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($solde > 0)
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        En dette
                                    </span>
                                @elseif($solde < 0)
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        À jour
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold text-slate-700 bg-slate-100 rounded-full">
                                        Équilibré
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('serveuses.show', $serveuse->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200 text-xs font-medium rounded-lg">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Détails
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
