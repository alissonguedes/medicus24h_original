<?php $__env->startSection('back-button', ''); ?>

<?php $__env->startSection('main'); ?>

<?php $__env->startSection('topbar'); ?>
<div class="topbar flex flex-center" style="height: 60px;">
	<div class="topbar-fixed topbar-color flex flex-auto z-depth-1">
		<?php echo $__env->yieldContent('topbar-options'); ?>
	</div>
</div>
<?php echo $__env->yieldSection(); ?>

<style>
	.alert {
		margin-top: 5px;
		padding: 15px;
		border-radius: 5px;
		text-align: center;
	}

	.alert.success {
		color: var(--green-darken-2);
		background-color: var(--green-lighten-1);
		border: 1px solid var(--green-lighten-3);
	}

	.topbar ul li {
		display: block;
		margin-right: 10px;
	}

	.topbar ul li .btn {
		color: #000;
	}
</style>

<div class="container pt-1 scroller" style="height: 100vh ; width: 100%;">

	<?php if(session('message')): ?>
		<div class="row">
			<div class="col s12">
				<div class="alert <?php echo e(session('status') ?? 'success'); ?>">
					<?php echo e(session('message')); ?>

				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="results">
		<?php echo $__env->yieldContent('container'); ?>
	</div>

</div>

<?php echo $__env->yieldContent('left-sidebar'); ?>
<?php echo $__env->yieldContent('right-sidebar'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('clinica.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/layouts/forms.blade.php ENDPATH**/ ?>