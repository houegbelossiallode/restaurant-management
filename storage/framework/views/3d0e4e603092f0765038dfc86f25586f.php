<?php $__env->startSection('title', 'Gestion des permissions – ' . ($role->libelle ?? 'Profil')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6">

    <form method="POST" action="<?php echo e(route('roles.permissions.update', ['permission' => $role->id])); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" name="roleId" value="<?php echo e($role->id); ?>">

        <!-- Action Bar -->
        <div class="bg-white p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-none flex items-center justify-center text-blue-600 border border-blue-500/20">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">Droits d'accès : <span class="text-blue-600 uppercase"><?php echo e($role->libelle); ?></span></h2>
                    <p class="text-sm text-slate-500">Cochez les sous-menus auxquels ce profil peut accéder.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="<?php echo e(route('roles.index')); ?>" class="flex-1 sm:flex-none px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition-colors border border-slate-200 rounded-none text-center">
                    Annuler
                </a>
                <button type="submit" class="flex-1 sm:flex-none px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs uppercase tracking-wider hover:from-blue-700 hover:to-indigo-700 transition-colors border border-transparent rounded-none">
                    Enregistrer les Permissions
                </button>
            </div>
        </div>

        <!-- Modules Loop -->
        <div class="space-y-6 mt-6">
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white shadow-sm border border-slate-200 rounded-none" x-data="{ moduleChecked: false }">
                    <!-- Module Header -->
                    <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50 rounded-none">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white border border-slate-200 rounded-none flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest"><?php echo e($module->libelle ?? 'Module ' . $module->id); ?></h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest cursor-pointer">Tout cocher</label>
                            <input type="checkbox" x-model="moduleChecked" @change="$el.closest('.bg-white').querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = moduleChecked)" class="w-5 h-5 border-slate-300 text-blue-600 rounded-none focus:ring-blue-600 cursor-pointer">
                        </div>
                    </div>

                    <!-- Menus inside Module -->
                    <div class="p-6 space-y-8">
                        <?php $__currentLoopData = $module->menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($menu->sousmenus->count() > 0): ?>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-none bg-slate-300"></span>
                                        <?php echo e($menu->libelle); ?>

                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <?php $__currentLoopData = $menu->sousmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sousmenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $perm = $permissions->firstWhere('sous_menu_id', $sousmenu->id);
                                                $checked = $perm && $perm->is_granted ? 'checked' : '';
                                            ?>
                                            <label class="flex items-start gap-4 p-4 border border-slate-200 rounded-none hover:border-blue-600 transition-colors cursor-pointer bg-white group">
                                                <input type="checkbox" name="permissions[<?php echo e($sousmenu->id); ?>]" value="1" class="perm-checkbox w-5 h-5 mt-0.5 border-slate-300 text-blue-600 rounded-none focus:ring-blue-600 cursor-pointer" <?php echo e($checked); ?>>
                                                <div class="flex-1">
                                                    <div class="font-bold text-sm text-slate-800 group-hover:text-blue-600 transition-colors"><?php echo e($sousmenu->libelle); ?></div>
                                                    <div class="text-xs text-slate-400 mt-1 font-mono break-all"><?php echo e($sousmenu->route ?? 'url.non.definie'); ?></div>
                                                </div>
                                                <div class="text-[9px] font-bold uppercase tracking-widest text-blue-600 bg-blue-600/10 border border-blue-600/20 px-2 py-1 rounded-none">
                                                    <?php echo e($role->libelle); ?>

                                                </div>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($module->menus->isEmpty() || $module->menus->flatMap->sousmenus->isEmpty()): ?>
                            <div class="text-sm text-slate-400 italic">Aucun sous-menu disponible dans ce module.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views/role-permissions/index.blade.php ENDPATH**/ ?>