<?php $__env->startSection('title'); ?>
    <?php echo e(__('Color Pickr')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <!-- One of the following themes -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css')); ?>">
    <!-- 'classic' theme -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css')); ?>">
    <!-- 'monolith' theme -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css')); ?>"> <!-- 'nano' theme -->
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- page title -->
    <?php if (isset($component)) { $__componentOriginal8b54caccbdedc8030792c13949386bbd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b54caccbdedc8030792c13949386bbd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-title','data' => ['title' => 'Color Picker','pagetitle' => 'Forms']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Color Picker','pagetitle' => 'Forms']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8b54caccbdedc8030792c13949386bbd)): ?>
<?php $attributes = $__attributesOriginal8b54caccbdedc8030792c13949386bbd; ?>
<?php unset($__attributesOriginal8b54caccbdedc8030792c13949386bbd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8b54caccbdedc8030792c13949386bbd)): ?>
<?php $component = $__componentOriginal8b54caccbdedc8030792c13949386bbd; ?>
<?php unset($__componentOriginal8b54caccbdedc8030792c13949386bbd); ?>
<?php endif; ?>

    <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Monolith Demo</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">monolith-colorpicker</code> class to set monolith colorpicker.</p>

                <div class="monolith-colorpicker"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Classic Demo</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">classic-colorpicker</code> class to set classic colorpicker.</p>

                <div class="classic-colorpicker"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Nano Demo</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">nano-colorpicker</code> class to set nano colorpicker.</p>

                <div class="nano-colorpicker"></div>
            </div>
        </div><!--end card-->

        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Option Demo</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">colorpicker-demo</code> class to set demo option colorpicker.</p>

                <div class="colorpicker-demo"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Switches</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">colorpicker-switch</code> class to set switch colorpicker.</p>

                <div class="colorpicker-switch"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Picker with Opacity & Hue</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">colorpicker-opacity-hue</code> class to set colorpicker with opacity & hue.</p>

                <div class="colorpicker-opacity-hue"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Picker with Input</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">colorpicker-input</code> class to set colorpicker with input.</p>

                <div class="colorpicker-input"></div>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1 text-gray-800 text-15 dark:text-white">Color Format</h6>
                <p class="mb-4">Use <code class="text-xs text-pink-500 select-all">colorpicker-format</code> class to set colorpicker with format option.</p>

                <div class="colorpicker-format"></div>
            </div>
        </div><!--end card-->
    </div><!--end grid-->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <!-- Modern colorpicker bundle -->
    <script src="<?php echo e(URL::asset('build/libs/@simonwep/pickr/pickr.min.js')); ?>"></script>

    <!-- colorpickr init js -->

    <script src="<?php echo e(URL::asset('build/js/pages/form-colorpicker.init.js')); ?>"></script>
    <!-- App js -->
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel\resources\views/forms-colorpicker.blade.php ENDPATH**/ ?>