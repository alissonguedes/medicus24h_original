<?php  $records = []  ?>

<?php if($paginate->total() > 0): ?>

	<?php $__currentLoopData = $paginate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		<div class="grid-row" data-href="<?php echo e(route('clinica.usuarios.edit', $row->id)); ?>" data-disabled="true">
			<div class="grid-col">
				<label>
					<input type="checkbox" name="id[]" class="filled-in" value="<?php echo e($row->id); ?>" data-status="<?php echo e($row->status); ?>">
					<span></span>
				</label>
			</div>
			<div class="grid-col">
				<span><?php echo e($row->nome); ?></span>
			</div>
			<div class="grid-col left-align"><?php echo e($row->grupo); ?></div>
			<div class="grid-col left-align"><?php echo e($row->email); ?></div>
			<div class="grid-col"><?php echo e($row->ultimo_login); ?></div>
			<div class="grid-col center-align"><?php echo e($row->status); ?></div>
			<div class="grid-col center-align">
				<button data-href="<?php echo e(route('clinica.usuarios.edit', $row->id)); ?>" class="btn btn-small btn-edit btn-floating waves-effect blue-text transparent">
					<i class="material-symbols-outlined">edit</i>
				</button>
			</div>
		</div>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php else: ?>

	<div id="pagination">

		<ul>

			<li>
				<button class="btn btn-flat btn-floating waves-effect" data-href="<?php echo e(!$paginate->onFirstPage() ? $paginate->previousPageUrl() : '#'); ?>" data-tooltip="Anterior" <?php echo e($paginate->onFirstPage() ? 'disabled' : null); ?>>
					<i class="material-icons">keyboard_arrow_left</i>
				</button>
			</li>

			

<li>
	<button class="btn btn-flat btn-floating waves-effect" data-href="<?php echo e($paginate->currentPage() < $paginate->lastPage() ? $paginate->nextPageUrl() : '#'); ?>" data-tooltip="Próxima" <?php echo e($paginate->currentPage() === $paginate->lastPage() ? 'disabled' : null); ?>>
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

<div class="no-results white-text center-align">
	Nenhum registro encontrado.
</div>

<div id="pagination"></div>

<div id="info"></div>

<?php endif; ?>
<?php /**PATH /home/alissonp/www/transvida/application/resources/views/clinica/usuarios/list.blade.php ENDPATH**/ ?>