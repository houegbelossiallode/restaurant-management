@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Actions rapides -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Tableau de Bord</h1>
            <p class="text-slate-500 text-sm">Vue d'ensemble de votre restaurant</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('distributions.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Distribution
            </a>
            <a href="{{ route('paiements.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg hover:shadow-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Paiement
            </a>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Distributions</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ number_format($totalDistributions, 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-blue-200 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-blue-300 rounded-t" style="height: 60%"></div>
                <div class="flex-1 bg-blue-400 rounded-t" style="height: 80%"></div>
                <div class="flex-1 bg-blue-500 rounded-t" style="height: 50%"></div>
                <div class="flex-1 bg-blue-600 rounded-t" style="height: 70%"></div>
                <div class="flex-1 bg-blue-500 rounded-t" style="height: 90%"></div>
                <div class="flex-1 bg-blue-400 rounded-t" style="height: 60%"></div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Paiements</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ number_format($totalPaiements, 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 bg-emerald-200 rounded-t" style="height: 30%"></div>
                <div class="flex-1 bg-emerald-300 rounded-t" style="height: 50%"></div>
                <div class="flex-1 bg-emerald-400 rounded-t" style="height: 70%"></div>
                <div class="flex-1 bg-emerald-500 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-emerald-600 rounded-t" style="height: 80%"></div>
                <div class="flex-1 bg-emerald-500 rounded-t" style="height: 60%"></div>
                <div class="flex-1 bg-emerald-400 rounded-t" style="height: 90%"></div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Solde Global</p>
                    <p class="text-2xl font-bold {{ $soldeGlobal > 0 ? 'bg-gradient-to-r from-red-600 to-rose-600' : 'bg-gradient-to-r from-emerald-600 to-teal-600' }} bg-clip-text text-transparent">{{ number_format($soldeGlobal, 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br {{ $soldeGlobal > 0 ? 'from-red-500 to-red-600' : 'from-emerald-500 to-emerald-600' }} flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-12 flex items-end space-x-1">
                <div class="flex-1 {{ $soldeGlobal > 0 ? 'bg-red-200' : 'bg-emerald-200' }} rounded-t" style="height: 20%"></div>
                <div class="flex-1 {{ $soldeGlobal > 0 ? 'bg-red-300' : 'bg-emerald-300' }} rounded-t" style="height: 40%"></div>
                <div class="flex-1 {{ $soldeGlobal > 0 ? 'bg-red-400' : 'bg-emerald-400' }} rounded-t" style="height: 30%"></div>
                <div class="flex-1 {{ $soldeGlobal > 0 ? 'bg-red-500' : 'bg-emerald-500' }} rounded-t" style="height: 50%"></div>
                <div class="flex-1 {{ $soldeGlobal > 0 ? 'bg-red-600' : 'bg-emerald-600' }} rounded-t" style="height: 40%"></div>
                <div class="flex-1 {{ $soldeGlobal > 0 ? 'bg-red-500' : 'bg-emerald-500' }} rounded-t" style="height: 30%"></div>
                <div class="flex-1 {{ $soldeGlobal > 0 ? 'bg-red-400' : 'bg-emerald-400' }} rounded-t" style="height: 20%"></div>
            </div>
        </div>
    </div>

    <!-- Liste des serveuses -->
    <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">Solde des Serveuses</h2>
                </div>
                <a href="{{ route('serveuses.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center space-x-1">
                    <span>Voir tout</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Serveuse</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Solde</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($serveuses as $serveuse)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                        {{ substr($serveuse->nom, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $serveuse->nom }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $serveuse->telephone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold {{ $serveuse->solde > 0 ? 'text-red-600 bg-red-50' : 'text-emerald-600 bg-emerald-50' }}">
                                    {{ number_format($serveuse->solde, 0) }} FCFA
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('serveuses.show', $serveuse->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>Détails</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
