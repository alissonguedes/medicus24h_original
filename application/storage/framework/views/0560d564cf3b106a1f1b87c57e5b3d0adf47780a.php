<?php $__env->startSection('main-menu-type', get_config('main-menu-type') == 'collapsed' ? 'main-full' : null ); ?>

<?php $__env->startSection('search', ''); ?>

<?php $__env->startSection('styles'); ?>
<?php echo $__env->make('clinica.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>

<div class="horizontal-layout <?php echo $__env->yieldContent('main-menu-type'); ?>">

	<?php echo $__env->make('clinica.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('clinica.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div id="main" class="<?php echo $__env->yieldContent('main-menu-type'); ?>">

		<?php echo $__env->yieldContent('main'); ?>

	</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/transvida/application/resources/views/clinica/body.blade.php ENDPATH**/ ?>