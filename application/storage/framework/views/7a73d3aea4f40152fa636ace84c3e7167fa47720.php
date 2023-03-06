<?php $__env->startSection('back-button', ''); ?>

<?php $__env->startSection('main'); ?>

<div class="topbar flex flex-center">
	<div class="topbar-fixed topbar-color flex flex-auto z-depth-1">
		<div class="flex flex-auto flex-center">
			<div class="flex flex-auto flex-start flex-center">
				<button class="dropdown-trigger btn white black-text z-depth-3 border-round" data-target="dropdown-actions">
					<i class="material-icons checkbox">check_box</i>
					<i class="material-icons">keyboard_arrow_down</i>
				</button>
				<ul id="dropdown-actions" class="dropdown-content">
					<li>
						<button type="button" data-link=" #go('clinica.medicos.delete', $row->id) " data-method="get">
							<i class="material-icons">file_download</i>PDF
						</button>
					</li>
					<li>
						<button type="button" data-link=" #go('clinica.medicos.delete', $row->id) " data-method="get">
							<i class="material-icons">file_download</i>XLS
						</button>
					</li>
					<li class="divider" tabindex="-1"></li>
					<li class="disabled red-text">
						<button type="button" disabled="disabled" id="btn-delete" data-link="<?php echo $__env->yieldContent('btn-delete-route'); ?>" data-method="delete">
							<i class="material-icons">delete</i>Excluir
						</button>
					</li>
				</ul>
				<?php $__env->startSection('search'); ?>
				<div class="input-field search bordered border-round z-depth-1">
					<?php $__env->startSection('search-label', 'Pesquisar...'); ?>
					<label for=""><?php echo $__env->yieldContent('search-label'); ?></label>
					<input type="search" id="search-on-page" data-search="<?php echo $__env->yieldContent('data-search'); ?>" data-json-datatable="<?php echo $__env->yieldContent('json-datatable', 'false'); ?>">
				</div>
				<?php echo $__env->yieldSection(); ?>
				<?php $__env->startSection('filters'); ?>
				<button id="total-results" class="btn btn-flat waves-effect ml-1 left-align dropdown-trigger pl-2 pr-2 grey-text text-darken-2" data-target="dropdown-registros">
					<span style="display: inline-block; height: 28px; overflow: hidden;"><?php echo $__env->yieldContent('total-results'); ?></span>
					<i class="material-icons arrow-down">keyboard_arrow_down</i>
				</button>
				<?php echo $__env->yieldSection(); ?>
			</div>

			<div class="action-buttons">
				<button class="btn btn-floating blue lighten-1 list gradient-45deg-indigo-light-blue waves-effect waves-light hide" id="change-mode" disabled="disabled">
					<i class="material-icons">list</i>
				</button>
				<?php $__env->startSection('btn-add'); ?>
				<button class="btn btn-floating gradient-45deg-deep-orange-orange waves-effect waves-light z-depth-3" data-tooltip="<?php echo $__env->yieldContent('btn-add-title'); ?>" data-position="left" data-href="<?php echo $__env->yieldContent('btn-add-route'); ?>" data-position="">
					<i class="material-icons"><?php echo $__env->yieldContent('btn-add-icon'); ?></i>
				</button>
				<?php echo $__env->yieldSection(); ?>
			</div>
		</div>
	</div>
</div>

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
</style>

<div class="container pt-1 pb-3 scroller" style="height: calc(100vh - 130px); width: 100%;">

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

<?php echo $__env->make('clinica.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/layouts/index.blade.php ENDPATH**/ ?>