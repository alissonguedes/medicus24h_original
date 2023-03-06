<?php $__env->startSection('styles'); ?>
<?php echo $__env->make('clinica.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>

	<?php echo $__env->yieldContent('main'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/authentication/body.blade.php ENDPATH**/ ?>