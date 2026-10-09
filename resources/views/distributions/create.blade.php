@extends('layouts.app')

@section('title', 'Enregistrer des Distributions')

@section('content')
<div class="w-full">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800 mb-2 sm:text-3xl">Enregistrer des Distributions</h1>
        <p class="text-slate-500">Distribuez plusieurs boissons à une serveuse en une seule fois</p>
    </div>

    <div class="bg-white shadow-xl border border-slate-100 p-4 sm:p-6 lg:p-8">
        <form action="{{ route('distributions.store') }}" method="POST" id="distributionForm" class="space-y-6">
            @csrf
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <label class="block text-slate-700 text-sm font-semibold mb-2">Serveuse</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="serveuseSearch" name="serveuse_search" class="w-full pl-12 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Rechercher une serveuse" autocomplete="off">
                    <input type="hidden" id="serveuse_id" name="serveuse_id">
                    <div id="serveuseSuggestions" class="absolute z-[10000] w-full bg-white border border-slate-200 shadow-xl mt-1 hidden max-h-48 overflow-y-auto"></div>
                </div>
                @error('serveuse_id')
                    <p class="mt-2 text-red-500 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="border-t border-slate-200 pt-6">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">Détails des distributions</h2>
                    <button type="button" onclick="addDistributionRow()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajouter une distribution
                    </button>
                </div>

                <div id="distributionsContainer" class="space-y-4">
                    <!-- Les lignes de distribution seront ajoutées ici dynamiquement -->
                </div>
            </div>

            <!-- Résumé des distributions -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 border border-blue-200">
                <h3 class="text-sm font-semibold text-blue-800 mb-3">Résumé des distributions</h3>
                <div id="distributionsSummary" class="space-y-2">
                    <p class="text-sm text-slate-600">Aucune distribution configurée</p>
                </div>
                <div class="mt-3 pt-3 border-t border-blue-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-blue-800">Total quantités</span>
                        <span id="totalQuantity" class="text-lg font-bold text-blue-600">0</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 pt-4 sm:flex-row">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Enregistrer toutes les distributions
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-slate-100 text-slate-700 py-3 font-semibold hover:bg-slate-200 transition-all duration-300 text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    let distributionCount = 0;
    const serveusesDisponibles = @json($serveuses);
    const boissonsDisponibles = @json($boissons);

    function addDistributionRow() {
        distributionCount++;
        const container = document.getElementById('distributionsContainer');
        const row = document.createElement('div');
        row.className = 'bg-slate-50 p-4 border border-slate-200';
        row.id = 'distributionRow' + distributionCount;
        row.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-slate-700">Distribution #${distributionCount}</span>
                <button type="button" onclick="removeDistributionRow(${distributionCount})" class="text-red-500 hover:text-red-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 text-xs font-semibold mb-1">Boisson</label>
                    <div class="relative">
                        <input type="text" id="boissonSearch_${distributionCount}" name="boisson_search_${distributionCount}" class="w-full px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm" placeholder="Rechercher une boisson" autocomplete="off" oninput="updateSummary()">
                        <input type="hidden" id="boisson_id_${distributionCount}" name="distributions[${distributionCount}][boisson_id]">
                        <div id="boissonSuggestions_${distributionCount}" class="absolute z-[10000] w-full bg-white border border-slate-200 shadow-xl mt-1 hidden max-h-48 overflow-y-auto"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-semibold mb-1">Quantité</label>
                    <input type="number" id="quantite_${distributionCount}" name="distributions[${distributionCount}][quantite]" value="1" min="1" required class="w-full px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm" placeholder="Qté" oninput="updateSummary()">
                </div>
            </div>
        `;
        container.appendChild(row);
        initBoissonAutocomplete(distributionCount);
    }

    function removeDistributionRow(id) {
        const row = document.getElementById('distributionRow' + id);
        if (row) {
            row.remove();
            updateSummary();
        }
    }

    function updateSummary() {
        const container = document.getElementById('distributionsContainer');
        const summaryDiv = document.getElementById('distributionsSummary');
        const totalQuantitySpan = document.getElementById('totalQuantity');
        const rows = container.querySelectorAll('[id^="distributionRow"]');

        if (rows.length === 0) {
            summaryDiv.innerHTML = '<p class="text-sm text-slate-600">Aucune distribution configurée</p>';
            totalQuantitySpan.textContent = '0';
            return;
        }

        let summaryHTML = '';
        let totalQuantity = 0;

        rows.forEach((row, index) => {
            const rowId = row.id.replace('distributionRow', '');
            const boissonSearch = document.getElementById('boissonSearch_' + rowId);
            const quantiteInput = document.getElementById('quantite_' + rowId);

            const boissonName = boissonSearch ? boissonSearch.value : '-';
            const quantite = quantiteInput ? parseInt(quantiteInput.value) || 0 : 0;

            if (boissonName && quantite > 0) {
                summaryHTML += `<p class="text-sm text-slate-600">${boissonName}: ${quantite} unité(s)</p>`;
                totalQuantity += quantite;
            }
        });

        if (summaryHTML === '') {
            summaryDiv.innerHTML = '<p class="text-sm text-slate-600">Aucune distribution configurée</p>';
        } else {
            summaryDiv.innerHTML = summaryHTML;
        }

        totalQuantitySpan.textContent = totalQuantity;
    }

    // Autocomplete pour serveuse
    let serveuseInit = false;
    function initServeuseAutocomplete() {
        if (serveuseInit) return;
        serveuseInit = true;

        const serveuseSearch = document.getElementById('serveuseSearch');
        const serveuseSuggestions = document.getElementById('serveuseSuggestions');
        const serveuseIdInput = document.getElementById('serveuse_id');

        serveuseSearch.addEventListener('input', function() {
            const query = this.value.trim().toLocaleLowerCase();
            serveuseSuggestions.innerHTML = '';

            if (query.length < 2) {
                serveuseSuggestions.classList.add('hidden');
                return;
            }

            const matchingServeuses = serveusesDisponibles
                .filter(item => item.nom.trim().toLocaleLowerCase().includes(query))
                .sort((a, b) => {
                    const aStartsWithQuery = a.nom.trim().toLocaleLowerCase().startsWith(query);
                    const bStartsWithQuery = b.nom.trim().toLocaleLowerCase().startsWith(query);
                    return Number(bStartsWithQuery) - Number(aStartsWithQuery);
                })
                .slice(0, 10);

            if (matchingServeuses.length === 0) {
                serveuseSuggestions.innerHTML = '<div class="px-4 py-2 text-slate-500 text-sm">Aucun résultat</div>';
            } else {
                matchingServeuses.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'px-4 py-2 hover:bg-slate-100 cursor-pointer text-sm';
                    div.textContent = item.nom;
                    div.addEventListener('click', function() {
                        serveuseSearch.value = item.nom;
                        serveuseIdInput.value = item.id;
                        serveuseSuggestions.classList.add('hidden');
                    });
                    serveuseSuggestions.appendChild(div);
                });
            }
            serveuseSuggestions.classList.remove('hidden');
        });
    }

    // Autocomplete pour boisson
    function initBoissonAutocomplete(rowId) {
        const boissonSearch = document.getElementById('boissonSearch_' + rowId);
        const boissonSuggestions = document.getElementById('boissonSuggestions_' + rowId);
        const boissonIdInput = document.getElementById('boisson_id_' + rowId);

        boissonSearch.addEventListener('input', function() {
            const query = this.value.trim().toLocaleLowerCase();
            boissonSuggestions.innerHTML = '';

            if (query.length < 2) {
                boissonSuggestions.classList.add('hidden');
                return;
            }

            const matchingBoissons = [];
            const seenBoissons = new Set();
            boissonsDisponibles.forEach(item => {
                const nom = item.nom.trim();
                const normalizedNom = nom.toLocaleLowerCase();
                if (normalizedNom.includes(query) && !seenBoissons.has(normalizedNom)) {
                    seenBoissons.add(normalizedNom);
                    matchingBoissons.push(item);
                }
            });

            matchingBoissons.sort((a, b) => {
                const aStartsWithQuery = a.nom.trim().toLocaleLowerCase().startsWith(query);
                const bStartsWithQuery = b.nom.trim().toLocaleLowerCase().startsWith(query);
                return Number(bStartsWithQuery) - Number(aStartsWithQuery);
            });

            if (matchingBoissons.length === 0) {
                boissonSuggestions.innerHTML = '<div class="px-4 py-2 text-slate-500 text-sm">Aucun résultat</div>';
            } else {
                matchingBoissons.slice(0, 10).forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'px-4 py-2 hover:bg-slate-100 cursor-pointer text-sm';
                    div.textContent = item.nom + ' (' + number_format(item.prix_unitaire, 0) + ' FCFA)';
                    div.addEventListener('click', function() {
                        boissonSearch.value = item.nom;
                        boissonIdInput.value = item.id;
                        boissonSuggestions.classList.add('hidden');
                        updateSummary();
                    });
                    boissonSuggestions.appendChild(div);
                });
            }
            boissonSuggestions.classList.remove('hidden');
        });
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        initServeuseAutocomplete();
        addDistributionRow(); // Ajouter une ligne par défaut
    });

    // Fonction utilitaire pour formater les nombres
    function number_format(number, decimals) {
        return number.toLocaleString('fr-FR', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }
</script>
@endsection
