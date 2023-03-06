<?php $__env->startSection('title', 'Clínicas'); ?>

<?php $__env->startSection('search-label', 'Pesquisar Clínicas'); ?>
<?php $__env->startSection('data-search', 'clinicas'); ?>

<?php $__env->startSection('search'); ?>
<div class="input-field search bordered border-round z-depth-1">
	<label for="">Pesquisar clinicas</label>
	<input type="search" id="search-on-page" class="dataTable_search">
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('btn-add-title','Adicionar Clínicas'); ?>
<?php $__env->startSection('btn-add-icon', 'person_add_alt_1'); ?>
<?php $__env->startSection('btn-add-route', go('clinica.clinicas.add')); ?>

<?php $__env->startSection('container'); ?>

<div class="row">
	<div class="col s12">
		<div class="card">
			<div class="card-content scroller">
				<div class="card-body responsive-table">
					<table class="table dataTable no-footer dataTable-fixed">
						<thead>
							<tr>
								<th data-disabled="true" data-orderable="false">
									<label class="grey-text text-darken-2 font-14 left">
										<input type="checkbox" name="check-all" id="check-all" class="filled-in">
										<span></span>
									</label>
								</th>
								<th class="center-align" width="20%">Razão Social</th>
								<th class="center-align" width="20%">Descrição</th>
								<th class="center-align" width="20%">cnpj</th>
								<th class="center-align" width="15%">cidade</th>
								<th class="center-align">estado</th>
								<th class="center-align">Data de cadastro</th>
								
								<th class="center-align" data-disabled="true">status</th>
								<th class="center-align" width="15%" data-disabled="true" data-orderable="false">Ações</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('clinica.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/empresas/index.blade.php ENDPATH**/ ?>