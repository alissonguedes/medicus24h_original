<?php $__env->startSection('site-title', 'Médicus24h - Soluções em Saúde'); ?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo $__env->yieldContent('site-title'); ?></title>

	<?php $__env->startSection('styles'); ?>
	<?php echo $__env->make('styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldSection(); ?>

</head>

<body>

	<div class="progress">
		<div class="indeterminate blue accent-1"></div>
	</div>

	<div id="loading"></div>

	<div id="page">

		<?php echo $__env->yieldContent('body'); ?>

		<script>
			var BASE_URL = "<?php echo e(base_url()); ?>";
			var BASE_PATH = "<?php echo e(asset('/')); ?>";
			var SITE_URL = "<?php echo e(site_url()); ?>";
		</script>

		<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

	</div>

	<div class="row" style="position: fixed; z-index: 999999; top: 0;">
		<div class="col s4">
			<div id="alerts" class="modal modal-fixed-footer">
				<div class="modal-content">
					<h5 class="title"></h5>
					<br>
					<p class="info"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn blue lighten-1 modal-close">Ok</button>
				</div>
			</div>
		</div>
	</div>

	<?php $__env->startSection('scripts'); ?>
	<?php echo $__env->make('scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldSection(); ?>

</body>

</html>
<?php /**PATH /home/alissonp/www/transvida/application/resources/views/app.blade.php ENDPATH**/ ?>