@extends('clinica.body')

@section('title', 'Prontuários')

@section('main')

<div class="container pt-1" style="width: 100%">
	<div class="row">
		<div class="col s12">
			<form action="{{ go(inica.pacientes.post') }}" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>

				@if($row)
					<input type="hidden" name="id" value="{{ $row->id }}">
					<input type="hidden" name="_method" value="put">
				@endif

				<div class="card">
					<div class="card-content fixed-height">
						<div class="card-title mb-1">
							Novo paciente
						</div>
						<div class="row">
							<div id="tabs">
								<ul class="tabs">
									<li class="tab col l3"><a href="#informacoes_pessoais">Dados Pessoais</a></li>
									<li class="tab col l3"><a href="#informacoes_contato">Contato</a></li>
									<li class="tab col l2"><a href="#informacoes_convenio">Convênio</a></li>
									<li class="tab col l2"><a href="#informacoes_endereco">Endereço</a></li>
									<li class="tab col l2"><a href="#outras_informacoes">Outros</a></li>
								</ul>
							</div>
						</div>
						<div class="card-body pt-2 fixed-height scroller" data-scroll-x="true">
							<div class="row">
								<div class="col s10 offset-s1">

									<!-- BEGIN #informacoes_pessoais -->
									<div id="informacoes_pessoais">
										<div class="row">
											<div class="col s12 mt-1 mb-4">
												<h6>Informações pessoais</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s2">
												<div id="foto-paciente" class="circle flex flex-column flex-center">
													<div id="foto">
														<img src="{{ asset($row->imagem ?? 'img/avatar/icon.png') }}" alt="" style="{{ isset($row) && empty($row->imagem) ? 'opacity: 0.4;filter: grayscale(1);' : null }}">
													</div>
													<div id="change-photo" class="btn btn-floating z-depth-3 waves-effect blue lighten-1">
														<label for="imagem" class="material-icons white-text cursor-pointer" style="line-height: inherit;">photo_camera</label>
														<input type="file" name="imagem" id="imagem" style="position: absolute; left: 0; top: 0; bottom: 0; opacity: 0; z-index: -1; cursor: pointer">
													</div>
												</div>
											</div>
											<div class="col s10">
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
															<input type="text" name="data_nascimento" class="is_date" value="{{ $row->data_nascimento ?? null }}" placeholder="dd/mm/yyyy" data-max-date="{{ date('d/m/Y') }}">
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
															<input type="tel" name="cpf" id="cpf" class="is_cpf" value="{{ $row->cpf ?? null }}">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="rg">RG</label>
															<input type="tel" name="rg" id="rg" value="{{ $row->rg ?? null }}">
														</div>
													</div>
													<div class="col s12 m4 l4">
														<div class="input-field">
															<label for="cns">CNS</label>
															<input type="tel" name="cns" id="cns" value="{{ $row->cns ?? null }}">
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
											<div class="col s12 mt-1 mb-4">
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
													<input type="tel" name="telefone" id="telefone" value="{{ $row->telefone ?? null }}" class="is_phone">
												</div>
											</div>
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="celular">Celular</label>
													<input type="tel" name="celular" id="celular" value="{{ $row->celular ?? null }}" class="is_celular">
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
											<div class="col s12 mt-1 mb-4">
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
													<input type="text" name="validade_convenio" id="validade_convenio" value="{{ $row->validade_convenio ?? null }}" class="is_date" data-min-date="{{ date('d/m/Y') }}">
												</div>
											</div>
										</div>
									</div>
									<!-- END #informacoes_convenio -->

									<!-- BEGIN #informacoes_endereco -->
									<div id="informacoes_endereco">
										<div class="row">
											<div class="col s12 mt-1 mb-4">
												<h6>Endereço</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m3 l4">
												<div class="input-field">
													<label for="cep">CEP</label>
													<input type="tel" name="cep" id="cep" class="is_cep" value="{{ $row->cep ?? null }}" class="is_cep">
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

									<!-- BEGIN #outras_informacoes -->
									<div id="outras_informacoes">
										<div class="row">
											<div class="col s12 mt-1 mb-4">
												<h6>Outras informações</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m4 l4">
												<label for="status" class="active blue-text text-accent-1">Paciente ativo</label>
												<div class="switch mt-3" id="status">
													<label>
														Off
														<input type="checkbox" name="status" id="status" value="1" {{ !$row || ($row && $row->status == '1') ? 'checked=checked' : null }}>
														<span class="lever"></span>
														On
													</label>
												</div>
											</div>
											<div class="col s12 m4 l4">
												<label for="obito" class="active blue-text text-accent-1">Quadro clínico evoluiu para óbito</label>
												<div class="switch mt-3" id="obito">
													<label>
														Off
														<input type="checkbox" name="obito" id="obito" value="1" {{ $row && $row->obito == '1' ? 'checked=checked' : null }}>
														<span class="lever"></span>
														On
													</label>
												</div>
											</div>
										</div>
									</div>
									<!-- END #outras_informacoes -->
								</div>
							</div>
						</div>

						<div class="card-footer right-align">
							<button type="reset" class="btn white black-text waves-effect" data-tooltip="Cancelar" data-href="{{ go('clinica.pacientes.index') }}">
								<i class="material-icons">arrow_back</i>
							</button>

							<button type="submit" class="btn green waves-effect" data-tooltip="Salvar">
								<i class="material-icons">save</i>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



@endsection
