<?php  $records = []  ?>

<?php
	use App\Models\PermissaoModel;
?>

<?php if($paginate->total() > 0): ?>

	<?php
		$permissao = new PermissaoModel();
		$permissao = true;
		// $permissao = $permissao->getPermissao('clinica.funcionarios.edit');
		$disabled = !$permissao ? true : false;
	?>

	<?php $__currentLoopData = $paginate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr class="<?php echo e($row->status === '0' ? 'blocked' : null); ?>" style="position: relative;" id="<?php echo e($row->id); ?>" data-url="<?php echo e(go('clinica.funcionarios.edit', $row->id)); ?>" data-trigger="modal" data-target="modal_funcionario" data-disabled="false">
			<td width="1%" data-disabled="true">
				<label>
					<input type="checkbox" name="id[]" class="filled-in" value="<?php echo e($row->id); ?>" data-status="<?php echo e($row->status); ?>">
					<span></span>
				</label>
			</td>
			<td width="20%">
				<p>
					<?php echo e($row->nome); ?>

				</p>
			</td>
			<td width="15%">
				<?php echo e($row->funcao); ?>

			</td>
			<td width="15%">
				<?php echo e($row->cpf); ?>

			</td>
			<td class="center-align" width="15%">
				<?php echo e($row->data_cadastro); ?>

			</td>
			<td class="center-align">
				<?php echo e($row->status === '0' ? 'Inativo' : 'Ativo'); ?>

			</td>
			<td data-disabled="true" width="18%" class="center-align border-rl">
				<?php if(!$disabled): ?>
					<button type="button" class="btn btn-small grey lighten-4 btn-floating float-none waves-effect" name="edit" value="<?php echo e($row->id); ?>" data-url="<?php echo e(go('clinica.funcionarios.edit', $row->id)); ?>" data-target="modal_funcionario" data-trigger="modal" data-tooltip="Editar">
						<i class="material-icons-outlined grey-text">edit</i>
					</button>
				<?php endif; ?>
				<?php if(!$disabled): ?>
					<?php  $status = ($row->status === '0' ? '1' : '0');  ?>
					<button type="button" class="btn-small ml-3 mr-3 teal lighten-3 btn-edit btn-floating waves-effect" name="status" value="<?php echo e($status); ?>" data-url="<?php echo e(go('clinica.funcionarios.patch', 'status', $row->id)); ?>" data-tooltip="<?php echo e($status === '0' ? 'Bloquear' : 'Desbloquear'); ?>" data-method="patch">
						<i class="material-icons white-text"><?php echo e($row->status === '1' ? 'lock' : 'lock_open'); ?></i>
					</button>
				<?php endif; ?>
				<?php if(!$disabled): ?>
					<button type="button" class="btn-small red lighten-3 btn-floating excluir waves-effect" value="<?php echo e($row->id); ?>" data-url="<?php echo e(go('clinica.funcionarios.delete', $row->id)); ?>" data-tooltip="Excluir" data-method="delete">
						<i class="material-icons-outlined white-text">delete</i>
					</button>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	<div id="pagination">

		<ul>

			<li>
				<button class="btn btn-flat btn-floating waves-effect" data-tooltip="Anterior" data-href="<?php echo e(!$paginate->onFirstPage() ? $paginate->previousPageUrl() : '#'); ?>" <?php echo e($paginate->onFirstPage() ? 'disabled' : null); ?>>
					<i class="material-icons">keyboard_arrow_left</i>
				</button>
			</li>

			<li>
				<button class="btn btn-flat btn-floating waves-effect" data-tooltip="Pr??xima" data-href="<?php echo e($paginate->currentPage() < $paginate->lastPage() ? $paginate->nextPageUrl() : '#'); ?>" <?php echo e($paginate->currentPage() === $paginate->lastPage() ? 'disabled' : null); ?>>
					<i class="material-icons">keyboard_arrow_right</i>
				</button>
			</li>

		</ul>

	</div>

	<div id="info">
		<button data-href="#" class="btn btn-flat waves-effect">
			<?php echo e($paginate->firstItem()); ?> - <?php echo e($paginate->lastItem()); ?> de <?php echo e($paginate->total()); ?>

			
		</button>
	</div>

<?php else: ?>

	<tr data-disabled="true">
		<td colspan="6">
			Nenhum registro encontrado.
		</td>
	</tr>

	<div id="pagination"></div>

	<div id="info"></div>

<?php endif; ?>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/funcionarios/list.blade.php ENDPATH**/ ?>