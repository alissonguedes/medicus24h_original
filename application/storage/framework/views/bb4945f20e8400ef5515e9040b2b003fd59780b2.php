<?php $__env->startSection('title', 'Usuários'); ?>

<?php $__env->startSection('search-label', 'Pesquisar Usuários'); ?>
<?php $__env->startSection('data-search', 'usuarios'); ?>
<?php $__env->startSection('json-datatable', 'true'); ?>

<?php $__env->startSection('btn-add-title','Adicionar Usuário'); ?>
<?php $__env->startSection('btn-add-icon', 'person_add_alt'); ?>
<?php $__env->startSection('btn-add-route', go('clinica.usuarios.add')); ?>

<?php $__env->startSection('container'); ?>

<div class="row">
	<div class="col s12">
		<div class="card">
			<div class="card-content">
				<div class="card-body">
					<div class="table grid bordered">
						<div class="grid-head">
							<div class="grid grid-row">
								<div class="grid-col" data-disabled="true" data-orderable="false">
									<label class="grey-text text-darken-2 font-14 left">
										<input type="checkbox" name="check-all" id="check-all" class="filled-in">
										<span></span>
									</label>
								</div>
								<div class="grid-col" data-order="asc">
									<span class="direction">Name</span>
								</div>
								<div class="grid-col">
									<span class="direction">Grupo</span>
								</div>
								<div class="grid-col">
									<span class="direction">Email</span>
								</div>
								<div class="grid-col">
									<span class="direction">Ultimo Login</span>
								</div>
								<div class="grid-col center-align">
									<span class="direction">Status</span>
								</div>
								<div class="grid-col center-align" data-disabled="true" data-orderable="false">
									<span>Ação</span>
								</div>
							</div>
						</div>
						<div class="grid grid-body">
							<div class="scroller" style="height: calc(100vh - 290px)">
								<?php echo $__env->make('clinica.usuarios.list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('clinica.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/transvida/application/resources/views/clinica/usuarios/index.blade.php ENDPATH**/ ?>