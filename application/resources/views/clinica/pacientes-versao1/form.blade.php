@extends('clinica.body')

@section('prev-url', route('clinica.pacientes.index'))
@section('title', 'Pacientes')

@section('main')

<div class="container pt-1" style="width: 100%">

	<div class="row">

		<div class="col s12">

			<form action="{{ go('clinica.pacientes.post') }}" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>

				@csrf

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
									<a href="#informacoes_convenio" class="active">
										{{-- <i class="material-icons-outlined">list</i> --}}
										Convênios
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

									<!-- BEGIN #informacoes_convenio -->
									<div id="informacoes_convenio">

										<div class="row">
											<div class="col s12 m12 l12 mt-3 mb-3">
												<h6>Convênios</h6>
											</div>
										</div>

										<div class="row">
											<div class="col s12 m12 l12 mb-3">
												<h6>
													<label for="associado" style="font-size: inherit; color: inherit;">
														<input type="checkbox" name="associado" class="filled-in" id="associado" value="yes" @if($row && $row -> associado === 'yes') checked="checked" @endif>
														<span class="left">Paciente associado ao Plano Médicus24h</span>
													</label>
												</h6>
											</div>
										</div>

										<div id="conv_medicus24h" data-title="{{ $row && $row->nome ? limpa_string($row->nome, '-') : null }}" class="@if(!$row || ($row && $row->associado === 'no')) hide @endif">
											<div class="row">
												<div class="col s6">
													<div class="row">
														<div class="col s6">
															<div class="input-field">
																<label for="convenio">Convênio</label>
																<div class="input-label">
																	Medicus24h
																	<input type="hidden" name="convenio" value="{{ 3 }}">
																</div>
															</div>
														</div>
														<div class="col s6">
															<div class="input-field">
																<label class="active" for="carteira">Matrícula</label>
																<div class="input-label">
																	@php
																		if($row && $row->matricula):
																		session()->forget('matricula');
																		$matricula = $row->matricula;
																		endif;
																	@endphp
																	{{ $matricula }}
																	<input type="hidden" name="matricula" value="{{ $matricula }}">
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col s12">
															<div class="input-field">
																<label for="id_tipo">Tipo do Convênio</label>
																<select name="id_tipo" id="id_tipo">
																	<option value="" disabled selected>Informe o convênio</option>
																	@foreach($convenios_medicus_tipo as $convenio)
																		<option value="{{ $convenio->id }}" {{ isset($row) && $convenio->id==$row->id_tipo ? 'selected=selected' : null }}>{{ $convenio->descricao }}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<div class="col s12">
															<div class="input-field">
																<label for="id_acomodacao">Tipo de acomodação</label>
																<select name="id_acomodacao" id="id_acomodacao">
																	<option value="" disabled selected>Informe o tipo de acomodação</option>
																	@foreach($acomodacoes as $acomodacao)
																		<option value="{{ $acomodacao->id }}" {{ isset($row) && $acomodacao->id==$row->id_acomodacao ? 'selected=selected' : null }}>{{ $acomodacao->descricao }}</option>
																	@endforeach
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col s12">
															<div class="input-field">
																<label class="active">Validade</label>
																@php
																	$mes = null;
																	$ano = null;
																	if( $row && $row->validade) {
																	$validade = explode('-', $row->validade);
																	$mes = $validade[1];
																	$ano = $validade[0];
																	}
																	$meses = ['01'=>'Jan', '02'=>'Fev', '03'=>'Mar', '04'=>'Abr', '05'=>'Mai', '06'=>'Jun', '07'=>'Jul', '08'=>'Ago', '09'=>'Set', '10'=>'Out', '11'=>'Nov', '12'=>'Dez',];
																@endphp
																<div class="row">
																	<div class="col s6">
																		<select name="validade_mes" id="mes">
																			<option value="" selected="selected" disabled="disabled">Mês</option>
																			@foreach($meses as $i => $m)
																				<option value="{{ $i }}" @if($i==$mes) selected="selected" @endif>{{ $m }}</option>
																			@endforeach
																		</select>
																	</div>
																	<div class="col s6">
																		<select name="validade_ano" id="ano">
																			<option value="" selected="selected" disabled="disabled">Ano</option>
																			@for($i = date('Y'); $i <= date('Y') + 20; $i ++)
																				<option value="{{ $i }}" @if($i==$ano) selected="selected" @endif>{{ $i }}</option>
																			@endfor
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col s6">
													<div id="cartao_convenio" class="credit_card flex flex-end">
														<div class="frente z-depth-3 animated flipInY slow">
															<div class="logo left"></div>
															<div class="logo right">
																<h4>Assistência</h4>
																<h5>Saúde</h5>
															</div>
															<div class="content">
																<div class="row">
																	<div class="col s12">
																		<div class="row">
																			<div class="col s12 mt-6 mb-4">
																				{{-- <span>Nome</span> --}}
																				<p id="nome_paciente">{{ $row->nome ?? null }}</p>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col s6">
																				{{-- <span>CPF</span>
																				<p id="cpf_paciente">{{ $row->cpf ?? null }}</p> --}}
																			</div>
																			<div class="col s6">
																				{{-- <span>Data de nascimento</span>
																				<p id="data_nascimento_paciente">{{ $row->data_nascimento ?? null }}</p> --}}
																			</div>
																		</div>
																		<div class="row">
																			<div class="col s6">
																				<span>Matrícula</span>
																				<p>{{ $matricula ?? null }}</p>
																			</div>
																			<div class="col s6">
																				<span>Validade</span>
																				<p id="validade_convenio_paciente">{{ $row && $row->validade ? $mes . '/' . $ano[2] . $ano[3] : null }}</p>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="footer center-align">
																<p>www.medicus24h.com.br</p>
															</div>
														</div>
														<div class="verso z-depth-3">
															<div class="content">
																<div class="row">
																	<div class="col s12">
																		<div class="row">
																			<div class="col s6">
																				<span>Tipo do plano</span>
																				<p id="tipo_plano">{{ $row->tipo_plano ?? null }}</p>
																			</div>
																			<div class="col s6">
																				<span>Acomodação</span>
																				<p id="acomodacao_plano">{{ $row->acomodacao ?? null }}</p>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col s6">
																				<span>CNS</span>
																				<p id="cns_paciente">{{ $row->cns ?? null }}</p>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col s12">
																				<span>Validade</span>
																				<p id="validade_convenio_paciente">{{ $row && $row->validade ? $mes . '/' . $ano[2] . $ano[3] : null }}</p>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="footer center-align black">
															</div>
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
											<div class="row">
												<div class="col s12">
													<div class="divider mt-3 mb-3"></div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col s12 m6 l6 mt-3 mb-3">
												<h6>Outros Convênios</h6>
											</div>
										</div>

										<div class="row">
											<div class="col s12 m6 l3 mb-3">
												<button type="button" data-url="{{ go('clinica.pacientes.addplano') }}" class="btn flex blue darken-1 waves-effect" data-trigger="add_plano" style="width: 100%;">
													<i class="material-icons mr-6">add</i>
													Adicionar Convênio
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
														{{-- @include('clinica.pacientes.convenios') --}}
														@if($paciente_convenios->count()>0)
															@foreach($paciente_convenios as $convenio)
																@if($convenio->id_convenio != 3)
																	<tr id="{{ $convenio->id }}">
																		<td class="center-align">
																			{{-- <label>
																			<input type="radio" name="plano_padrao" value="1">
																			<i class="material-icons mt-1 pointer {{ null }}" data-tooltip="Convênio ativo">verified</i>
																			<span class="hide"></span>
																			</label> --}}
																		</td>
																		<td>{{ $convenio->convenio }}</td>
																		<td>{{ $convenio->tipo }}</td>
																		<td>{{ $convenio->acomodacao }}</td>
																		<td>{{ $convenio->matricula }}</td>
																		<td>{{ $convenio->validade_mes . '/' . $convenio->validade_ano }}</td>
																		<td>

																			<button type="button" id="{{ $convenio->id }}" data-url="{{ go('clinica.pacientes.editplano', $convenio->id) }}" class="btn btn-floating btn-small teal lighten-2 waves-effect mr-6" data-trigger="edit_plano">
																				<i class="material-symbols-outlined">edit</i>
																			</button>
																			<button type="button" class="btn btn-floating btn-small red lighten-2 waves-effect">
																				<i class="material-symbols-outlined">delete</i>
																			</button>

																			{? $outros_convenios = json_encode(['id_convenio'=> $convenio->convenio, 'id_tipo'=> $convenio->tipo, 'id_acomodacao'=> $convenio->acomodacao, 'matricula'=> $convenio->matricula, 'validade_ano'=> $convenio->validade_ano, 'validade_mes' => $convenio->validade_mes]) ?}

																			<input type="hidden" name="convenios[]" value="{{ $outros_convenios }}">

																		</td>

																	</tr>

																@endif
															@endforeach
														@endif
													</tbody>
												</table>
											</div>
										</div>

									</div>
									<!-- END #informacoes_convenio -->

								</div>

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


				</div>

			</form>

		</div>

	</div>

</div>

@include('clinica.pacientes.modal_form_planos')

<div id="modal_cartao_convenio" class="modal modal-fixed-footer">
	<div class="modal-content white"></div>
	<div class="modal-footer">

		<button type="reset" class="btn waves-effect modal-close white mr-2">
			<i class="material-symbols-outlined black-text">close</i>
		</button>

		<button type="button" class="btn waves-effect" data-trigger="print">
			<i class="material-symbols-outlined">print</i>
		</button>
	</div>
</div>

@endsection
