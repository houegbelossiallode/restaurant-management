<?php $__env->startSection('title', 'Sous-menus'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Sous-menus</h1>
            <p class="text-slate-500">Gérez les sous-menus de votre application</p>
        </div>
        <button onclick="openModal()" class="inline-flex w-full items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium sm:w-auto">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajouter un Sous-menu
        </button>
    </div>

    <!-- Premium Table -->
    <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Liste des Sous-menus</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Libellé</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Route</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Menu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Visible</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php $__currentLoopData = $sousmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sousmenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-semibold text-slate-800"><?php echo e($sousmenu->libelle); ?></td>
                            <td class="px-6 py-4 text-slate-600 font-mono text-sm"><?php echo e($sousmenu->route ?? '-'); ?></td>
                            <td class="px-6 py-4 text-slate-600"><?php echo e($sousmenu->menu->libelle ?? 'Sans menu'); ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold <?php echo e($sousmenu->is_show === 'OUI' ? 'text-blue-600 bg-blue-50' : 'text-slate-600 bg-slate-50'); ?>">
                                    <?php echo e($sousmenu->is_show); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-bold <?php echo e($sousmenu->actif === 'OUI' ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50'); ?>">
                                    <?php echo e($sousmenu->actif); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative inline-block text-left">
                                    <button onclick="toggleDropdown('sousmenu-dropdown-<?php echo e($sousmenu->id); ?>')" class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-slate-100 transition-colors">
                                        <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                    <div id="sousmenu-dropdown-<?php echo e($sousmenu->id); ?>" class="hidden fixed right-4 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-50">
                                        <div class="py-1">
                                            <button onclick="editSousmenu(<?php echo e($sousmenu->id); ?>, '<?php echo e($sousmenu->libelle); ?>', '<?php echo e($sousmenu->route ?? ''); ?>', <?php echo e($sousmenu->menu_id); ?>, '<?php echo e($sousmenu->is_show); ?>'); toggleDropdown('sousmenu-dropdown-<?php echo e($sousmenu->id); ?>')" class="flex items-center w-full px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                                <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Modifier
                                            </button>
                                            <form action="<?php echo e(route('sousmenus.destroy', $sousmenu->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sous-menu?')">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="sousmenuModal" class="fixed inset-0 hidden items-center justify-center overflow-y-auto bg-black/50 p-4 backdrop-blur-sm z-50">
        <div class="my-auto max-h-[calc(100dvh-2rem)] w-full max-w-lg overflow-y-auto bg-white shadow-2xl">
            <div class="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white p-4 sm:p-6">
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Ajouter un Sous-menu</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="sousmenuForm" action="<?php echo e(route('sousmenus.store')); ?>" method="POST" class="space-y-6 p-4 sm:p-6">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="sousmenuId" name="id" value="">
                <div id="methodField"></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-700 text-sm font-semibold mb-2">Libellé</label>
                        <input type="text" id="libelle" name="libelle" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez le libellé">
                    </div>
                    <div>
                        <label class="block text-slate-700 text-sm font-semibold mb-2">Route</label>
                        <input type="text" id="route" name="route" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez la route">
                    </div>
                    <div>
                        <label class="block text-slate-700 text-sm font-semibold mb-2">Menu</label>
                        <select id="menu_id" name="menu_id" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">Sélectionnez un menu</option>
                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($menu->id); ?>"><?php echo e($menu->libelle); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 text-sm font-semibold mb-2">Afficher (is_show)</label>
                        <select id="is_show" name="is_show" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="OUI">OUI</option>
                            <option value="NON">NON</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col-reverse gap-3 pt-4 sm:flex-row">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-700 py-3 font-semibold hover:bg-slate-200 transition-all duration-300">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function openModal() {
            document.getElementById('sousmenuModal').classList.remove('hidden');
            document.getElementById('sousmenuModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Ajouter un Sous-menu';
            document.getElementById('sousmenuForm').action = '<?php echo e(route('sousmenus.store')); ?>';
            document.getElementById('sousmenuId').value = '';
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('libelle').value = '';
            document.getElementById('route').value = '';
            document.getElementById('menu_id').value = '';
            document.getElementById('is_show').value = 'OUI';
        }

        function closeModal() {
            document.getElementById('sousmenuModal').classList.add('hidden');
            document.getElementById('sousmenuModal').classList.remove('flex');
        }
        function editSousmenu(id, libelle, route, menuId, isShow) {
            document.getElementById('sousmenuModal').classList.remove('hidden');
            document.getElementById('sousmenuModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Modifier un Sous-menu';
            document.getElementById('sousmenuForm').action = '<?php echo e(route('sousmenus.update', ':id')); ?>'.replace(':id', id);
            document.getElementById('sousmenuId').value = id;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('libelle').value = libelle;
            document.getElementById('route').value = route;
            document.getElementById('menu_id').value = menuId;
            document.getElementById('is_show').value = isShow;
        }

        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('sousmenuModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal();
                    }
                });
            }
        });
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views/sousmenus/index.blade.php ENDPATH**/ ?>