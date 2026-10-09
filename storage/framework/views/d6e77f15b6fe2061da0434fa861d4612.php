<?php $__env->startSection('title', 'Ajouter une Boisson'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Ajouter une Boisson</h1>
    
    <div class="bg-white p-4 rounded-lg shadow-md sm:p-6">
        <form action="<?php echo e(route('boissons.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" name="nom" value="<?php echo e(old('nom')); ?>" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Prix Unitaire (FCFA)</label>
                <input type="number" step="0.01" name="prix_unitaire" value="<?php echo e(old('prix_unitaire')); ?>" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php $__errorArgs = ['prix_unitaire'];
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
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Stock Actuel</label>
                <input type="number" name="stock_actuel" value="<?php echo e(old('stock_actuel', 0)); ?>" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php $__errorArgs = ['stock_actuel'];
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
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Enregistrer</button>
                <a href="<?php echo e(route('boissons.index')); ?>" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">Annuler</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP 450 G7\CascadeProjects\restaurant-management\resources\views\boissons\create.blade.php ENDPATH**/ ?>