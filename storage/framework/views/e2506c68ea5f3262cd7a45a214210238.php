<?php $__env->startSection('title', 'Rôles'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Rôles</h1>
            <p class="text-slate-500">Gérez les rôles utilisateurs de votre application</p>
        </div>
        <button onclick="openModal()" class="inline-flex w-full items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium sm:w-auto">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajouter un Rôle
        </button>
    </div>

    <!-- Roles Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white shadow-xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white flex items-center justify-center shadow">
                            <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"><?php echo e(substr($role->libelle, 0, 1)); ?></span>
                        </div>
                        <div class="text-white">
                            <h3 class="text-base font-bold"><?php echo e($role->libelle); ?></h3>
                            <p class="text-blue-100 text-xs"><?php echo e($role->rolePermissions->where('is_granted', true)->count()); ?> permission(s)</p>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-500 text-xs font-medium">Statut</span>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-bold <?php echo e($role->actif === 'OUI' ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50'); ?>">
                            <?php echo e($role->actif); ?>

                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('roles.permissions.index', ['roleid' => $role->id])); ?>" class="flex-1 inline-flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200 text-xs font-medium">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Permissions
                        </a>
                        <button onclick="editRole(<?php echo e($role->id); ?>, '<?php echo e($role->libelle); ?>')" class="flex-1 inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors duration-200 text-xs font-medium">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier
                        </button>
                    </div>
                    <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST" class="mt-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200 text-xs font-medium" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle?')">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Modal -->
    <div id="roleModal" class="fixed inset-0 hidden items-center justify-center overflow-y-auto bg-black/50 p-4 backdrop-blur-sm z-50">
        <div class="my-auto max-h-[calc(100dvh-2rem)] w-full max-w-lg overflow-y-auto bg-white shadow-2xl">
            <div class="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white p-4 sm:p-6">
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Ajouter un Rôle</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="roleForm" action="<?php echo e(route('roles.store')); ?>" method="POST" class="space-y-6 p-4 sm:p-6">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="roleId" name="id" value="">
                <div id="methodField"></div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Libellé</label>
                    <input type="text" id="libelle" name="libelle" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" placeholder="Entrez le libellé">
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
        function openModal() {
            document.getElementById('roleModal').classList.remove('hidden');
            document.getElementById('roleModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Ajouter un Rôle';
            document.getElementById('roleForm').action = '<?php echo e(route('roles.store')); ?>';
            document.getElementById('roleId').value = '';
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('libelle').value = '';
        }

        function closeModal() {
            document.getElementById('roleModal').classList.add('hidden');
            document.getElementById('roleModal').classList.remove('flex');
        }
function editRole(id, libelle) {
            document.getElementById('roleModal').classList.remove('hidden');
            document.getElementById('roleModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Modifier un Rôle';
            document.getElementById('roleForm').action = '<?php echo e(route('roles.update', ':id')); ?>'.replace(':id', id);
            document.getElementById('roleId').value = id;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('libelle').value = libelle;
        }

        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('roleModal');
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views\roles\index.blade.php ENDPATH**/ ?>