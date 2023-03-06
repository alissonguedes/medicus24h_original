<div id="modal_medico" class="modal modal-fixed-footer" data-dismissible="false">
	<form action="<?php echo e(go('clinica.medicos.post')); ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidade style="min-height: 400px;">

		<?php if(isset($row)): ?>
			<input type="hidden" name="_method" value="put">
			<input type="hidden" name="id" value="<?php echo e($row->id); ?>">
		<?php endif; ?>

		<div class="modal-content">

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="nome" class="<?php echo e(isset($row) && $row->nome ? 'active' : null); ?>">Médico</label>
						<input type="text" name="nome" id="nome" value="<?php echo e($row->nome ?? null); ?>" readonly="readonly">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<div class="input-field">
						<label for="cpf" class="<?php echo e(isset($row) && $row->crm ? 'active' : null); ?>">CPF</label>
						<input type="tel" name="cpf" id="cpf" class="is_cpf" value="<?php echo e($row->cpf ?? null); ?>" readonly="readonly">
					</div>
				</div>
				<div class="col s12 m4 l4">
					<div class="input-field">
						<label for="rg" class="<?php echo e(isset($row) && $row->crm ? 'active' : null); ?>">RG</label>
						<input type="tel" name="rg" id="rg" value="<?php echo e($row->rg ?? null); ?>" readonly="readonly">
					</div>
				</div>
				<div class="col s12 m4 l4">
					<div class="input-field">
						<label for="crm" class="<?php echo e(isset($row) && $row->crm ? 'active' : null); ?>">CRM</label>
						<input type="text" name="crm" id="crm" value="<?php echo e($row->crm ?? null); ?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="especialidade" class="active">Especialidade</label>
						<select name="especialidade" id="especialidade">
							<option value="" disabled selected>Informe a especialidade</option>
							<?php if(isset($especialidades)): ?>
								<?php $__currentLoopData = $especialidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $especialidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($especialidade->id); ?>" <?php echo e(isset($row) && $especialidade->id==$row->id_especialidade ? 'selected=selected' : null); ?>><?php echo e($especialidade->especialidade); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<label for="status" class="active blue-text text-accent-1">Médico ativo</label>
					<div class="switch mt-3" id="status">
						<label>
							Off
							<input type="checkbox" name="status" id="status" value="1" <?php echo e(!isset($row) || ($row && $row->status == '1') ? 'checked=checked' : null); ?>>
							<span class="lever"></span>
							On
						</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 mt-4 mb-4">
					<h5>Clínicas de atendimento</h5>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m12 l12">
					<div class="input-field">

						<?php if(isset($empresas) ): ?>
							<table class="table dataTable" data-ajax="false">
								<thead>
									<tr data-disabled="true">
										<th class="sorting_disabled">
											<label class="grey-text text-darken-2 font-14 left">
												<input type="checkbox" name="check-all" id="check-all" class="filled-in">
												<span></span>
											</label>
										</th>
										<th class="sorting_disabled">Nome</th>
										<th class="sorting_disabled">CNPJ</th>
									</tr>
								</thead>
								<tbody>

									<?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if(isset($row)): ?>
											<?php
												$checked = isset($row) && $empresa->id === $row->id_empresa ? 'checked=checked' : null;
											?>
										<?php endif; ?>
										<tr class="sorting_disabled" style="<?php echo e($checked != null ? 'color: rgba(0, 0, 0, 0.4);' : null); ?>">
											<td class="sorting_disabled">
												<label>
													<?php
														$getMedicoClinica = $issetMedicoClinica->getMedicoClinica($row->id, $empresa->id) ?? null;
														$getMedicoClinica = !is_null($getMedicoClinica) ? $empresa->id === $getMedicoClinica->id_empresa : null;
													?>
													<input type="checkbox" name="empresa[]" class="filled-in" value="<?php echo e($empresa->id); ?>" data-status="<?php echo e($empresa->status); ?>" <?php echo e($checked ?? (!is_null($getMedicoClinica) ? 'checked=checked' : null )); ?> <?php echo e($checked != null ? 'disabled' : null); ?>>
													<span></span>
													<?php if($checked): ?> <input type="hidden" name="empresa[]" value="<?php echo e($empresa->id); ?>"> <?php endif; ?>
												</label>
											</td>
											<td class="sorting_disabled"><?php echo e($empresa->titulo); ?></td>
											<td class="sorting_disabled"><?php echo e($empresa->cnpj); ?></td>
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								</tbody>
							</table>
						<?php endif; ?>

					</div>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<button type="reset" class="btn modal-close white waves-effect mr-2" data-toggle="Voltar">
				<i class="material-icons black-text">arrow_back</i>
			</button>
			<button type="submit" class="btn green waves-effect" data-toggle="Salvar">
				<i class="material-icons">save</i>
			</button>
		</div>
	</form>
</div>
<?php /**PATH /home/alissonp/www/transvida/application/resources/views/clinica/medicos/form.blade.php ENDPATH**/ ?>