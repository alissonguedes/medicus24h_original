<div class="row">

	<div id="agendamento" class="form-sidenav card col s8 no-padding" data-dismissible="true" data-edge="right" data-backdrop="false">

		<form action="<?php echo e(go('clinica.agendamentos.post')); ?>" method="post" enctype="multipart/form-data" autocomplete="random-string" novalidate data-autoinitialize="false">

			<?php if(isset($row)): ?>
				<input type="hidden" name="id" value="<?php echo e($row->id); ?>">
				<input type="hidden" name="_method" value="put">
			<?php endif; ?>

			<?php echo csrf_field(); ?>

			<div class="card-content no-padding white lighten-3">

				<!-- BEGIN coluna 1 -->
				<div class="col s5 scroller z-depth-2" data-hide-x="true">

					<div class="row">
						<div class="col s12">
							<div class="card-title">Agendamento</div>
						</div>
					</div>

					<div class="row mt-2">
						<div class="col s12">
							<div class="input-field">
								<label for="medico" class="active">Especialidade</label>
								<select name="especialidade" class="autocomplete" id="especialidade" data-url="<?php echo e(go('clinica.especialidades.autocomplete')); ?>" data-placeholder="Informe a especialidade...">
									<?php if(isset($row) && $row->id_especialidade && $row->especialidade): ?>
										<option value="<?php echo e($row->id_especialidade); ?>" selected><?php echo e($row->especialidade); ?></option>
									<?php endif; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col s12">
							<div class="input-field">
								<label for="clinica" class="active">Local</label>
								<select name="clinica" class="autocomplete" id="clinica" data-url="<?php echo e(go('clinica.clinicas.autocomplete')); ?>" data-placeholder="Informe a clínica...">
									<?php if(isset($row) && $row->id_clinica && $row->clinica): ?>
										<option value="<?php echo e($row->id_clinica); ?>" selected><?php echo e($row->clinica); ?></option>
									<?php endif; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<div class="input-field">
								<label for="medico" class="active">Médico</label>
								<select name="medico" class="autocomplete" id="medico" data-url="<?php echo e(go('clinica.medicos.autocomplete')); ?>" data-placeholder="Informe o médico...">
									<?php if(isset($row) && $row->id_medico && $row->medico): ?>
										<option value="<?php echo e($row->id_medico); ?>" selected><?php echo e($row->medico); ?></option>
									<?php endif; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<div class="input-field">
								<label for="tipo" class="active">Tipo de atendimento</label>
								<select name="tipo" class="autocomplete" id="tipo" data-url="<?php echo e(go('clinica.atendimentos.autocomplete', 'tipos')); ?>" value="<?php echo e(isset($row) && $row->tipo_atendimento ? $row->tipo_atendimento : null); ?>" data-placeholder="Informe o tipo de atendimento...">
									<?php if(isset($row) && $row->id_tipo && $row->tipo_atendimento): ?>
										<option value="<?php echo e($row->id_tipo); ?>" selected><?php echo e($row->tipo_atendimento); ?></option>
									<?php endif; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<div class="input-field">
								<label for="categoria" class="active">Classificação</label>
								<select name="categoria" class="autocomplete" id="categoria" data-url="<?php echo e(go('clinica.atendimentos.autocomplete', 'categorias')); ?>" data-placeholder="Informe a classificação do atendimento...">
									<?php if(isset($row) && $row->id_categoria && $row->categoria): ?>
										<option value="<?php echo e($row->id_categoria); ?>" selected><?php echo e($row->categoria); ?></option>
									<?php endif; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row" style="margin: 0 !important;">
						<div class="col s12 mt-5 blue darken-2 z-depth-4" style="border-radius: 24px;">
							<div class="row">
								<div class="col s12 mt-5 mb-5">
									<h6 class="white-text" style="font-family: open-sans; font-weight: bold; text-transform: uppercase;">Agendar</h6>
								</div>
							</div>
							<div class="row">
								<div class="col s6">
									<div class="input-field">
										<label for="data" class="white-text">Data</label>
										<input type="text" name="data" class="datepicker white-text" data-mask="date" placeholder="dd/mm/yyyy" value="<?php echo e(isset($row) && $row->data ? $row->data : (request()->get('data') ?? null)); ?>">
										
									</div>
								</div>
								<div class="col s6">
									<div class="input-field">
										<label for="local" class="white-text">Horário</label>
										<input type="text" name="hora" class="white-text" data-mask="time" placeholder="hh:mm" maxlength="5" value="<?php echo e(isset($row) && $row->hora_agendada ? date('H:i', strtotime($row->hora_agendada)) : (request()->get('hora') && request()->get('hora') != '00:00' ? request()->get('hora') : null)); ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<div class="gradient-45deg-indigo-purple mb-10" style="border-radius: 10px; padding: 0px 10px;">
										<div class="input">
											<label for="recorrente" class="label">Repetir evento</label>
											<div class="switch">
												<label>
													<input type="checkbox" name="recorrente" id="recorrente" value="1">
													<span class="lever no-margin"></span>
												</label>
											</div>
										</div>
										<div class="days-of-week">
											<div class="row days white pt-5 pb-5">
												<label for="domingo" class="col s4 active">
													<input type="checkbox" name="domingo" id="domingo" class="filled-in" value="1">
													<span>Dom</span>
												</label>
												<label for="segunda" class="col s4 active">
													<input type="checkbox" name="segunda" id="segunda" class="filled-in" value="1">
													<span>Seg</span>
												</label>
												<label for="terca" class="col s4 active">
													<input type="checkbox" name="terca" id="terca" class="filled-in" value="1">
													<span>Ter</span>
												</label>
												<label for="quarta" class="col s4 active">
													<input type="checkbox" name="quarta" id="quarta" class="filled-in" value="1">
													<span>Qua</span>
												</label>
												<label for="quinta" class="col s4 active">
													<input type="checkbox" name="quinta" id="quinta" class="filled-in" value="1">
													<span>Qui</span>
												</label>
												<label for="sexta" class="col s4 active">
													<input type="checkbox" name="sexta" id="sexta" class="filled-in" value="1">
													<span>Sex</span>
												</label>
												<label for="sabado" class="col s4 active">
													<input type="checkbox" name="sabado" id="sabado" class="filled-in" value="1">
													<span>Sáb</span>
												</label>
											</div>
											<div class="row">
												<div class="col s12 no-padding">
													<div class="input-field">
														<label for="limite" class="white-text">Repetir até</label>
														<input type="text" name="limite" id="limite" value="" class="is_date white-text" data-min-date="<?php echo e(date('d/m/Y')); ?>">
														<small class="white-text">Data limite da repetição. Deixe este campo em branco, caso deseje manter a repetição por tempo indeterminado.</small>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END coluna 1 -->

				<!-- BEGIN coluna 2 -->
				<div class="col s7 scroller" data-hide-x="true">

					<div class="row">
						<div class="col s12">
							<div class="card-title">Paciente</div>
						</div>
					</div>

					<?php if(isset($row)): ?>
						<?php  $paciente = $paciente_model->getPacienteById($row->id_paciente);  ?>
					<?php endif; ?>

					<div class="row mt-2">
						<div class="col s12">
							<div class="row">
								<div class="col s2">
									<div class="circle" style="width: 58px; margin-top: 10px;">
										<img src="<?php echo e(asset($row->imagem ?? 'img/avatar/icon.png')); ?>" alt="" style="width: inherit;<?php echo e(isset($row) && empty($row->imagem) ? 'opacity: 0.4;filter: grayscale(1);' : null); ?>">
									</div>
								</div>
								<div class="col s10">
									<div class="row">
										<div class="col s12">
											<div class="input-field">
												<label for="nome_paciente" class="grey-text text-accent-1  active">Paciente</label>
												<?php if(isset($row) || !isset($paciente)): ?>
													<select name="nome_paciente" class="autocomplete" id="nome_paciente" data-url="<?php echo e(go('clinica.pacientes.autocomplete')); ?>" data-placeholder="Informe o paciente">
														<?php if(isset($row) && $row->id_paciente && $row->paciente): ?>
															<option value="<?php echo e($row->id_paciente); ?>" selected><?php echo e($row->paciente); ?></option>
														<?php endif; ?>
													</select>
												<?php else: ?>
													<input type="text" name="nome_paciente" id="nome_paciente" class="grey-text text-darken-4" value="<?php echo e(isset($paciente) && $paciente->nome ? $paciente->nome : 'teste'); ?>" readonly="readonly" autocomplete="random-string">
												<?php endif; ?>
												<input type="hidden" name="paciente" value="<?php echo e(isset($paciente) && $paciente->id ? $paciente->id : null); ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col s6">
											<div class="input-field">
												<label for="mae" class="grey-text text-accent-1 active">Nome da mãe</label>
												<input type="text" name="mae" id="mae" class="grey-text text-darken-4" value="<?php echo e($paciente->mae ?? '-'); ?>" readonly="readonly">
											</div>
										</div>
										<div class="col s6">
											<div class="input-field">
												<label for="pai" class="grey-text text-accent-1 active">Nome do pai:</label>
												<input type="text" name="pai" id="pai" class="grey-text text-darken-4" value="<?php echo e($paciente->pai ?? '-'); ?>" readonly="readonly">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							<div class="input-field">
								<label for="data_nascimento" class="grey-text text-accent-1 active">Data de nascimento:</label>
								<input type="text" name="data_nascimento" id="data_nascimento" class="grey-text text-darken-4" value="<?php echo e($paciente->data_nascimento ?? '-'); ?>" readonly="readonly">
							</div>
						</div>
						<div class="col s4">
							<div class="input-field">
								<label for="cpf" class="grey-text text-accent-1 active">CPF:</label>
								<input type="text" name="cpf" id="cpf" class="grey-text text-darken-4" value="<?php echo e($paciente->cpf ?? '-'); ?>" readonly="readonly">
							</div>
						</div>
						<div class="col s4">
							<div class="input-field">
								<label for="telefone" class="grey-text text-accent-1 active">Telefone:</label>
								<input type="text" name="telefone" id="telefone" class="grey-text text-darken-4" value="<?php echo e($paciente->telefone ?? '-'); ?>" readonly="readonly">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col s4">
							<div class="input-field">
								<label for="convenio" class="grey-text text-accent-1 active">Convênio:</label>
								<input type="text" name="convenio" id="convenio" class="grey-text text-darken-4" value="<?php echo e($paciente->convenio ?? '-'); ?>" readonly="readonly">
							</div>
						</div>
						<div class="col s4">
							<div class="input-field">
								<label for="matricula" class="grey-text text-accent-1 active">Matrícula:</label>
								<input type="text" name="matricula" id="matricula" class="grey-text text-darken-4" value="<?php echo e($paciente->matricula ?? '-'); ?>" readonly="readonly">
							</div>
						</div>
						<div class="col s4">
							<div class="input-field">
								<label for="validade" class="grey-text text-accent-1 active">Matrícula:</label>
								<input type="text" name="validade" id="validade" class="grey-text text-darken-4" value="<?php echo e($paciente->validade_convenio ?? '-'); ?>" readonly="readonly">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<div class="input-field">
								<label for="observacao" class="<?php echo e(isset($row) && $row->observacao ? 'active' : null); ?>">Observações</label>
								<textarea name="observacao" class="materialize-textarea" style="min-height: 100px;"><?php echo e(isset($row) && $row->observacao ? $row->observacao : null); ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<div class="input flex flex-center space-between no-padding">
								<label for="enviar_email" class="grey-text text-accent-1">Enviar e-mail para o paciente?</label>
								<div class="switch">
									<label>
										<input type="checkbox" name="enviar_email" id="enviar_email" value="1" checked="checked">
										<span class="lever no-margin"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END coluna 2 -->

			</div>
			<div class="card-action blue lighten-2" style="z-index: 999999;">
				<div class="row no-padding no-margin">
					<div class="col s6 left-align no-padding">
						<?php if(isset($row)): ?>
							<button type="button" class="btn red white-text waves-effect" id="delete_event" data-url="<?php echo e(go('clinica.agendamentos.delete', $row->id)); ?>" data-tooltip="Cancelar este agendamento" data-position="top">
								<i class="material-icons-outlined">delete</i>
							</button>
						<?php endif; ?>
					</div>
					<div class="col s6 right-align no-padding">
						<button type="reset" class="btn white black-text waves-effect mr-2 modal-close" data-tooltip="Voltar" data-position="top">
							<i class="material-icons-outlined">arrow_back</i>
						</button>
						<button type="submit" class="btn green waves-effect" data-tooltip="Salvar" data-position="top">
							<i class="material-icons-outlined">save</i>
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/agendamentos/form.blade.php ENDPATH**/ ?>