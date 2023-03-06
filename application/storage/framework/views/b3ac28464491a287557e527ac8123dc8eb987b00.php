<?php
	use App\Models\PermissaoModel;
?>

<input type="hidden" id="total_results" value="<?php echo e($pacientes->total()); ?>">

<?php if($pacientes->total() > 0): ?>

	<?php if(request()->get('query')): ?>
		<div class="row">
			<div class="col s12">
				<h6><?php echo e($pacientes->total()); ?> <?php if($pacientes->total()>1): ?> resultados encontrados <?php else: ?> resultado encontrado. <?php endif; ?> </h6>
			</div>
		</div>
	<?php endif; ?>

	<div class="row">

		<?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<div class="col s12 m6 l3 grid-view animated fadeIn slow delay-<?php echo e($i); ?>">
				<div class="pacientes card card-border border-radius-6 z-depth-3 gradient-45deg-indigo-light-blue" <?php if($paciente->obito === '1'): ?> style="filter: grayscale(1)" <?php endif; ?>>
					<div class="card-content white-text">
						<div class="foto-paciente">
							<div class="foto circle z-depth-4 left">
								<?php
									$style = null;
									if ($paciente->status === '0'):
									$style = 'opacity: 0.3; filter: grayscale(1)';
									endif;
								?>
								<img class="img-responsive" src="<?php echo e(asset($paciente->imagem ?? (is_null($paciente->sexo) ? 'img/avatar/icon.png' : ($paciente->sexo == 'M' ? 'img/avatar/homem.png' : 'img/avatar/mulher.png') ) )); ?>" alt="" style="<?php echo e($style); ?>">
								<?php if($paciente->status === '0'): ?>
									<i class="material-icons" style="position: absolute; left: 18px; top: 18px;">lock</i>
								<?php endif; ?>
							</div>
							<h6 class="white-text"><?php echo e($paciente->nome); ?></h6>
							<p>
								<a href="#"><i class="material-icons-outlined left">cake</i><?php echo e($paciente->data_nascimento ?? 'Não informado'); ?></a>
								<a href="#"><i class="material-icons-outlined left">credit_card</i><?php echo e($paciente->cpf ?? 'Não informado'); ?></a>
							</p>
							<div class="clear"></div>
						</div>
						<div class="contato">
							<p class="mt-4">
								<a href="#"><i class="material-icons-outlined left">phone</i> <?php echo e($paciente->telefone ?? 'Não informado'); ?></a>
								<a href="#"><i class="material-icons-outlined left">message</i> <?php echo e($paciente->whatsapp ?? 'Não informado'); ?></a>
								<a href="#"><i class="material-icons-outlined left">mail</i> <?php echo e($paciente->email ?? 'Não informado'); ?></a>
							</p>
						</div>

						

						<?php  $link = ($paciente->status === '1' && $paciente->obito === '0') ? 'data-link='. go('clinica.agendamentos.{agendamento}.paciente.{paciente}', ['agendamento' => 'add', 'paciente' => $paciente->id]) : null;  ?>
						<?php  $targ = ($paciente->status === '1' && $paciente->obito === '0') ? 'data-target=agendamento' : null;  ?>
						<?php  $classe = ($paciente->status === '1' && $paciente->obito === '0') ? 'form-sidenav-trigger waves-effect' : null;  ?>
						<?php  $disabled = ($paciente->status === '0' || $paciente->obito === '1') ? 'disabled' : null;  ?>

						<div class="acoes flex flex-center mt-5">
							<button data-href="<?php echo e(go('clinica.pacientes.{id_paciente}.prontuarios', $paciente->id)); ?>" name="id" id="<?php echo e($paciente->id); ?>" data-target="prontuario" class="waves-effect gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto border-0 " data-tooltip="Prontuário">
								<i class="material-icons-outlined">assignment_ind</i>
							</button>
							<button name="id" <?php echo e($link); ?> <?php echo e($targ); ?> id="<?php echo e($paciente->id); ?>" class="gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto border-0 <?php echo e($classe); ?>" <?php echo e($disabled); ?> data-tooltip="Agendar">
								<i class="material-icons-outlined">event</i>
							</button>
							<button data-href="<?php echo e(go('clinica.pacientes.edit', $paciente->id)); ?>" class="waves-effect gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto border-0 " data-tooltip="Editar">
								<i class="material-icons-outlined">edit</i>
							</button>
						</div>

					</div>

				</div>

			</div>

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	</div>

<?php else: ?>

	<div class="row">
		<div class="col s12">
			<h6>Nenhum resultado encontrado.</h6>
		</div>
	</div>

<?php endif; ?>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/pacientes/results.blade.php ENDPATH**/ ?>