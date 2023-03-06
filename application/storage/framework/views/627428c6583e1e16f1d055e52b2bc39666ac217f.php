<div id="form_plano_saude" class="modal modal-fixed-footer">

	<form action="<?php echo e(go('clinica.pacientes.addplano')); ?>" method="post" data-autoinitialize="false">

		<div class="modal-content">

			<?php if(isset($plano)): ?>
				<input type="hidden" name="id" value="<?php echo e($plano->id); ?>">
				<input type="hidden" name="_method" value="put">
			<?php endif; ?>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="id_plano">Convênio</label>
						<select name="id_plano" id="id_plano">
							<option value="" disabled="disabled" selected="selected">Informe o convênio</option>
							<?php if(isset($convenios)): ?>
								<?php $__currentLoopData = $convenios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $convenio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($convenio->id); ?>" <?php if(isset($plano) && $convenio->id === $plano->id): ?> selected="selected" <?php endif; ?>><?php echo e($convenio->descricao); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="id_tipo_plano">Tipo do convênio</label>
						<select name="id_tipo_plano" id="id_tipo_plano" disabled="disabled" data-url="<?php echo e(go('clinica.convenios.autocomplete')); ?>">
							<option value="" disabled="disabled" selected="selected">Informe o tipo de convênio</option>
							
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="id_acomodacao">Tipo de acomodação</label>
						<select name="id_acomodacao" id="id_acomodacao">
							<option value="" disabled selected>Informe o tipo de acomodação</option>
							<?php if(isset($acomodacoes)): ?>
								<?php $__currentLoopData = $acomodacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acomodacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($acomodacao->id); ?>" <?php echo e(isset($plano) && $acomodacao->id==$plano->id_acomodacao ? 'selected=selected' : null); ?>><?php echo e($acomodacao->descricao); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m6 l6">
					<div class="input-field">
						<label for="matricula">Matrícula</label>
						<input type="text" name="matricula" id="matricula" value="<?php echo e($row->matricula ?? null); ?>">
					</div>
				</div>
				
				<div class="col s12 m6 l6">
					<div class="input-field">
						<label class="active" for="carteira">Validade</label>
						<?php
							$mes = null;
							$ano = null;
							if(isset($row) && $row->validade_ano && $row->validade_mes) {
							$mes = $row->validade_mes;
							$ano = $row->validade_ano;
							}
							$meses = ['01'=>'Jan', '02'=>'Fev', '03'=>'Mar', '04'=>'Abr', '05'=>'Mai', '06'=>'Jun', '07'=>'Jul', '08'=>'Ago', '09'=>'Set', '10'=>'Out', '11'=>'Nov', '12'=>'Dez',];
						?>
						<div class="row">
							<div class="col s6">
								<select name="validade_mes">
									<option value="" selected="selected" disabled="disabled">Mês</option>
									<?php $__currentLoopData = $meses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($i); ?>" <?php if($i==$mes): ?> selected="selected" <?php endif; ?>><?php echo e($m); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
							<div class="col s6">
								<select name="validade_ano">
									<option value="" selected="selected" disabled="disabled">Ano</option>
									<?php for($i = date('Y'); $i <= date('Y') + 20; $i ++): ?>
										<option value="<?php echo e($i); ?>" <?php if($i==$ano): ?> selected="selected" <?php endif; ?>><?php echo e($i); ?></option>
									<?php endfor; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="modal-footer bordered">
			<button type="reset" class="btn white black-text lighten-1 modal-close">Fechar</button>
			<button type="submit" class="btn blue lighten-1">Adicionar</button>
		</div>

	</form>

</div>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/pacientes/modal_form_planos.blade.php ENDPATH**/ ?>