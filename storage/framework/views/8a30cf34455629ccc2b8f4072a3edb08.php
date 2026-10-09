<?php $__env->startSection('title', 'Enregistrer des Paiements'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800 mb-2 sm:text-3xl">Enregistrer des Paiements</h1>
        <p class="text-slate-500">Enregistrez plusieurs paiements effectués par une serveuse en une seule fois</p>
    </div>

    <div class="bg-white shadow-xl border border-slate-100 p-4 sm:p-6 lg:p-8">
        <form action="<?php echo e(route('paiements.store')); ?>" method="POST" id="paiementForm" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div>
                <label class="block text-slate-700 text-sm font-semibold mb-2">Serveuse</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="serveuseSearch" name="serveuse_search" class="w-full pl-12 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200" placeholder="Rechercher une serveuse" autocomplete="off">
                    <input type="hidden" id="serveuse_id" name="serveuse_id">
                    <div id="serveuseSuggestions" class="absolute z-[10000] w-full bg-white border border-slate-200 shadow-xl mt-1 hidden max-h-48 overflow-y-auto"></div>
                </div>
                <?php $__errorArgs = ['serveuse_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-red-500 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">Détails des paiements</h2>
                    <button type="button" onclick="addPaiementRow()" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white hover:bg-emerald-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajouter un paiement
                    </button>
                </div>

                <div id="paiementsContainer" class="space-y-4">
                    <!-- Les lignes de paiement seront ajoutées ici dynamiquement -->
                </div>
            </div>

            <!-- Résumé des paiements -->
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-4 border border-emerald-200">
                <h3 class="text-sm font-semibold text-emerald-800 mb-3">Résumé des paiements</h3>
                <div id="paiementsSummary" class="space-y-2">
                    <p class="text-sm text-slate-600">Aucun paiement configuré</p>
                </div>
                <div class="mt-3 pt-3 border-t border-emerald-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-emerald-800">Total</span>
                        <span id="totalAmount" class="text-lg font-bold text-emerald-600">0 FCFA</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 pt-4 sm:flex-row">
                <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Enregistrer tous les paiements
                </button>
                <a href="<?php echo e(route('dashboard')); ?>" class="flex-1 bg-slate-100 text-slate-700 py-3 font-semibold hover:bg-slate-200 transition-all duration-300 text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    let paiementCount = 0;

    function addPaiementRow() {
        paiementCount++;
        const container = document.getElementById('paiementsContainer');
        const row = document.createElement('div');
        row.className = 'bg-slate-50 p-4 border border-slate-200';
        row.id = 'paiementRow' + paiementCount;
        row.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-slate-700">Paiement #${paiementCount}</span>
                <button type="button" onclick="removePaiementRow(${paiementCount})" class="text-red-500 hover:text-red-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="block text-slate-700 text-xs font-semibold mb-1">Boisson</label>
                    <div class="relative">
                        <input type="text" id="boissonSearch_${paiementCount}" name="boisson_search_${paiementCount}" class="w-full px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 text-sm" placeholder="Rechercher une boisson" autocomplete="off" oninput="updateSummary()">
                        <input type="hidden" id="boisson_id_${paiementCount}" name="paiements[${paiementCount}][boisson_id]">
                        <div id="boissonSuggestions_${paiementCount}" class="absolute z-[10000] w-full bg-white border border-slate-200 shadow-xl mt-1 hidden max-h-48 overflow-y-auto"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-semibold mb-1">Quantité</label>
                    <input type="number" id="quantite_${paiementCount}" name="paiements[${paiementCount}][quantite]" value="1" min="1" required class="w-full px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 text-sm" placeholder="Qté" oninput="updateSummary()">
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-semibold mb-1">Montant (FCFA)</label>
                    <input type="number" id="montant_${paiementCount}" name="paiements[${paiementCount}][montant]" required class="w-full px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 text-sm" placeholder="Montant" oninput="updateSummary()">
                </div>
            </div>
        `;
        container.appendChild(row);
        initBoissonAutocomplete(paiementCount);
    }

    function removePaiementRow(id) {
        const row = document.getElementById('paiementRow' + id);
        if (row) {
            row.remove();
            updateSummary();
        }
    }

    function updateSummary() {
        const container = document.getElementById('paiementsContainer');
        const summaryDiv = document.getElementById('paiementsSummary');
        const totalAmountSpan = document.getElementById('totalAmount');
        const rows = container.querySelectorAll('[id^="paiementRow"]');

        if (rows.length === 0) {
            summaryDiv.innerHTML = '<p class="text-sm text-slate-600">Aucun paiement configuré</p>';
            totalAmountSpan.textContent = '0 FCFA';
            return;
        }

        let summaryHTML = '';
        let total = 0;

        rows.forEach((row, index) => {
            const rowId = row.id.replace('paiementRow', '');
            const boissonSearch = document.getElementById('boissonSearch_' + rowId);
            const quantite = document.getElementById('quantite_' + rowId);
            const montant = document.getElementById('montant_' + rowId);

            const boissonNom = boissonSearch ? boissonSearch.value : 'Non défini';
            const qty = quantite ? parseInt(quantite.value) || 0 : 0;
            const amount = montant ? parseFloat(montant.value) || 0 : 0;
            const lineTotal = qty * amount;

            if (boissonNom || qty > 0 || amount > 0) {
                summaryHTML += `<div class="flex justify-between text-sm text-slate-700">
                    <span>${boissonNom || 'Boisson'} x${qty}</span>
                    <span>${lineTotal.toLocaleString()} FCFA</span>
                </div>`;
                total += lineTotal;
            }
        });

        if (summaryHTML === '') {
            summaryHTML = '<p class="text-sm text-slate-600">Aucun paiement configuré</p>';
        }

        summaryDiv.innerHTML = summaryHTML;
        totalAmountSpan.textContent = total.toLocaleString() + ' FCFA';
    }

    function initBoissonAutocomplete(id) {
        const boissonSearch = document.getElementById('boissonSearch_' + id);
        if (!boissonSearch) return;

        const suggestions = document.getElementById('boissonSuggestions_' + id);
        if (!suggestions) return;

        boissonSearch.addEventListener('input', function(e) {
            const query = e.target.value;
            suggestions.innerHTML = '';
            suggestions.classList.add('hidden');

            if (query.length < 2) {
                return;
            }

            fetch(`/api/boissons/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const uniqueData = [];
                    const seen = new Set();
                    data.forEach(b => {
                        const nom = b.nom ? b.nom.trim() : '';
                        if (nom && !seen.has(nom)) {
                            seen.add(nom);
                            uniqueData.push(b);
                        }
                    });

                    if (uniqueData.length > 0) {
                        uniqueData.forEach(b => {
                            const div = document.createElement('div');
                            div.className = 'px-3 py-2 hover:bg-slate-50 cursor-pointer text-sm text-slate-700 border-b border-slate-100 last:border-b-0';
                            div.innerHTML = `<div class="flex justify-between items-center"><span class="font-medium">${b.nom}</span><span class="text-xs text-slate-500">${(b.prix_unitaire || 0).toLocaleString()} FCFA</span></div>`;
                            div.onclick = function() {
                                document.getElementById('boissonSearch_' + id).value = b.nom;
                                document.getElementById('boisson_id_' + id).value = b.id;
                                suggestions.classList.add('hidden');
                                updateSummary();
                            };
                            suggestions.appendChild(div);
                        });
                        suggestions.classList.remove('hidden');
                    } else {
                        suggestions.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }

    let serveuseAutocompleteInitialized = false;
    let serveuseDebounceTimer = null;
    let serveuseFetchInProgress = false;

    // Ajouter une ligne par défaut au chargement
    document.addEventListener('DOMContentLoaded', function() {
        addPaiementRow();

        // Init serveuse autocomplete
        if (!serveuseAutocompleteInitialized) {
            const serveuseSearch = document.getElementById('serveuseSearch');
            if (serveuseSearch) {
                serveuseAutocompleteInitialized = true;

                serveuseSearch.addEventListener('input', function(e) {
                    const query = e.target.value;
                    const suggestions = document.getElementById('serveuseSuggestions');
                    if (!suggestions) return;

                    // Clear previous timer
                    if (serveuseDebounceTimer) {
                        clearTimeout(serveuseDebounceTimer);
                    }

                    suggestions.innerHTML = '';
                    suggestions.classList.add('hidden');

                    if (query.length < 2) {
                        return;
                    }

                    // Debounce the fetch
                    serveuseDebounceTimer = setTimeout(() => {
                        if (serveuseFetchInProgress) return;
                        serveuseFetchInProgress = true;

                        fetch(`/api/serveuses/search?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                serveuseFetchInProgress = false;

                                // Clear again before appending
                                suggestions.innerHTML = '';

                                const uniqueData = [];
                                const seen = new Map(); // Use Map to track by ID as well
                                data.forEach(s => {
                                    const nom = s.nom ? s.nom.trim().toLowerCase() : '';
                                    const key = nom + '_' + s.id;
                                    if (nom && !seen.has(key)) {
                                        seen.set(key, true);
                                        uniqueData.push(s);
                                    }
                                });

                                if (uniqueData.length > 0) {
                                    uniqueData.forEach(s => {
                                        const div = document.createElement('div');
                                        div.className = 'px-4 py-2 hover:bg-slate-50 cursor-pointer text-sm text-slate-700 border-b border-slate-100 last:border-b-0';
                                        div.innerHTML = `<div class="flex justify-between items-center"><span class="font-medium">${s.nom}</span><span class="text-xs text-slate-500">Solde: ${(s.solde || 0).toLocaleString()} FCFA</span></div>`;
                                        div.onclick = function() {
                                            document.getElementById('serveuseSearch').value = s.nom;
                                            document.getElementById('serveuse_id').value = s.id;
                                            suggestions.classList.add('hidden');
                                        };
                                        suggestions.appendChild(div);
                                    });
                                    suggestions.classList.remove('hidden');
                                } else {
                                    suggestions.classList.add('hidden');
                                }
                            })
                            .catch(error => {
                                serveuseFetchInProgress = false;
                                console.error('Error:', error);
                            });
                    }, 300);
                });
            }
        }

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#serveuseSearch') && !e.target.closest('#serveuseSuggestions')) {
                const serveuseSuggestions = document.getElementById('serveuseSuggestions');
                if (serveuseSuggestions) serveuseSuggestions.classList.add('hidden');
            }

            // Close all boisson suggestions
            document.querySelectorAll('[id^="boissonSearch_"]').forEach(input => {
                const id = input.id.replace('boissonSearch_', '');
                if (!e.target.closest('#boissonSearch_' + id) && !e.target.closest('#boissonSuggestions_' + id)) {
                    const suggestions = document.getElementById('boissonSuggestions_' + id);
                    if (suggestions) suggestions.classList.add('hidden');
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views\paiements\create.blade.php ENDPATH**/ ?>