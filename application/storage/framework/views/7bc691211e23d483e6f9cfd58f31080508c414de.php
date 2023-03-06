<div id="modal_funcionario" class="modal modal-fixed-footer" data-dismissible="false">
	<form action="<?php echo e(go('clinica.funcionarios.post')); ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidade>

		<?php if(isset($row)): ?>
			<input type="hidden" name="_method" value="put">
			<input type="hidden" name="id" value="<?php echo e($row->id); ?>">
		<?php endif; ?>

		<div class="modal-content scroller">

			<div class="row">
				<div class="col s12 mb-3">
					<h5>Cadastro do funcionário</h5>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="nome" class="<?php echo e(isset($row) && $row->nome ? 'active' : null); ?>">Funcionário</label>
						<input type="text" name="nome" id="nome" value="<?php echo e($row->nome ?? null); ?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m6 l6">
					<div class="input-field">
						<label for="cpf" class="<?php echo e(isset($row) && $row->cpf ? 'active' : null); ?>">CPF</label>
						<input type="tel" name="cpf" id="cpf" class="is_cpf" value="<?php echo e($row->cpf ?? null); ?>">
					</div>
				</div>
				<div class="col s12 m6 l6">
					<div class="input-field">
						<label for="rg" class="<?php echo e(isset($row) && $row->rg ? 'active' : null); ?>">RG</label>
						<input type="tel" name="rg" id="rg" value="<?php echo e($row->rg ?? null); ?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="funcao" class="active">Função</label>
						<select name="funcao" id="funcao">
							<option value="" disabled selected>Informe a função</option>
							<?php if(isset($funcoes)): ?>
								<?php $__currentLoopData = $funcoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($funcao->id); ?>" <?php echo e(isset($row) && $funcao->id==$row->id_funcao ? 'selected=selected' : null); ?>><?php echo e($funcao->funcao); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">

				<div class="col s12 m6">
					<div class="input-field">
						<label for="crm" class="<?php echo e(isset($row) && $row->crm ? 'active' : null); ?>">CRM</label>
						<input type="text" name="crm" id="crm" value="<?php echo e($row->crm ?? null); ?>">
					</div>
				</div>

				<div class="col s12 m6">
					<div class="input-field">
						<label for="especialidade" class="active">Especialidade</label>
						<select name="especialidade" id="especialidade">
							<option value="" disabled selected>Informe a especialidade</option>
							<?php if(isset($especialidades)): ?>
								<?php $__currentLoopData = $especialidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $especialidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($especialidade->id); ?>" <?php echo e(isset($row) && isset($row->especialidade) && $especialidade->id==$row->especialidade ? 'selected=selected' : null); ?>><?php echo e($especialidade->especialidade); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="clinica" class="active">Clínica</label>
						<select name="clinica" id="clinica" data-link="<?php echo e(go('clinica.clinicas.departamentos')); ?>" data-target="departamento">
							<option value="" disabled selected>Informe a clínica de atuação</option>
							<?php if(isset($clinicas)): ?>
								<?php $__currentLoopData = $clinicas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinica): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($clinica->id); ?>" <?php echo e(isset($row) && $clinica->id==$row->id_clinica ? 'selected=selected' : null); ?>><?php echo e($clinica->titulo); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="departamento" class="active">Departamento</label>
						<select name="departamento" id="departamento" <?php if(empty($row)): ?> disabled="disabled" <?php endif; ?>>
							<option value="" disabled="disabled" selected>Informe o departamento</option>
							<?php if(isset($departamentos)): ?>
								<?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($departamento->id); ?>" <?php echo e(isset($row) && $departamento->id==$row->id_departamento ? 'selected=selected' : null); ?>><?php echo e($departamento->titulo); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<label for="status" class="active blue-text text-accent-1">Funcionário ativo</label>
					<div class="switch mt-3" id="status">
						<label>
							Não
							<input type="checkbox" name="status" id="status" value="1" <?php echo e(!isset($row) || ($row && $row->status == '1') ? 'checked=checked' : null); ?>>
							<span class="lever"></span>
							Sim
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="reset" class="btn modal-close white waves-effect mr-2" data-tooltip="Voltar">
				<i class="material-icons-outlined black-text">arrow_back</i>
			</button>
			<button type="submit" class="btn green waves-effect" data-tooltip="Salvar">
				<i class="material-icons-outlined">save</i>
			</button>
		</div>

	</form>

</div>
<?php /**PATH /home/alissonp/www/transvida/application/resources/views/clinica/funcionarios/form.blade.php ENDPATH**/ ?>