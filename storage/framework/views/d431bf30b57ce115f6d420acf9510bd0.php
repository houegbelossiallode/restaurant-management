<?php $__env->startSection('title', 'Détails Serveuse'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header avec profil -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 shadow-2xl">
        <div class="flex flex-col sm:flex-row items-center gap-6">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-xl">
                <span class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"><?php echo e(substr($serveuse->nom, 0, 1)); ?></span>
            </div>
            <div class="text-white text-center sm:text-left flex-1">
                <h1 class="break-words text-2xl font-bold mb-2 sm:text-3xl"><?php echo e($serveuse->nom); ?></h1>
                <p class="text-blue-100 flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <?php echo e($serveuse->telephone ?? 'Non renseigné'); ?>

                </p>
            </div>
            <a href="<?php echo e(route('serveuses.index')); ?>" class="inline-flex items-center px-6 py-3 bg-white/20 text-white hover:bg-white/30 transition-colors font-medium backdrop-blur-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:gap-6 xl:grid-cols-3">
        <div class="bg-white shadow-xl border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Solde Actuel</p>
                    <p class="text-2xl font-bold <?php echo e($serveuse->solde > 0 ? 'text-red-600' : 'text-emerald-600'); ?>">
                        <?php echo e(number_format($serveuse->solde, 0)); ?> FCFA
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br <?php echo e($serveuse->solde > 0 ? 'from-red-500 to-red-600' : 'from-emerald-500 to-emerald-600'); ?> flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Distributions</p>
                    <p class="text-2xl font-bold text-blue-600">
                        <?php echo e($serveuse->distributions->count()); ?>

                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Total Paiements</p>
                    <p class="text-2xl font-bold text-emerald-600">
                        <?php echo e($serveuse->paiements->count()); ?>

                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Distributions -->
    <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Historique des Distributions</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px]">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Boisson</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Quantité</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Prix Unitaire</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php $__empty_1 = true; $__currentLoopData = $serveuse->distributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-slate-600"><?php echo e($distribution->date_distribution ? $distribution->date_distribution->format('d/m/Y H:i') : '-'); ?></td>
                            <td class="px-6 py-4 text-slate-600"><?php echo e($distribution->boisson->nom); ?></td>
                            <td class="px-6 py-4 text-slate-600"><?php echo e($distribution->quantite); ?></td>
                            <td class="px-6 py-4 text-slate-600"><?php echo e(number_format($distribution->prix_unitaire, 0)); ?> FCFA</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-red-600 bg-red-50">
                                    <?php echo e(number_format($distribution->montant_total, 0)); ?> FCFA
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-lg font-medium">Aucune distribution</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paiements -->
    <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Historique des Paiements</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px]">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Boisson</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Quantité</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php $__empty_1 = true; $__currentLoopData = $serveuse->paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paiement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-slate-600"><?php echo e($paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y H:i') : '-'); ?></td>
                            <td class="px-6 py-4 text-slate-600"><?php echo e($paiement->boisson->nom); ?></td>
                            <td class="px-6 py-4 text-slate-600"><?php echo e($paiement->quantite); ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-emerald-600 bg-emerald-50">
                                    <?php echo e(number_format($paiement->montant, 0)); ?> FCFA
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-lg font-medium">Aucun paiement</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views/serveuses/show.blade.php ENDPATH**/ ?>