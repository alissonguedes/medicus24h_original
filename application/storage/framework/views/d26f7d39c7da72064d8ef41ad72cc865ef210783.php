<?php $__env->startSection('prev-url', route('clinica.pacientes.index')); ?>
<?php $__env->startSection('title', 'Pacientes'); ?>

<?php if( !isset($paciente)): ?>
	<?php  $disabled = 'disabled="disabled"';  ?>
<?php endif; ?>

<?php $__env->startSection('topbar-options'); ?>
<ul class="flex flex-auto flex-start flex-center">
	<li><button type="button" <?php echo e($disabled ?? null); ?> href="#" class="btn grey lighten-3 z-depth-1 waves-effect waves-light" data-trigger="activator" data-target="tarefas">Tarefas</button></li>
	<li><button type="button" <?php echo e($disabled ?? null); ?> href="#" <?php if(isset($paciente)): ?> data-href="<?php echo e(go('clinica.pacientes.{id_paciente}.prontuarios', $paciente->id)); ?>" <?php endif; ?> class="btn grey lighten-3 z-depth-1 waves-effect waves-light">Prontuários</button></li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>

<div class="container">

	<div class="row">

		<div class="col s12">

			<form action="<?php echo e(go('clinica.pacientes.post')); ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php echo csrf_field(); ?>

				<?php if(isset($paciente)): ?>

					<input type="hidden" name="id" value="<?php echo e($paciente->id); ?>">
					<input type="hidden" name="_method" value="put">

				<?php endif; ?>

				<div class="card">

					<div class="card-content no-padding">

						<div class="card-title pl-2 pt-2">
							<?php if(isset($paciente)): ?>
								Editar: <?php echo e($paciente->nome); ?>

							<?php else: ?>
								Cadastrar Paciente
							<?php endif; ?>
							<div id="tarefas" class="activator"></div>
						</div>

						<div id="tabs">
							<ul class="tabs tabs-fixed-width">
								<li class="tab"><a href="#informacoes_pessoais" class="active">Dados pessoais</a></li>
								<li class="tab"><a href="#informacoes_endereco">Endereço</a></li>
								<li class="tab"><a href="#informacoes_contato">Contato</a></li>
								<li class="tab"><a href="#informacoes_convenio">Convênios</a></li>
								<li class="tab"><a href="#observacoes">Observações</a></li>
								<li class="tab"><a href="#outras_informacoes">Outras informações</a></li>
							</ul>
						</div>

						<div class="card-body fixed-height border-top scroller" data-hide-x="true">

							<div class="row">

								<div class="col s12 m10 l10 offset-m2 offset-l1">

									<!-- BEGIN #informacoes_pessoais -->
									<div id="informacoes_pessoais">
										<div class="row">
											<div class="col s12 mt-3 mb-3">
												<h6>Informações pessoais</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m2 l2">
												<div class="foto circle flex flex-column flex-center">
													<div class="preview z-depth-3">
														<img src="<?php echo e(asset($paciente->imagem ?? 'img/avatar/icon.png')); ?>" alt="" style="<?php echo e(isset($paciente) && empty($paciente->imagem) ? 'opacity: 0.4;filter: grayscale(1);' : null); ?>">
													</div>
													<div class="change-photo btn btn-floating z-depth-3 waves-effect blue lighten-1">
														<label for="imagem" class="material-icons white-text cursor-pointer" style="line-height: inherit;">photo_camera</label>
														<input type="file" name="imagem" id="imagem" style="position: absolute; left: 0; top: 0; bottom: 0; opacity: 0; z-index: -1; cursor: pointer">
													</div>
												</div>
											</div>
											<div class="col s12 m10 l10">
												<div class="row">
													<div class="col s12 m8 l8">
														<div class="input-field">
															<label for="nome">Nome</label>
															<input type="text" name="nome" id="nome" value="<?php echo e($paciente->nome ?? null); ?>" autocapitalize="on">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="codigo" class="active">Matrícula</label>
															<div class="input-label">
																<?php if(isset($paciente)): ?>
																	<?php echo e($paciente->codigo); ?>

																<?php else: ?>
																	Será gerado automaticamente
																<?php endif; ?>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m4 l6">
														<label for="" class="active">Sexo</label>
														<div>
															<label class="input left mr-6">
																<input type="radio" name="sexo" value="M" class="with-gap" <?php echo e(isset($paciente) && $paciente->sexo == 'M' ? 'checked=checked' : null); ?>>
																<span>Masculino</span>
															</label>
															<label class="input left">
																<input type="radio" name="sexo" value="F" class="with-gap" <?php echo e(isset($paciente) && $paciente->sexo == 'F' ? 'checked=checked' : null); ?>>
																<span>Feminino</span>
															</label>
														</div>
													</div>
													<div class="col s12 m4 l6">
														<div class="input-field">
															<label for="data_nascimento" class="active">Data nascimento</label>
															<input type="text" name="data_nascimento" data-mask="date" value="<?php echo e($paciente->data_nascimento ?? null); ?>" placeholder="dd/mm/yyyy" data-max-date="<?php echo e(date('d/m/Y')); ?>">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="estado_civil">Estado civil</label>
															<select name="estado_civil" id="estado_civil">
																<?php $__currentLoopData = $estado_civil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<option value="<?php echo e($est->id); ?>" <?php echo e(isset($paciente) && $est->id==$paciente->id_estado_civil ? 'selected=selected' : null); ?>><?php echo e($est->descricao); ?></option>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</select>
														</div>
													</div>
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="etnia">Cor da pele</label>
															<select name="etnia" id="etnia">
																<option value="" disabled selected>Informe a cor da pele</option>
																<?php $__currentLoopData = $etnias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etnia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<option value="<?php echo e($etnia->id); ?>" <?php echo e(isset($paciente) && $etnia->id==$paciente->id_etnia ? 'selected=selected' : null); ?>><?php echo e($etnia->descricao); ?></option>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="cpf">CPF</label>
															<input type="tel" name="cpf" id="cpf" data-mask="cpf" maxlength="14" value="<?php echo e($paciente->cpf ?? null); ?>">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="rg">RG</label>
															<input type="tel" name="rg" id="rg" maxlength="18" value="<?php echo e($paciente->rg ?? null); ?>">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="cns">CNS</label>
															<input type="tel" name="cns" id="cns" maxlength="18" value="<?php echo e($paciente->cns ?? null); ?>">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="mae">Nome da mãe</label>
															<input type="text" name="mae" id="mae" value="<?php echo e($paciente->mae ?? null); ?>" autocapitalize="on">
														</div>
													</div>
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="pai">Nome do pai</label>
															<input type="text" name="pai" id="pai" value="<?php echo e($paciente->pai ?? null); ?>" autocapitalize="on">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12">
														<div class="input-field mb-6">
															<label for="notas">Observações</label>
															<textarea name="notas" id="notas" class="materialize-textarea"><?php echo e($paciente->notas ?? null); ?></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
										
									</div>
									<!-- END #informacoes_pessoais -->


									<!-- BEGIN #informacoes_contato -->
									<div id="informacoes_contato">
										<div class="row">
											<div class="col s12 mt-3 mb-3">
												<h6>Informações de contato</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m6 l4">
												<div class="input-field">
													<label for="email">E-mail</label>
													<input type="email" name="email" id="email" value="<?php echo e($paciente->email ?? null); ?>">
												</div>
											</div>
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="telefone">Telefone</label>
													<input type="tel" name="telefone" id="telefone" value="<?php echo e($paciente->telefone ?? null); ?>" data-mask="phone" maxlength="15">
												</div>
											</div>
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="celular">Celular</label>
													<input type="tel" name="celular" id="celular" value="<?php echo e($paciente->celular ?? null); ?>" data-mask="celular" maxlength="16">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m4 l4">
												<label for="receber_notificacoes" class="blue-text text-accent-1">Receber notificações</label>
												<div class="switch mt-3">
													<label>
														Off
														<input type="checkbox" name="receber_notificacoes" id="receber_notificacoes" value="on" <?php echo e(isset($paciente) && $paciente->receber_notificacoes == 'on' ? 'checked=checked' : null); ?>>
														<span class="lever"></span>
														On
													</label>
												</div>
											</div>
											<div class="col s12 m4 l4">
												<label for="receber_email" class="active blue-text text-accent-1"> Enviar notificações por e-mail</label>
												<div class="switch mt-3">
													<label>
														Off
														<input type="checkbox" name="receber_email" id="receber_email" value="on" <?php echo e(isset($paciente) && $paciente->receber_email == 'on' ? 'checked=checked' : null); ?>>
														<span class="lever"></span>
														On
													</label>
												</div>
											</div>
											<div class="col s12 m4 l4">
												<label for="receber_sms" class="active blue-text text-accent-1">Enviar notificações por whatsapp</label>
												<div class="switch mt-3">
													<label>
														Off
														<input type="checkbox" name="receber_sms" id="receber_sms" value="on" <?php echo e(isset($paciente) && $paciente->receber_sms == 'on' ? 'checked=checked' : null); ?>>
														<span class="lever"></span>
														On
													</label>
												</div>
											</div>
										</div>
									</div>
									<!-- END #informacoes_contato -->


									<!-- BEGIN #informacoes_convenio -->
									<div id="informacoes_convenio">

										<div class="row">
											<div class="col s12 m12 l12 mt-3 mb-3">
												<h6>Convênios</h6>
											</div>
										</div>

										<div class="row">
											<div class="col s12 l12 mb-3">
												<h6>
													<label for="associado" style="font-size: inherit; color: inherit;">
														<input type="checkbox" class="filled-in" name="associado" value="yes" id="associado" <?php if(isset($paciente) && $paciente->associado === 'yes'): ?> checked="checked" <?php endif; ?>>
														<span class="left">Paciente associado ao Plano Médicus24h</span>
													</label>
												</h6>
											</div>
										</div>

										<div id="conv_medicus24h" data-title="<?php echo e(isset($paciente) && $paciente->nome ? limpa_string($paciente->nome, '-') : null); ?>" class="<?php if( !isset($paciente) || (isset($paciente) && $paciente->associado === 'no') ): ?> hide <?php endif; ?>">

											<div class="row">
												<div class="col s7">
													<div class="row">
														<div class="col s6">
															<div class="input-field">
																<label for="convenio-<?php echo e(3); ?>">Convênio</label>
																<div class="input-label">
																	Médicus24h
																	<input type="hidden" name="convenio" id="convenio-<?php echo e(3); ?>" value="<?php echo e(3); ?>">
																</div>
															</div>
														</div>
														<div class="col s6">
															<div class="input-field">
																<label for="matricula-<?php echo e(3); ?>">Matrícula</label>
																<div class="input-label">
																	<?php
																		if(isset($paciente) && $paciente->matricula):
																		session()->forget('matricula');
																		$matricula = $paciente->matricula;
																		endif;
																	?>
																	<?php echo e($matricula); ?>

																</div>
																<input type="hidden" name="matricula" value="<?php echo e($matricula); ?>">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col s12">
															<div class="input-field">
																<label>Tipo do plano</label>
																<select name="id_tipo_convenio">
																	<option value="" disabled="disabled" selected="selected">Tipo do plano</option>
																	<?php if($medicus_tipo->count() > 0): ?>
																		<?php $__currentLoopData = $medicus_tipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																			<option value="<?php echo e($tipo->id); ?>" <?php if(isset($paciente) && $tipo->id === $paciente->convenio): ?> selected="selected" <?php endif; ?>><?php echo e($tipo->descricao); ?></option>
																		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																	<?php endif; ?>
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col s6">
															<div class="input-field">
																<label>Tipo de acomodação</label>
																<select name="id_acomodacao">
																	<option value="" disabled="disabled" selected="selected">Tipo de acomodação</option>
																	<?php $__currentLoopData = $acomodacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acomodacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																		<option value="<?php echo e($acomodacao->id); ?>" <?php if(isset($paciente) && $acomodacao->id === $paciente->acomodacao): ?> selected="selected" <?php endif; ?>><?php echo e($acomodacao->descricao); ?></option>
																	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																</select>
															</div>
														</div>
														<div class="col s6">
															<div class="input-field">
																<?php
																	$mes = null;
																	$ano = null;
																	if( isset($paciente) && $paciente->validade) :
																	$validade = explode('-', $paciente->validade);
																	$mes = $validade[1];
																	$ano = $validade[0];
																	endif;
																	$meses = ['01'=>'Jan', '02'=>'Fev', '03'=>'Mar', '04'=>'Abr', '05'=>'Mai', '06'=>'Jun', '07'=>'Jul', '08'=>'Ago', '09'=>'Set', '10'=>'Out', '11'=>'Nov', '12'=>'Dez',];
																?>
																<label for="validade">Validade</label>
																<div class="row">
																	<div class="col s6">
																		<select name="validade_mes" id="mes">
																			<option value="" disabled="disabled" selected="selected">Mês</option>
																			<?php $__currentLoopData = $meses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																				<option value="<?php echo e($i); ?>" <?php if($i==$mes): ?> selected="selected" <?php endif; ?>><?php echo e($m); ?></option>
																			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																		</select>
																	</div>
																	<div class="col s6">
																		<select name="validade_ano" id="ano">
																			<option value="" disabled="disabled" selected="selected">Ano</option>
																			<?php for($i = date('Y'); $i <= date('Y') + 20; $i ++): ?>
																				<option value="<?php echo e($i); ?>" <?php if($i==$ano): ?> selected="selected" <?php endif; ?>><?php echo e($i); ?></option>
																			<?php endfor; ?>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row">

													</div>
												</div>

												<div class="col s5">
													<div id="cartao_convenio" class="credit_card flex flex-end">
														<div class="frente z-depth-2 animated flipInY slow">
															<div class="logo left"></div>
															<div class="logo right">
																<h4>Assitência</h4>
																<h5>Saúde</h5>
															</div>
															<div class="content">
																<div class="row">
																	<div class="col s12">
																		<div class="row">
																			<div class="col s12 mt-6 mb-4">
																				<p id="nome_paciente"><?php echo e($paciente->nome ?? null); ?></p>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col s6">
																				
																			</div>
																			<div class="col s6">
																				
																			</div>
																		</div>
																		<div class="row">
																			<div class="col s6">
																				<span>Matrícula</span>
																				<p><?php echo e($matricula ?? null); ?></p>
																			</div>
																			<div class="col s6">
																				<span>Validade</span>
																				<p id="validade_convenio_paciente"><?php echo e(isset($paciente) && $paciente->validade ? $mes . '/' . $ano[2] . $ano[3] : null); ?></p>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="footer center-align">
																<p>www.medicus24h.com.br</p>
															</div>
														</div>
														<div class="verso z-depth-2">
															<div class="content">
																<div class="row">
																	<div class="col s12">
																		<div class="row">
																			<div class="col s6">
																				<span>Tipo do plano</span>
																				<p id="id_tipo_convenio"><?php echo e($paciente->tipo_plano ?? null); ?></p>
																			</div>
																			<div class="col s6">
																				<span>Acomodação</span>
																				<p id="id_acomodacao"><?php echo e($paciente->acomodacao ?? null); ?></p>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col s6">
																				<span>CNS</span>
																				<p id="cns_paciente"><?php echo e($paciente->cns ?? null); ?></p>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="footer center-align black"></div>
														</div>
													</div>
													<div class="row">
														<div class="col s12">
															<div id="print_card" class="pointer btn waves-effect orange darken-1">
																<i class="material-icons left">print</i>
																Imprimir cartão
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col s12 mb-3">
												<div class="divider"></div>
											</div>
										</div>

										

										<div class="row">
											<div class="col s12 mb-3">
												<button type="button" class="btn green flex blue darken-1 waves-effect" data-url="<?php echo e(go('clinica.pacientes.addplano')); ?>" data-trigger="add_plano">
													<i class="material-icons">add</i>
													<span>Adicionar Convenios</span>
												</button>
											</div>
										</div>

										<div class="row">
											<div class="col s12 mb-3">
												<table id="plano_saude">
													<thead>
														<tr>
															<th>Definido</th>
															<th>Convênio</th>
															<th>Tipo</th>
															<th>Acomodação</th>
															<th>Nº da Carteira</th>
															<th>Validade</th>
														</tr>
													</thead>
													<tbody>
														<?php if(isset($paciente_convenios) && $paciente_convenios->count()>0): ?>
															<?php $__currentLoopData = $paciente_convenios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $convenio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<tr id="<?php echo e($convenio->id); ?>">
																	<td class="center-align">
																		
																	</td>
																	<td><?php echo e($convenio->convenio); ?></td>
																	<td><?php echo e($convenio->tipo); ?></td>
																	<td><?php echo e($convenio->acomodacao); ?></td>
																	<td><?php echo e($convenio->matricula); ?></td>
																	<td><?php echo e($convenio->validade_mes . '/' . $convenio->validade_ano); ?></td>
																	<td>

																		<button type="button" id="<?php echo e($convenio->id); ?>" data-url="<?php echo e(go('clinica.pacientes.editplano', $convenio->id)); ?>" class="btn btn-floating btn-small teal lighten-2 waves-effect mr-6" data-trigger="edit_plano">
																			<i class="material-symbols-outlined">edit</i>
																		</button>
																		<button type="button" class="btn btn-floating btn-small red lighten-2 waves-effect">
																			<i class="material-symbols-outlined">delete</i>
																		</button>

																		<?php  $planos_de_saude = json_encode(['id_convenio'=> $convenio->id_convenio, 'id_tipo'=> $convenio->id_tipo, 'id_acomodacao'=> $convenio->id_acomodacao, 'matricula'=> $convenio->matricula, 'validade_ano'=> $convenio->validade_ano, 'validade_mes' => $convenio->validade_mes])  ?>

																		<input type="hidden" name="convenios[]" value="<?php echo e($planos_de_saude); ?>">

																	</td>

																</tr>

															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<?php else: ?>
															<tr id="convenio_vazio">
																<td colspan="6" class="center-align">Nenhum convênio cadastrado</td>
															</tr>
														<?php endif; ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!-- END #informacoes_convenio -->


									<!-- BEGIN #informacoes_endereco -->
									<div id="informacoes_endereco">
										<div class="row">
											<div class="col s12 mt-3 mb-3">
												<h6>Endereço</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="cep">CEP</label>
													<input type="tel" name="cep" id="cep" value="<?php echo e($paciente->cep ?? null); ?>" data-mask="cep">
												</div>
											</div>
											<div class="col s18 m6 l6">
												<div class="input-field">
													<label for="logradouro">Logradouro</label>
													<input type="text" name="logradouro" id="logradouro" value="<?php echo e($paciente->logradouro ?? null); ?>">
												</div>
											</div>
											<div class="col s4 m3 l2">
												<div class="input-field">
													<label for="numero">Número</label>
													<input type="tel" name="numero" id="numero" value="<?php echo e($paciente->numero ?? null); ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m6 l6">
												<div class="input-field">
													<label for="complemento">Complemento</label>
													<input type="text" name="complemento" id="complemento" value="<?php echo e($paciente->complemento ?? null); ?>">
												</div>
											</div>
											<div class="col s12 m6 l6">
												<div class="input-field">
													<label for="bairro">Bairro</label>
													<input type="text" name="bairro" id="bairro" value="<?php echo e($paciente->bairro ?? null); ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m5 l5">
												<div class="input-field">
													<label for="cidade">Cidade</label>
													<input type="text" name="cidade" id="cidade" value="<?php echo e($paciente->cidade ?? null); ?>">
												</div>
											</div>
											<div class="col s12 m3 l3">
												<div class="input-field">
													<label for="uf">UF</label>
													<input type="text" name="uf" id="uf" value="<?php echo e($paciente->uf ?? null); ?>">
												</div>
											</div>
											<div class="col s12 m4 l4">
												<div class="input-field">
													<label for="pais">País</label>
													<input type="text" name="pais" id="pais" value="<?php echo e($paciente->pais ?? null); ?>">
												</div>
											</div>
										</div>
									</div>
									<!-- END #informacoes_endereco -->

									<!-- BEGIN #observacoes -->
									<div id="observacoes">
										<div class="row">
											<div class="col s12 mt-3 mb-3">
												<h6>Observações</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m12 l12 mb-1">
												<label style="font-size: inherit;">Descreva as possíveis alergias do paciente:</label>
												<div id="notas_alergias" class="editor" data-placeholder="Alergias"><?php echo e($paciente->notas_alergias ?? null); ?></div>
											</div>
											<div class="col s12 m12 l12 mb-1">
												<label style="font-size: inherit;">Observações clínicas:</label>
												<div id="notas_clinicas" class="editor" data-placeholder="Notas clínicas" cols="30" rows="10"><?php echo e($paciente->notas_clinicas ?? null); ?></div>
											</div>
											<div class="col s12 m12 l12 mb-1">
												<label style="font-size: inherit;">Outras observações do paciente:</label>
												<div id="notas_gerais" class="editor" data-placeholder="Notas gerais" cols="30" rows="10"><?php echo e($paciente->notas_gerais ?? null); ?></div>
											</div>
										</div>
									</div>
									<!-- END #observacoes -->

									<!-- BEGIN #outras_informacoes -->
									<div id="outras_informacoes">
										<div class="row">
											<div class="col s12 mt-3 mb-3">
												<h6>Outras informações</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m4 l4">
												<label for="obito" class="active blue-text text-accent-1">Quadro clínico evoluiu para óbito</label>
												<div class="switch mt-3" id="obito">
													<label>
														Não
														<input type="checkbox" name="obito" id="obito" value="1" <?php echo e(isset($paciente) && $paciente->obito == '1' ? 'checked=checked' : null); ?>>
														<span class="lever"></span>
														Sim
													</label>
												</div>
												<br>
												<div class="row">
													<div class="col s4 m4 l12">
														<div class="input-field">
															<label for="data_obito">Data e hora do óbito</label>
															<input type="text" value="<?php echo e($paciente->data_obito ?? null); ?>" class="col s8 m4" name="data_obito" id="data_obito" data-mask="date" data-max-date="<?php echo e(date('d/m/Y')); ?>" placeholder="dd/mm/yyyy" <?php echo e(!isset($paciente) || (isset($paciente) && $paciente->obito == '0') ? 'disabled=disabled' : null); ?>>
															<input type="text" value="<?php echo e($paciente->hora_obito ?? null); ?>" class="col s4 m3" name="hora_obito" id="hora_obito" data-mask="time" placeholder="00:00" maxlength="5" <?php echo e(!isset($paciente) || (isset($paciente) && $paciente->obito == '0') ? 'disabled=disabled' : null); ?>>
														</div>
													</div>
												</div>
											</div>
											<div class="col s12 m4 l4">
												<label for="status" class="active blue-text text-accent-1">Paciente ativo</label>
												<div class="switch mt-3" id="status">
													<label>
														Não
														<input type="checkbox" name="status" id="status" value="1" <?php echo e(!isset($paciente) || (isset($paciente) && $paciente->status == '1') ? 'checked=checked' : null); ?>>
														<span class="lever"></span>
														Sim
													</label>
												</div>
											</div>
										</div>
									</div>
									<!-- END #outras_informacoes -->

								</div>

							</div>

						</div>

					</div>

					<div class="card-action right-align">

						<button type="reset" class="btn white black-text waves-effect mr-2" data-tooltip="Voltar" data-position="top" data-href="<?php echo e(go('clinica.pacientes.index')); ?>">
							<i class="material-icons-outlined">arrow_back</i>
						</button>

						<button type="submit" class="btn green waves-effect" data-tooltip="Salvar" data-position="top">
							<i class="material-icons-outlined">save</i>
						</button>

					</div>

					<div id="tarefas" class="card-reveal">
						<div class="row">
							<div class="col s12">
								<span class="card-title grey-text text-darken-4">
									Gestão de Cuidados
									<i class="material-icons right">close</i>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<p>Aqui você vincula o paciente aos programas que ele deve participar.</p>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<button type="button" class="btn green flex modal-trigger" data-target="modal_tarefas">
									<i class="material-icons">add</i>
									<span>Adicionar Tarefas</span>
								</button>
							</div>
						</div>
					</div>

				</div>

			</form>

		</div>

	</div>

</div>

<?php echo $__env->make('clinica.pacientes.modal_form_planos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div id="modal_tarefas" class="modal modal-fixed-footer" data-dismissible="false">

	<div class="modal-content">

		<h6>Tarefas do paciente</h6>

		<div class="modal-body mt-3">

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label>Título</label>
						<input type="text" name="tarefa_titulo" value="">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label>Descrição</label>
						<textarea class="materialize-textarea" name="tarefa_descricao"></textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label>Data e hora da realização</label>
						<input type="text" name="tarefa_data" value="" data-mask="date">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s4 m4 l6">
					<div class="input-field">
						<label for="data_obito">Data e hora do óbito</label>
						<input type="text" value="<?php echo e($paciente->data_obito ?? null); ?>" class="col s8 m4" name="data_obito" id="data_obito" data-mask="date" data-max-date="<?php echo e(date('d/m/Y')); ?>" placeholder="dd/mm/yyyy">
						<input type="text" value="<?php echo e($paciente->hora_obito ?? null); ?>" class="col s4 m3" name="hora_obito" id="hora_obito" data-mask="time" placeholder="00:00" maxlength="5">
					</div>
				</div>
			</div>

		</div>

	</div>
	<div class="modal-footer">
		<button type="reset" class="btn white black-text waves-effect mr-2 modal-close" data-tooltip="Voltar" data-position="top">
			<i class="material-icons-outlined">arrow_back</i>
		</button>

		<button type="submit" class="btn blue waves-effect" data-tooltip="Adicionar" data-position="top">
			<i class="material-icons-outlined">save</i>
		</button>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('clinica.layouts.forms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/pacientes/form.blade.php ENDPATH**/ ?>