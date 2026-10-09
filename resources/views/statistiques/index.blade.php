@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Statistiques</h1>
        <p class="text-slate-500">Vue d'ensemble des performances de votre restaurant</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:gap-6 xl:grid-cols-4">
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Boissons</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $totalBoissons }}</p>
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
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Distributions</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ number_format($totalDistributions, 0) }} FCFA</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Paiements</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ number_format($totalPaiements, 0) }} FCFA</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Serveuses</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">{{ $totalServeuses }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Boissons les plus distribuées -->
        <div class="bg-white shadow-xl border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Boissons les plus distribuées</h2>
            <canvas id="boissonsChart" height="300"></canvas>
        </div>

        <!-- Paiements par mois -->
        <div class="bg-white shadow-xl border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Évolution des paiements (6 derniers mois)</h2>
            <canvas id="paiementsChart" height="300"></canvas>
        </div>

        <!-- Distributions par serveuse -->
        <div class="bg-white shadow-xl border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Distributions par serveuse</h2>
            <canvas id="serveusesChart" height="300"></canvas>
        </div>

        <!-- Comparatif Distributions vs Paiements -->
        <div class="bg-white shadow-xl border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Distributions vs Paiements</h2>
            <canvas id="comparatifChart" height="300"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Boissons les plus distribuées
    const boissonsCtx = document.getElementById('boissonsChart').getContext('2d');
    new Chart(boissonsCtx, {
        type: 'bar',
        data: {
            labels: @json($boissonsStats->pluck('nom')),
            datasets: [{
                label: 'Quantité distribuée',
                data: @json($boissonsStats->pluck('quantite')),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Paiements par mois
    const paiementsCtx = document.getElementById('paiementsChart').getContext('2d');
    new Chart(paiementsCtx, {
        type: 'line',
        data: {
            labels: @json($paiementsParMois->pluck('mois')),
            datasets: [{
                label: 'Montant (FCFA)',
                data: @json($paiementsParMois->pluck('total')),
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Distributions par serveuse
    const serveusesCtx = document.getElementById('serveusesChart').getContext('2d');
    new Chart(serveusesCtx, {
        type: 'doughnut',
        data: {
            labels: @json($distributionsParServeuse->pluck('nom')),
            datasets: [{
                data: @json($distributionsParServeuse->pluck('montant')),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(20, 184, 166, 0.8)',
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(34, 197, 94, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Comparatif Distributions vs Paiements
    const comparatifCtx = document.getElementById('comparatifChart').getContext('2d');
    new Chart(comparatifCtx, {
        type: 'bar',
        data: {
            labels: @json($comparatif->pluck('mois')),
            datasets: [
                {
                    label: 'Distributions',
                    data: @json($comparatif->pluck('distributions')),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)'
                },
                {
                    label: 'Paiements',
                    data: @json($comparatif->pluck('paiements')),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
