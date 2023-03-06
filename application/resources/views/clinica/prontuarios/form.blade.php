@extends('clinica.body')

@section('title', 'Prontuários')

@section('main')

<div class="container pt-1">
	<div class="row">
		<div class="col s12">
			<form action="{{ go('clinica.pacientes.post') }}" method="{{ isset($row) ? 'put' : 'post' }}" enctype="multipart/form-data" autocomplete="off" novalidate>
				<div class="card">
					<div class="card-content">
						<div class="card-title mb-3">
							Novo paciente
						</div>
						<div id="tabs">
							<ul class="tabs">
								<li class="tab col s4"><a href="#informacoes_pessoais">Informações Pessoais</a></li>
								<li class="tab col s4"><a href="#informacoes_contato">Informações de contato</a></li>
								<li class="tab col s4"><a href="#informacoes_endereco">Informações de endereço</a></li>
							</ul>
						</div>
						<br>
						<div class="card-body scroller" data-scroll-x="true">
							<div class="row">
								<div class="col s12 m10 l10 offset-m2 offset-l2">

									<div id="informacoes_pessoais">

										<div class="row">
											<div class="col s12">
												<h6>Informações pessoais</h6>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m4 l3">
												<div class="input-field">
													<label for="cpf">CPF</label>
													<input type="tel" name="cpf" id="cpf" class="is_cpf" value="{{ $row->cpf ?? null }}">
													@if($row)
														<input type="hidden" name="id" value="{{ $row->id }}">
													@endif
												</div>
											</div>
											<div class="col s12 m4 l3">
												<div class="input-field">
													<label for="rg">RG</label>
													<input type="tel" name="rg" id="rg" value="{{ $row->rg ?? null }}">
												</div>
											</div>
											<div class="col s12 m4 l3">
												<div class="input-field">
													<label for="sus">SUS</label>
													<input type="tel" name="sus" id="sus" value="{{ $row->sus ?? null }}">
												</div>
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
										</div>
										<div class="row">
											<div class="col s12 m8 l8">
												<div class="input-field">
													<label for="nome">Nome</label>
													<input type="text" name="nome" id="nome" value="{{ $row->nome ?? null }}" autocapitalize="on">
												</div>
											</div>
											<div class="col s12 m4 l4">
												<div class="input-field">
													<label for="data_nascimento" class="active">Data nascimento</label>
													<input type="text" name="data_nascimento" class="is_date" value="{{ $row->data_nascimento ?? null }}" placeholder="dd/mm/yyyy" data-start="01/01/1900" data-end="{{ date('d/m/Y') }}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12 m6 l6">
												<div class="row">
													<div class="col s12 mb-4">
														<div class="input-field">
															<label for="" class="active">Sexo</label>
														</div>
													</div>
												</div>
												<label>
													<input type="radio" name="sexo" value="M" class="with-gap" {{ $row && $row->sexo == 'M' ? 'checked=checked' : null }}>
													<span>Masculino</span>
												</label>
												<label>
													<input type="radio" name="sexo" value="F" class="with-gap" {{ $row && $row->sexo == 'F' ? 'checked=checked' : null }}>
													<span>Feminino</span>
												</label>
											</div>
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

									<div id="informacoes_contato">
										<div class="row">
											<div class="col s12">
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
											<div class="col s12">
												<div class="row">
													<div class="col s12 m3 l4">
														<div class="input-field ">
															<label for="receber_notificacoes" class="active">Receber notificações</label>
														</div>
														<div class="switch mb-6 mt-10" id="notificacoes">
															<label>
																Off
																<input type="checkbox" name="receber_notificacoes" id="receber_notificacoes" value="1" {{ $row && $row->receber_notificacoes == '1' ? 'checked=checked' : null }}>
																<span class="lever"></span>
																On
															</label>
														</div>
													</div>
													<div class="col s12 m3 l4">
														<div class="input-field ">
															<label for="receber_email" class="active">Enviar notificações por e-mail</label>
														</div>
														<div class="switch mb-6 mt-10" id="receber_email">
															<label>
																Off
																<input type="checkbox" name="receber_email" id="receber_email" value="1" {{ $row && $row->receber_email == '1' ? 'checked=checked' : null }}>
																<span class="lever"></span>
																On
															</label>
														</div>
													</div>
													<div class="col s12 m3 l4">
														<div class="input-field ">
															<label for="receber_sms" class="active">Enviar notificações por whatsapp</label>
														</div>
														<div class="switch mb-6 mt-10" id="receber_sms">
															<label>
																Off
																<input type="checkbox" name="receber_sms" id="receber_sms" value="1" {{ $row && $row->receber_sms == '1' ? 'checked=checked' : null }}>
																<span class="lever"></span>
																On
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="informacoes_endereco">
										<div class="row">
											<div class="col s12">
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
								</div>
							</div>
						</div>

						<div class="card-footer">
							<button class="btn green right">
								{{-- <span>Salvar</span> --}}
								<i class="material-icons-outlined">save</i>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



@endsection
