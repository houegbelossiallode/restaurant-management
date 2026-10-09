<?php $__env->startSection('title', 'Modifier une Serveuse'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-8">
    <div>
        <h1 class="break-words text-2xl font-bold text-slate-800 mb-2 sm:text-3xl">Modifier <?php echo e($serveuse->nom); ?></h1>
        <p class="text-slate-500">Mettez à jour les informations de la serveuse</p>
    </div>

    <div class="bg-white shadow-xl border border-slate-100 p-4 sm:p-6 lg:p-8">
        <form action="<?php echo e(route('serveuses.update', $serveuse->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" name="nom" value="<?php echo e(old('nom', $serveuse->nom)); ?>" required class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-8">
                <label class="block text-slate-700 text-sm font-bold mb-2">Téléphone (optionnel)</label>
                <input type="text" name="telephone" value="<?php echo e(old('telephone', $serveuse->telephone)); ?>" class="w-full px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                <?php $__errorArgs = ['telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg">
                    Modifier
                </button>
                <a href="<?php echo e(route('serveuses.index')); ?>" class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition-all duration-300 text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views\serveuses\edit.blade.php ENDPATH**/ ?>