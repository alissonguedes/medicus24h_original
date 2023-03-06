<aside id="right-sidebar-nav">

	<div class="row">

		<div class="col s9 l3 ">

			<div id="atendimento" class="slide-out-right-sidenav sidenav rightside-navigation grey lighten-3" data-position="right">

				<div class="animated slow fadeIn">

					<div class="row">
						<div class="col s12">
							<a href="#" class="sidenav-close right mr-5 black-text">
								<span class="material-symbols-outlined">arrow_forward</span>
							</a>
						</div>
					</div>

					<?php if(isset($row)): ?>

						<?php
							$paciente_model = new \App\Models\PacienteModel();
							$paciente = $paciente_model->getPacienteById($row->id_paciente);
						?>

						<input type="hidden" name="atendimento" value="<?php echo e($row->id); ?>">

						<div class="row">

							<div class="slide-out-right-title flex flex-column">

								<div class="col s12 center-align">

									<div class="foto circle flex flex-column flex-center center-align mb-4">

										<div class="preview z-depth-3">

											<img src="<?php echo e(asset($row->imagem ?? 'img/avatar/icon.png')); ?>" alt="" <?php if(isset($row) && empty($row->imagem) ): ?> style="opacity: 0.4; filter: greyscale(1);" <?php endif; ?>>

										</div>

									</div>

									<div class="row">
										<div class="col s12">
											<h6 class="title" class="mb-0" <?php if(isset($paciente) && strlen($paciente->nome) > 20): ?> data-tooltip="<?php echo e($paciente->nome); ?>" <?php endif; ?>><?php echo e($paciente->nome); ?></h6>
										</div>
									</div>

									<div class="row">
										<div class="col s12">
											<p class="idade m-0">
												<?php echo e(idade($paciente->data_nascimento) ?? 'Não informado'); ?>

											</p>
											<p class="mb-0">
												<span>Convênio: <b><?php echo e($paciente->convenio); ?></b></span>
												<br>
												<span>Atendimento: <b><?php echo e($row->tipo_atendimento); ?></b></span>
											</p>
										</div>
									</div>

								</div>

							</div>

							<div class="slide-out-right-body center-align flex-column flex flex-center" style="padding-top: 30px !important;">

								<div class="row">
									<div class="col s12">
										<button type="button" class="btn flex green darken-3 mt-10 play" data-href="<?php echo e(go('clinica.atendimentos.edit', $row-> id)); ?>">
											<span class="material-icons play left">
												play_arrow
											</span>
											<span>Iniciar atendimento</span>
										</button>
									</div>
								</div>

								<div class="row">
									<div class="col s12 mt-3 mb-3">
										<div id="cronometro" class="btn">
											00 : 00 : 00
										</div>
									</div>
								</div>

							</div>

						</div>

					<?php endif; ?>

				</div>

			</div>

		</div>

	</div>

</aside>
<!-- END RIGHT SIDEBAR NAV -->
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/atendimentos/datelhes_atendimento.blade.php ENDPATH**/ ?>