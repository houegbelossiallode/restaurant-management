<!-- Sidebar -->
<aside id="appSidebar" class="fixed inset-y-0 left-0 z-50 flex w-64 max-w-[85vw] -translate-x-full flex-col border-r border-slate-200 bg-white/95 shadow-xl backdrop-blur-lg transition-transform duration-200 lg:translate-x-0">
    <div class="border-b border-slate-200 p-4">
        <div class="flex items-center gap-3">
            <img src="<?php echo e(asset('images/logo-mahouenan.jpeg')); ?>" alt="Logo du Complexe Mawouenan Kokouvi Ayi et Fils" class="h-12 w-12 shrink-0 rounded-lg border border-amber-500/50 bg-black object-contain shadow-sm">
            <span class="text-sm font-bold leading-5 text-slate-800">Complexe Mawouenan</span>
        </div>
    </div>

    <nav class="flex-1 space-y-2 overflow-y-auto p-4">
        <!-- Tableau de bord -->
        <a href="<?php echo e(route('dashboard')); ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 font-medium <?php echo e(request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : ''); ?>">
            <i class="fa-solid fa-gauge"></i>
            <span>Tableau de bord</span>
        </a>

        <?php if(isset($mainmenus) && $mainmenus->isNotEmpty()): ?>
            <?php
                $activeMenu = '';
                foreach ($mainmenus as $menu) {
                    foreach ($menu->sousmenus as $submenu) {
                        if (Route::has($submenu->route) && request()->routeIs($submenu->route)) {
                            $activeMenu = 'menu-' . $menu->id;
                            break 2;
                        }
                    }
                }
            ?>

            <div x-data="{ activeMenu: '<?php echo e($activeMenu); ?>' }">
                <?php $__currentLoopData = $mainmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-xl overflow-hidden mb-1">
                        <button @click="activeMenu = activeMenu === 'menu-<?php echo e($menu->id); ?>' ? '' : 'menu-<?php echo e($menu->id); ?>'"
                                type="button"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 font-medium"
                                :class="{ 'text-blue-600 bg-blue-50': activeMenu === 'menu-<?php echo e($menu->id); ?>' }">
                            <div class="flex items-center space-x-3">
                                <?php if($menu->icone && trim($menu->icone) !== ''): ?>
                                    <?php if(str_starts_with(trim($menu->icone), '<')): ?>
                                        <span><?php echo $menu->icone; ?></span>
                                    <?php elseif(str_starts_with(trim($menu->icone), 'fa-')): ?>
                                        <i class="<?php echo e(trim($menu->icone)); ?>"></i>
                                    <?php else: ?>
                                        <i class="fa-solid fa-<?php echo e(trim($menu->icone)); ?>"></i>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                <?php endif; ?>
                                <span><?php echo e($menu->libelle); ?></span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-300 shrink-0"
                                 :class="{ 'rotate-180': activeMenu === 'menu-<?php echo e($menu->id); ?>' }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="activeMenu === 'menu-<?php echo e($menu->id); ?>'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="ml-4 mt-1 space-y-1 pl-3 border-l-2 border-blue-200" x-cloak>
                            <?php $__currentLoopData = $menu->sousmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(Route::has($submenu->route) ? route($submenu->route) : '#'); ?>"
                                   class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 font-medium"
                                   :class="{ 'text-blue-600 bg-blue-50': Route::has('<?php echo e($submenu->route); ?>') && request()->routeIs('<?php echo e($submenu->route); ?>') }">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span><?php echo e($submenu->libelle); ?></span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-slate-400 text-sm px-4">Aucun menu disponible</p>
        <?php endif; ?>
    </nav>

    <div class="mt-auto border-t border-slate-200 p-4">
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="flex items-center space-x-3 w-full px-4 py-3 rounded-xl text-slate-600 hover:text-red-600 hover:bg-red-50 transition-all duration-200 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>
<button id="sidebarBackdrop" type="button" aria-label="Fermer le menu" class="fixed inset-0 z-40 hidden bg-slate-950/40 lg:hidden"></button>
<?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>