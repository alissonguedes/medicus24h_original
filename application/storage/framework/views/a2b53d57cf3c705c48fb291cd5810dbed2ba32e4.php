<?php $__env->startSection('prev-url', route('clinica.pacientes.index')); ?>

<?php if( !isset($paciente)): ?>
	<?php  $disabled = 'disabled="disabled"';  ?>
<?php endif; ?>

<?php $__env->startSection('topbar', ''); ?>

<?php
	$disabled = null;
	$editavel = null;
	$input_label_hidden = null;
?>

<?php if(session()->get('userdata')[session()->get('app_session')]['id_grupo'] > 1): ?>

	<?php  $disabled = isset($row) && $row->editavel === '0' ? 'disabled="disabled"' : false;  ?>

	<?php if($disabled): ?>
		<?php  $input_label_hidden = $row -> label;  ?>
		<?php  $editavel = $row->editavel;  ?>
	<?php else: ?>
		<?php  $editavel = 1;  ?>
	<?php endif; ?>

<?php endif; ?>

<?php $__env->startSection('title', (isset($row) ? 'Editar' : 'Novo') . ' usuário'); ?>

<?php $__env->startSection('buttons'); ?>
<?php if(isset($row)): ?>
	<button class="btn btn-large excluir waves-effect" value="<?php echo e(isset($row) ? $row->id : null); ?>" data-tooltip="Excluir" data-link="<?php echo e(route('clinica.usuarios.delete')); ?>" style="border: none">
		<i class="material-icons">delete_forever</i>
	</button>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('container'); ?>

<div class="container">

	<div class="row">

		<div class="col s12">

			<!-- BEGIN form -->
			<form novalidate action="<?php echo e(route('clinica.usuarios.post')); ?>" method="post" autocomplete="off">

				<div class="card">

					<div class="card-content no-padding">

						<div class="card-title pl-2 pt-2 pb-1">
							<?php echo $__env->yieldContent('title'); ?>
						</div>

						<div class="card-body fixed-height border-top scroller pt-3 pb-4" data-hide-x="true" style="height: calc(100vh - 250px);">

							<div class="row">

								<div class="col s12 m10 l10 offset-m2 offset-l1">

									<!-- BEGIN Input[Nome] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">person</i>
												<input type="text" name="nome" id="nome" value="<?php echo e(isset($row) ? $row->nome : null); ?>" autofocus="autofocus">
												<label class="grey-text" for="nome"> Nome </label>
											</div>
										</div>
									</div>
									<!-- END Input[Nome] -->

									<!-- BEGIN Input[Login] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">account_circle</i>
												<input type="text" name="login" id="login" value="<?php echo e(isset($row) ? $row->login : null); ?>">
												<label class="grey-text" for="login"> Login </label>
											</div>
										</div>
									</div>
									<!-- END Input[Login] -->

									<!-- BEGIN Select[Grupo] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">group</i>
												<select name="grupo">
													<option value="" disabled="disabled" <?php echo e(!isset($row) ? 'selected="selected"' : null); ?>> Selecione um grupo</option>
													<?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<option value="<?php echo e($grupo->id); ?>" <?php echo e(isset($row) && $grupo->id == $row->id_grupo ? 'selected="selected"' : null); ?> data-icon=""> <?php echo e($grupo->grupo); ?> </option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</select>
												<label>Grupo</label>
											</div>
										</div>
									</div>
									<!-- END Select[Grupo]-->

									<!-- BEGIN Input[Email] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">email</i>
												<input type="email" name="email" value="<?php echo e(isset($row) ? $row->email : null); ?>" id="email">
												<label class="grey-text" for="email"> E-mails </label>
											</div>
										</div>
									</div>
									<!-- END Input[Email] -->

									<!-- BEGIN Input[Senha] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">vpn_key</i>
												<input type="password" name="senha" id="senha">
												<label class="grey-text" for="senha"> Senha </label>
											</div>
										</div>
									</div>
									<!-- END Input[Senha] -->

									<!-- BEGIN Input[Status] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="label-buttons right">
												<label class="left" data-tooltip="Bloquear">
													<input type="checkbox" name="status" value="0" <?php echo e(isset($row) && $row->status === '0' ? 'checked="checked"' : null); ?>>
													<i class="material-icons" style="width: auto !important;">lock</i>
												</label>
											</div>
										</div>
									</div>
									<!-- END Input[Status] -->

								</div>

							</div>

						</div>

					</div>

					<div class="card-action right-align">

						<button type="reset" class="btn white black-text waves-effect mr-2" data-tooltip="Voltar" data-href="<?php echo e(go('clinica.usuarios.index')); ?>">
							<i class="material-icons-outlined">arrow_back</i>
						</button>

						<button type="submit" class="btn green waves-effect" data-tooltip="Salvar">
							<i class="material-icons-outlined">save</i>
						</button>

						<input type="hidden" name="acao" value="login">
						<input type="hidden" name="id" value="<?php echo e(isset($row) ? $row->id : null); ?>">
						<input type="hidden" name="_method" value="<?php echo e(isset($row) ? 'put' : 'post'); ?>">

						<?php if(!isset($row)): ?>
							<input type="hidden" name="editavel" value="<?php echo e($editavel); ?>">
						<?php endif; ?>

						<input type="hidden" name="dicionario" value="<?php echo e(isset($row) ? $row->id_dicionario : null); ?>">
						<?php echo e($input_label_hidden); ?>


					</div>

				</div>

			</form>
			<!-- END form -->

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('clinica.layouts.forms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/usuarios/form.blade.php ENDPATH**/ ?>