@extends('clinica.body')

@section('prev-url', route('clinica.pacientes.index'))
@section('title', 'Pacientes')

@section('main')

<div class="container pt-1" style="width: 100%">
	<div class="row">
		<div class="col s12">
			<form action="{{ go('clinica.pacientes.post') }}" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>

				@if($row)
					<input type="hidden" name="id" value="{{ $row->id }}">
					<input type="hidden" name="_method" value="put">
				@endif

				<div class="card">
					<div class="card-content no-padding">

						<div class="card-title pl-2 pt-2">
							@if($row)
								Editar: {{ $row->nome }}
							@else
								Cadastrar paciente
							@endif
						</div>

						<div id="tabs">
							<ul class="tabs tabs-fixed-width">
								<li class="tab">
									<a href="#informacoes_pessoais">
										{{-- <i class="material-icons-outlined">list</i> --}}
										Dados Pessoais
									</a>
								</li>
								<li class="tab">
									<a href="#informacoes_contato">
										{{-- <i class="material-icons-outlined">list</i> --}}
										Contato
									</a>
								</li>
								<li class="tab">
									<a href="#informacoes_convenio">
										{{-- <i class="material-icons-outlined">list</i> --}}
										Convênio
									</a>
								</li>
								<li class="tab">
									<a href="#informacoes_endereco">
										{{-- <i class="material-icons-outlined">list</i> --}}
										Endereço
									</a>
								</li>
								<li class="tab">
									<a href="#observacoes">
										{{-- <i class="material-icons-outlined">list</i> --}}
										Observações
									</a>
								</li>
								<li class="tab">
									<a href="#outras_informacoes">
										{{-- <i class="material-icons-outlined">list</i> --}}
										Outras Informações
									</a>
								</li>
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
														<img src="{{ asset($row->imagem ?? 'img/avatar/icon.png') }}" alt="" style="{{ isset($row) && empty($row->imagem) ? 'opacity: 0.4;filter: grayscale(1);' : null }}">
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
															<input type="text" name="nome" id="nome" value="{{ $row->nome ?? null }}" autocapitalize="on">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="codigo" class="active">Código</label>
															<div class="input-label">
																@if($row && $row->codigo)
																	{{ $row->codigo }}
																@else
																	<span style="font-size: 12px">Será gerado automaticamente</span>
																@endif
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m4 l6">
														<label for="" class="active">Sexo</label>
														<div>
															<label class="input left mr-6">
																<input type="radio" name="sexo" value="M" class="with-gap" {{ $row && $row->sexo == 'M' ? 'checked=checked' : null }}>
																<span>Masculino</span>
															</label>
															<label class="input left">
																<input type="radio" name="sexo" value="F" class="with-gap" {{ $row && $row->sexo == 'F' ? 'checked=checked' : null }}>
																<span>Feminino</span>
															</label>
														</div>
													</div>
													<div class="col s12 m4 l6">
														<div class="input-field">
															<label for="data_nascimento" class="active">Data nascimento</label>
															<input type="text" name="data_nascimento" data-mask="date" value="{{ $row->data_nascimento ?? null }}" placeholder="dd/mm/yyyy" data-max-date="{{ date('d/m/Y') }}">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="estado_civil">Estado civil</label>
															<select name="estado_civil" id="estado_civil">
																@foreach($estado_civil as $est)
																	<option value="{{ $est->id }}" {{ $row && $est->id==$row->id_estado_civil ? 'selected=selected' : null }}>{{ $est->descricao }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="etnia">Cor da pele</label>
															<select name="etnia" id="etnia">
																<option value="" disabled selected>Informe a cor da pele</option>
																@foreach($etnias as $etnia)
																	<option value="{{ $etnia->id }}" {{ $row && $etnia->id==$row->id_etnia ? 'selected=selected' : null }}>{{ $etnia->descricao }}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="cpf">CPF</label>
															<input type="tel" name="cpf" id="cpf" data-mask="cpf" maxlength="14" value="{{ $row->cpf ?? null }}">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="rg">RG</label>
															<input type="tel" name="rg" id="rg" maxlength="18" value="{{ $row->rg ?? null }}">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="cns">CNS</label>
															<input type="tel" name="cns" id="cns" maxlength="18" value="{{ $row->cns ?? null }}">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="mae">Nome da mãe</label>
															<input type="text" name="mae" id="mae" value="{{ $row->mae ?? null }}" autocapitalize="on">
														</div>
													</div>
													<div class="col s12 m6 l6">
														<div class="input-field">
															<label for="pai">Nome do pai</label>
															<input type="text" name="pai" id="pai" value="{{ $row->pai ?? null }}" autocapitalize="on">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col s12">
														<div class="input-field mb-6">
															<label for="notas">Observações</label>
															<textarea name="notas" id="notas" class="materialize-textarea">{{ $row->notas ?? null }}</textarea>
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
													<input type="email" name="email" id="email" value="{{ $row->email ?? null }}">
												</div>
											</div>
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="telefone">Telefone</label>
													<input type="tel" name="telefone" id="telefone" value="{{ $row->telefone ?? null }}" data-mask="phone" maxlength="15">
												</div>
											</div>
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="celular">Celular</label>
													<input type="tel" name="celular" id="celular" value="{{ $row->celular ?? null }}" data-mask="celular" maxlength="16">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m4 l4">
												<label for="receber_notificacoes" class="blue-text text-accent-1">Receber notificações</label>
												<div class="switch mt-3">
													<label>
														Off
														<input type="checkbox" name="receber_notificacoes" id="receber_notificacoes" value="on" {{ $row && $row->receber_notificacoes == 'on' ? 'checked=checked' : null }}>
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
														<input type="checkbox" name="receber_email" id="receber_email" value="on" {{ $row && $row->receber_email == 'on' ? 'checked=checked' : null }}>
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
														<input type="checkbox" name="receber_sms" id="receber_sms" value="on" {{ $row && $row->receber_sms == 'on' ? 'checked=checked' : null }}>
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
											<div class="col s12 m6 l6 mt-3 mb-3">
												<h6>Plano Médicus24h</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m6 l6">
												<span class="label">Paciente conveniado?</span>
												<div class="switch mt-3">
													<label class="">
														Não
														<input type="checkbox" name="conveniado" id="conveniado" value="1" {{ $row && $row->conveniado == '1' ? 'checked=checked' : null }}>
														<span class="lever"></span>
														Sim
													</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m3 l3">
												<div class="input-field">
													<label for="carteira">Carteira Médicus24h</label>
													<input type="text" name="numero_carteira" value="{{ $row->numero_carteira ?? null }}" data-mask="credit_card">
												</div>
											</div>
											<div class="col s12 m3 l3">
												<div class="input-field">
													<label for="carteira">Carteira Médicus24h</label>
													<input type="text" name="numero_carteira" value="{{ $row->numero_carteira ?? null }}" data-mask="credit_card">
												</div>
											</div>
											<div class="col s12 m4 l4">
												<div class="input-field">
													<label for="tipo_convenio">Tipo do convênio</label>
													<select name="tipo_convenio" id="tipo_convenio">
														<option value="" disabled selected>Informe o convênio</option>
														{{-- @foreach($convenios as $convenio)
															<option value="{{ $convenio->id }}" {{ $row && $convenio->id==$row->id_convenio ? 'selected=selected' : null }}>{{ $convenio->descricao }}</option>
														@endforeach--}}
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 mt-3 mb-3">
												<h6>Convênio</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m4 l4">
												<div class="input-field">
													<label for="convenio">Convênio</label>
													<select name="convenio" id="convenio">
														<option value="" disabled selected>Informe o convênio</option>
														@foreach($convenios as $convenio)
															<option value="{{ $convenio->id }}" {{ $row && $convenio->id==$row->id_convenio ? 'selected=selected' : null }}>{{ $convenio->descricao }}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col s12 m4 l4">
												<div class="input-field">
													<label for="acomodacao">Acomodação</label>
													<select name="acomodacao" id="acomodacao">
														<option value="" disabled selected>Informe o tipo de acomodação</option>
														@foreach($acomodacoes as $acomodacao)
															<option value="{{ $acomodacao->id }}" {{ $row && $acomodacao->id==$row->id_acomodacao ? 'selected=selected' : null }}>{{ $acomodacao->descricao }}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="matricula">Matrícula</label>
													<input type="text" name="matricula" id="matricula" value="{{ $row->matricula_convenio ?? null }}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="validade_convenio">Validade</label>
													<input type="text" name="validade_convenio" id="validade_convenio" value="{{ $row->validade_convenio ?? null }}" data-mask="date" data-min-date="{{ date('d/m/Y') }}">
												</div>
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
													<input type="tel" name="cep" id="cep" value="{{ $row->cep ?? null }}" data-mask="cep">
												</div>
											</div>
											<div class="col s18 m6 l6">
												<div class="input-field">
													<label for="logradouro">Logradouro</label>
													<input type="text" name="logradouro" id="logradouro" value="{{ $row->logradouro ?? null }}">
												</div>
											</div>
											<div class="col s4 m3 l2">
												<div class="input-field">
													<label for="numero">Número</label>
													<input type="tel" name="numero" id="numero" value="{{ $row->numero ?? null }}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m6 l6">
												<div class="input-field">
													<label for="complemento">Complemento</label>
													<input type="text" name="complemento" id="complemento" value="{{ $row->complemento ?? null }}">
												</div>
											</div>
											<div class="col s12 m6 l6">
												<div class="input-field">
													<label for="bairro">Bairro</label>
													<input type="text" name="bairro" id="bairro" value="{{ $row->bairro ?? null }}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m5 l5">
												<div class="input-field">
													<label for="cidade">Cidade</label>
													<input type="text" name="cidade" id="cidade" value="{{ $row->cidade ?? null }}">
												</div>
											</div>
											<div class="col s12 m3 l3">
												<div class="input-field">
													<label for="uf">UF</label>
													<input type="text" name="uf" id="uf" value="{{ $row->uf ?? null }}">
												</div>
											</div>
											<div class="col s12 m4 l4">
												<div class="input-field">
													<label for="pais">País</label>
													<input type="text" name="pais" id="pais" value="{{ $row->pais ?? null }}">
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
												<div id="notas_alergias" class="editor" data-placeholder="Alergias">{{ $row->notas_alergias ?? null }}</div>
											</div>
											<div class="col s12 m12 l12 mb-1">
												<label style="font-size: inherit;">Observações clínicas:</label>
												<div id="notas_clinicas" class="editor" data-placeholder="Notas clínicas" cols="30" rows="10">{{ $row->notas_clinicas ?? null }}</div>
											</div>
											<div class="col s12 m12 l12 mb-1">
												<label style="font-size: inherit;">Outras observações do paciente:</label>
												<div id="notas_gerais" class="editor" data-placeholder="Notas gerais" cols="30" rows="10">{{ $row->notas_gerais ?? null }}</div>
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
														<input type="checkbox" name="obito" id="obito" value="1" {{ $row && $row->obito == '1' ? 'checked=checked' : null }}>
														<span class="lever"></span>
														Sim
													</label>
												</div>
												<br>
												<div class="row">
													<div class="col s4 m4 l12">
														<div class="input-field">
															<label for="data_obito">Data e hora do óbito</label>
															<input type="text" value="{{ $row->data_obito ?? null }}" class="col s8 m4" name="data_obito" id="data_obito" data-mask="date" data-max-date="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy" {{ !$row || ($row && $row->obito == '0') ? 'disabled=disabled' : null }}>
															<input type="text" value="{{ $row->hora_obito ?? null }}" class="col s4 m3" name="hora_obito" id="hora_obito" data-mask="time" placeholder="00:00" maxlength="5" {{ !$row || ($row && $row->obito == '0') ? 'disabled=disabled' : null }}>
														</div>
													</div>
												</div>
											</div>
											<div class="col s12 m4 l4">
												<label for="status" class="active blue-text text-accent-1">Paciente ativo</label>
												<div class="switch mt-3" id="status">
													<label>
														Não
														<input type="checkbox" name="status" id="status" value="1" {{ !$row || ($row && $row->status == '1') ? 'checked=checked' : null }}>
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

						<div class="card-action right-align">
							<button type="reset" class="btn white black-text waves-effect mr-2" data-tooltip="Voltar" data-position="top" data-href="{{ go('clinica.pacientes.index') }}">
								<i class="material-icons-outlined">arrow_back</i>
							</button>

							<button type="submit" class="btn green waves-effect" data-tooltip="Salvar" data-position="top">
								<i class="material-icons-outlined">save</i>
							</button>
						</div>

						@csrf

					</div>

				</div>

			</form>

		</div>

	</div>

</div>



@endsection
