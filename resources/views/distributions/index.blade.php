@extends('layouts.app')

@section('title', 'Historique des Distributions')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">Historique des Distributions</h1>
            <p class="mt-2 text-slate-500">Recherchez, consultez et exportez les distributions</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('distributions.export.excel', request()->query()) }}" class="inline-flex items-center gap-2 bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a2 2 0 01.707.293l5.414 5.414a2 2 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Export Excel
            </a>
            <a href="{{ route('distributions.export.pdf', request()->query()) }}" class="inline-flex items-center gap-2 bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2-2z" /></svg>
                Export PDF
            </a>
            <a href="{{ route('distributions.create') }}" class="inline-flex items-center gap-2 bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Nouvelle distribution</a>
        </div>
    </div>

    <form action="{{ route('distributions.index') }}" method="GET" class="grid grid-cols-1 gap-4 border border-slate-200 bg-white p-4 md:grid-cols-4">
        <div class="md:col-span-2">
            <label for="distribution-search" class="mb-2 block text-sm font-semibold text-slate-700">Serveuse ou boisson</label>
            <input id="distribution-search" type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher un nom" class="w-full border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        </div>
        <div>
            <label for="date-debut" class="mb-2 block text-sm font-semibold text-slate-700">Date de début</label>
            <input id="date-debut" type="date" name="date_debut" value="{{ request('date_debut') }}" class="w-full border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        </div>
        <div>
            <label for="date-fin" class="mb-2 block text-sm font-semibold text-slate-700">Date de fin</label>
            <input id="date-fin" type="date" name="date_fin" value="{{ request('date_fin') }}" class="w-full border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        </div>
        <div class="flex gap-2 md:col-span-4">
            <button type="submit" class="bg-blue-600 px-5 py-2 font-semibold text-white hover:bg-blue-700">Rechercher</button>
            @if(request('search') || request('date_debut') || request('date_fin'))
                <a href="{{ route('distributions.index') }}" class="bg-slate-100 px-5 py-2 font-semibold text-slate-700 hover:bg-slate-200">Réinitialiser</a>
            @endif
        </div>
    </form>

    <div class="overflow-hidden border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-blue-50 px-5 py-4">
            <h2 class="font-bold text-slate-800">Distributions ({{ $distributions->total() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px]">
                <thead class="bg-slate-100 text-left text-xs uppercase text-slate-700">
                    <tr>
                        <th class="border-b border-slate-300 px-4 py-3">Date</th>
                        <th class="border-b border-slate-300 px-4 py-3">Serveuse</th>
                        <th class="border-b border-slate-300 px-4 py-3">Boisson</th>
                        <th class="border-b border-slate-300 px-4 py-3">Quantité</th>
                        <th class="border-b border-slate-300 px-4 py-3">Prix unitaire</th>
                        <th class="border-b border-slate-300 px-4 py-3">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($distributions as $distribution)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $distribution->date_distribution?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $distribution->serveuse?->nom ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $distribution->boisson?->nom ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $distribution->quantite }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ number_format($distribution->prix_unitaire, 0) }} FCFA</td>
                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-blue-700">{{ number_format($distribution->prix_unitaire * $distribution->quantite, 0) }} FCFA</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-slate-500">Aucune distribution trouvée</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($distributions->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">{{ $distributions->links() }}</div>
        @endif
    </div>
</div>
@endsection