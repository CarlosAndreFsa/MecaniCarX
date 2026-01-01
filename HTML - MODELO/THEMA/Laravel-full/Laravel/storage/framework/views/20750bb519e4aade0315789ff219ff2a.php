
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Multi Select')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/multi.js/multi.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- page title -->
    <?php if (isset($component)) { $__componentOriginal8b54caccbdedc8030792c13949386bbd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b54caccbdedc8030792c13949386bbd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-title','data' => ['title' => 'Multi Select','pagetitle' => 'Forms']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('page-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Multi Select','pagetitle' => 'Forms']); ?>
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

    <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-2">
        <div class="border-slate-200 card">
            <div class="card-body">
                <h6 class="mb-4 text-15">Basic Example</h6>
                <form>
                    <select required multiple="multiple" name="favorite_fruits" id="multiselect-basic">
                        <option selected>Apple</option>
                        <option>Banana</option>
                        <option selected>Blueberry</option>
                        <option selected>Cherry</option>
                        <option>Coconut</option>
                        <option>Grapefruit</option>
                        <option>Kiwi</option>
                        <option>Lemon</option>
                        <option>Lime</option>
                        <option>Mango</option>
                        <option>Orange</option>
                        <option>Papaya</option>
                    </select>
                </form>
            </div>
        </div><!--end card-->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-4 text-15">Headers Multi Select</h6>
                <form>
                    <select required multiple="multiple" name="favorite_cars" id="multiselect-header">
                        <option>Chevrolet</option>
                        <option>Fiat</option>
                        <option>Ford</option>
                        <option>Honda</option>
                        <option selected>Hyundai</option>
                        <option>Kia</option>
                        <option>Mahindra</option>
                        <option>Maruti</option>
                        <option>Mitsubishi</option>
                        <option>MG</option>
                        <option>Nissan</option>
                        <option>Renault</option>
                        <option selected>Skoda</option>
                        <option selected>Tata</option>
                        <option selected>Toyato</option>
                        <option>Volkswagen</option>
                    </select>
                </form>
            </div>
        </div><!--end card-->

        <div class="card">
            <div class="card-body">
                <h6 class="mb-4 text-15">Option Groups</h6>
                <form>
                    <select multiple="multiple" name="favorite_cars" id="multiselect-optiongroup">
                        <optgroup label="Skoda">
                            <option>Kushaq</option>
                            <option>Superb</option>
                            <option>Octavia</option>
                            <option>Rapid</option>
                        </optgroup>
                        <optgroup label="Volkswagen">
                            <option>Polo</option>
                            <option>Taigun</option>
                            <option>Vento</option>
                        </optgroup>
                    </select>
                </form>
            </div>
        </div><!--end card-->
    </div><!--end grid-->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(URL::asset('build/libs/multi.js/multi.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/form-multi-select.init.js')); ?>"></script>
    <!-- App js -->
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel\resources\views/forms-multi-select.blade.php ENDPATH**/ ?>