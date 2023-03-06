<?php $__env->startSection('prev-url', url()->previous()); ?>

<?php $__env->startSection('title', 'Prontuários'); ?>

<?php $__env->startSection('main'); ?>

<div class="container prontuario no-padding">

	<div class="row">

		<div class="col s3 no-padding z-depth-2">

			<div class="card paciente no-margin flex-center">

				<div class="card-content">

					<div class="card-title pt-3 mb-3">

						<div class="foto circle flex flex-column flex-center center-align">

							<div class="preview z-depth-3">

								<img src="<?php echo e(asset($row->imagem ?? 'img/avatar/icon.png')); ?>" alt="" <?php if(isset($row) && empty($row->imagem) ): ?> style="opacity: 0.4; filter: greyscale(1);" <?php endif; ?>>

							</div>

							<h5 class="title" <?php if(strlen($paciente->nome) > 20): ?> data-tooltip="<?php echo e($paciente->nome); ?>" <?php endif; ?>><?php echo e($paciente->nome); ?></h5>

							<p class="idade">
								<?php if($paciente->obito === '0' ): ?>
									<?php echo e(idade($paciente->data_nascimento) ?? 'Não informado'); ?>

								<?php else: ?>
									
									Falecido:<br>
									<?php echo e($paciente->data_obito . ' ' . $paciente->hora_obito); ?>

								<?php endif; ?>
							</p>

						</div>

					</div>

					<div class="card-body separator">

						<div class="row">

							<div class="col s12 scroller" style="height: calc(100vh - 330px);">

								<div class="row estatisticas">

									<div class="col s12 mt-1 left-align">
										<span class="bold">Retorno agendado:</span>
										<span><?php echo e('Não agendado'); ?></span>
									</div>
									<div class="col s12 mt-1 left-align">
										<span class="bold">Consultas realizadas:</span>
										<span><?php echo e(0); ?></span>
									</div>
									<div class="col s12 mt-1 left-align">
										<span class="bold">Consultas remarcadas:</span>
										<span><?php echo e(0); ?></span>
									</div>
									<div class="col s12 mt-1 left-align">
										<span class="bold">Consultas canceladas:</span>
										<span><?php echo e(0); ?></span>
									</div>

								</div>

								<div class="row">

									<div class="col s12">

										<ul class="dados-pessoais pb-5">

											<li class="divider"></li>

											<li>

												<a title="Data de nascimento">
													<span class="material-symbols-outlined mr-3 left">cake</span>
													<input type="hidden" id="data_nascimento" value="<?php echo e($paciente->data_nascimento  ?? 'Não informado'); ?>" data-mask="date">
												</a>

											</li>

											<li>
												<a title="CPF">
													<span class="material-symbols-outlined mr-3 left">credit_card</span>
													<input type="hidden" id="cpf" value="<?php echo e($paciente->cpf ?? 'Não informado'); ?>" data-mask="cpf">
												</a>
											</li>

											<li>
												<a title="Telefone">
													<span class="material-symbols-outlined mr-3 left">call</span>
													<input type="hidden" id="telefone" value="<?php echo e($paciente->telefone ?? 'Não informado'); ?>" data-mask="phone">
												</a>
											</li>

											<li>
												<a title="Celular">
													<span class="material-symbols-outlined mr-3 left">smartphone</span>
													<input type="hidden" id="celular" value="<?php echo e($paciente->celular ?? 'Não informado'); ?>" data-mask="celular">
												</a>
											</li>

											<li>
												<a title="E-mail">
													<span class="material-symbols-outlined mr-3 left">email</span>
													<input type="hidden" id="email" value="<?php echo e($paciente->email); ?>" data-mask="email">
												</a>
											</li>

											<li class="divider"></li>

											<li>
												<a title="Nome da mãe">
													<span class="material-symbols-outlined mr-3 left">pregnant_woman</span>
													<input type="hidden" id="mae" value="<?php echo e($paciente->mae); ?>" data-mask="string">
												</a>
											</li>

											<li>
												<a title="Nome do pai">
													<span class="material-symbols-outlined mr-3 left">man</span>
													<input type="hidden" id="pai" value="<?php echo e($paciente->pai); ?>" data-mask="string">
												</a>
											</li>

										</ul>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="col s9 scroller" style="height: calc(100vh - 70px)">

			<div class="container pt-2 pr-4">

				<ul class="timeline">

					<?php for( $i = 0; $i <= 20; $i++): ?>

						<li>

							<div id="id_<?php echo e($i); ?>" class="section scrollspy">

								<div class="timeline-badge blue tooltipped" data-position="bottom" data-tooltip="Atendimento">
									<h5 class="white-text"> <?php echo e(date('d', $i)); ?> </h5>
									<h6 class="white-text"> <?php echo e(date('M', $i)); ?> </h6>
									<div class="divider"></div>
									<span class="white-text"><?php echo e(date('Y', $i)); ?></span>
								</div>

								<div class="timeline-panel">

									<div class="card m-0 hoverable flow-text" id="profile-card">

										<div class="card-content">

											<h5 class="card-title activator grey-text text-darken-4 mt-1">
												Roger Waters
											</h5>

											<table data-ajax="false">

												<tbody>
													<tr>
														<td>
															<p class="mb-0">
																<span class="material-symbols-outlined profile-card-i">local_hospital</span>
																<span>Unidade Manaíra</span>
															</p>
														</td>
														<td>
															<p class="mb-0">
																<span class="material-symbols-outlined profile-card-i">stethoscope</span>
																<span>Gastroenterologia</span>
															</p>
														</td>
													</tr>
													<tr>
														<td>
															<p class="mt-0">
																<span class="material-symbols-outlined profile-card-i">schedule</span>
																<span>09:40</span>
															</p>
														</td>
														<td>
															<p class="mt-0">
																<span class="material-symbols-outlined profile-card-i">timer</span>
																<span>00h 45m 17s</span>
															</p>
														</td>
													</tr>
												</tbody>

											</table>

											<div class="row">
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">clinical_notes</span>
														<span class="bold">Queixa principal:</span>
													</p>
												</div>
												<div class="col s12 descricao-medica">
													<p>
														Paciente alega dores na barriga, sobre a região estômago
													</p>
												</div>
											</div>

											<div class="row">
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">clinical_notes</span>
														<span class="bold">Anamnese:</span>
													</p>
												</div>
												<div class="col s12 descricao-medica">
													<p>
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
													</p>
												</div>
											</div>

											<div class="row">
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">clinical_notes</span>
														<span class="bold">Sintomas:</span>
													</p>
												</div>
												<div class="col s12 descricao-medica">
													<p>
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
													</p>
												</div>
											</div>

											<div class="row">
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">clinical_notes</span>
														<span class="bold">Diagnóstico:</span>
													</p>
												</div>
												<div class="col s12 descricao-medica">
													<p>
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
													</p>
												</div>
											</div>

											<div class="row">
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">clinical_notes</span>
														<span class="bold">Plano de tratamento:</span>
													</p>
												</div>
												<div class="col s12 descricao-medica">
													<p>
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
													</p>
												</div>
											</div>

											<div class="row">
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">clinical_notes</span>
														<span class="bold">Outros procedimentos:</span>
													</p>
												</div>
												<div class="col s12 descricao-medica">
													<p>
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
														Paciente alega dores na barriga, sobre a região estômago
													</p>
												</div>
											</div>

											<div class="row">
												<div class="col s12">
													<a href="#id_<?php echo e($i); ?>" class="btn col transparent z-depth-0 right" data-trigger="toggle">
														<span class="icon"></span>
													</a>
												</div>
											</div>

										</div>

									</div>

								</div>

							</div>

						</li>

					<?php endfor; ?>

					<li class="clearfix"></li>

				</ul>
				<!-- / timeline -->

			</div>

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('clinica.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/prontuarios/index.blade.php ENDPATH**/ ?>