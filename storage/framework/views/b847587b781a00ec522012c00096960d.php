<?php $__env->startSection('title', 'Utilisateurs'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Utilisateurs</h1>
            <p class="text-slate-500">Gérez les utilisateurs de votre application</p>
        </div>
        <button onclick="openModal()" class="inline-flex w-full items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium sm:w-auto">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajouter un Utilisateur
        </button>
    </div>

    <!-- Premium Table -->
    <div class="bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Liste des Utilisateurs</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Rôle</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider border-b-2 border-slate-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-semibold text-slate-800"><?php echo e($user->name); ?></td>
                            <td class="px-6 py-4 text-slate-600"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4">
                                <?php if($user->role): ?>
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-blue-600 bg-blue-50">
                                        <?php echo e($user->role->libelle); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-slate-600 bg-slate-50">
                                        Sans rôle
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative inline-block text-left">
                                    <button onclick="toggleDropdown('dropdown-<?php echo e($user->id); ?>')" class="inline-flex items-center justify-center p-2 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>
                                    <div id="dropdown-<?php echo e($user->id); ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                                        <div class="py-1">
                                            <button onclick="editUser(<?php echo e($user->id); ?>, '<?php echo e($user->name); ?>', '<?php echo e($user->email); ?>', <?php echo e($user->role_id ?? 'null'); ?>)" class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Modifier
                                            </button>
                                            <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="w-full">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <div id="userModal" class="fixed inset-0 hidden items-center justify-center overflow-y-auto bg-black/50 p-4 backdrop-blur-sm z-50">
        <div class="my-auto max-h-[calc(100dvh-2rem)] w-full max-w-lg overflow-y-auto bg-white shadow-2xl rounded-lg">
            <div class="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white p-4 sm:p-6">
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Ajouter un Utilisateur</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="userForm" action="<?php echo e(route('users.store')); ?>" method="POST" class="space-y-6 p-4 sm:p-6">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="userId" name="id" value="">
                <div id="methodField"></div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Nom</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 rounded-lg" placeholder="Entrez le nom">
                </div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 rounded-lg" placeholder="Entrez l'email">
                </div>
                <div>
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Rôle</label>
                    <select id="role_id" name="role_id" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 rounded-lg">
                        <option value="">Sélectionnez un rôle</option>
                        <?php $__currentLoopData = \App\Models\Role::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->libelle); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex flex-col-reverse gap-3 pt-4 sm:flex-row">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 rounded-lg">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-700 py-3 font-semibold hover:bg-slate-200 transition-all duration-300 rounded-lg">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleDropdown(id) {
        // Fermer tous les dropdowns d'abord
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });

        // Ouvrir le dropdown cliqué
        const dropdown = document.getElementById(id);
        dropdown.classList.remove('hidden');
    }

    function openModal() {
        document.getElementById('userModal').classList.remove('hidden');
        document.getElementById('userModal').classList.add('flex');
        document.getElementById('modalTitle').textContent = 'Ajouter un Utilisateur';
        document.getElementById('userForm').action = '<?php echo e(route('users.store')); ?>';
        document.getElementById('userId').value = '';
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('role_id').value = '';
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.getElementById('userModal').classList.remove('flex');
    }

    function editUser(id, name, email, roleId) {
        document.getElementById('userModal').classList.remove('hidden');
        document.getElementById('userModal').classList.add('flex');
        document.getElementById('modalTitle').textContent = 'Modifier un Utilisateur';
        document.getElementById('userForm').action = '<?php echo e(route('users.update', ':id')); ?>'.replace(':id', id);
        document.getElementById('userId').value = id;
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('role_id').value = roleId || '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('userModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // Fermer les dropdowns quand on clique en dehors
        document.addEventListener('click', function(e) {
            const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
            dropdowns.forEach(dropdown => {
                if (!dropdown.classList.contains('hidden')) {
                    const button = dropdown.previousElementSibling;
                    if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views/users/index.blade.php ENDPATH**/ ?>