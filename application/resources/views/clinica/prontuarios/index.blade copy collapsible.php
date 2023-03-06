@extends('clinica.body')

@section('title', 'Prontuários')

@section('main')

<div class="container prontuario no-padding">

	<div class="row">

		<div class="col s3 no-padding z-depth-2">

			<div class="card paciente no-margin flex-start">

				<div class="card-content">

					<div class="card-title pt-6 mb-3">

						<div class="foto circle flex flex-column flex-center">
							<div class="preview z-depth-3">
								<img src="{{ asset($row->imagem ?? 'img/avatar/icon.png') }}" alt="" style="{{ isset($row) && empty($row->imagem) ? 'opacity: 0.4;filter: grayscale(1);' : null }}">
							</div>
						</div>

						<div class="row">

							<div class="col s12 pt-6 pb-6 center-align">
								<h5 class="title">
									{{ $paciente->nome }}
								</h5>
								<p class="idade mt-2">{{ idade($paciente->data_nascimento) ?? 'Não informado' }}</p>
							</div>

						</div>

						<hr class="grey lighten-2">

					</div>

					<div class="row">

						<div class="card-body scroller" style="height: calc(100vh - 350px); overflow: scroll;">

							<div class="col s12">

								<div class="estatisticas row">
									<div class="col s12 mt-1 left-align flex flex-center">
										<span class="bold mr-3">Retorno agendado:</span>
										<span> {{ 'Não agendado' }} </span>
									</div>
									<div class="col s12 mt-1 left-align flex flex-center">
										<span class="bold mr-3">Consultas realizadas:</span>
										<span> {{ '0' }} </span>
									</div>
									<div class="col s12 mt-1 left-align flex flex-center">
										<span class="bold mr-3">Consultas canceladas:</span>
										<span> {{ '0' }} </span>
									</div>
									<div class="col s12 mt-1 left-align flex flex-center">
										<span class="bold mr-3">Consultas remarcadas:</span>
										<span> {{ '0' }} </span>
									</div>
								</div>

								<hr class="grey lighten-2">

								<ul class="dados-pessoais">
									<li>
										<a title="Data de nascimento">
											<span class="material-symbols-outlined mr-3 left">cake</span>
											<span> {{ $paciente->data_nascimento ?? 'Não informado' }} </span>
										</a>
									</li>
									<li>
										<a title="CPF">
											<span class="material-symbols-outlined mr-3 left">credit_card</span>
											<span> {{ $paciente->cpf ?? 'Não informado' }} </span>
										</a>
									</li>
									<li>
										<a title="Telefone">
											<span class="material-symbols-outlined mr-3 left">call</span>
											<span> {{ $paciente->telefone  ?? 'Não informado' }} </span>
										</a>
									</li>
									<li>
										<a title="Celular">
											<span class="material-symbols-outlined mr-3 left">smartphone</span>
											<span> {{ $paciente->celular  ?? 'Não informado' }} </span>
										</a>
									</li>
									<li>
										<a title="E-mail">
											<span class="material-symbols-outlined mr-3 left">email</span>
											<span> {{ $paciente->email ?? 'Não informado' }} </span>
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a title="Nome da mãe">
											<span class="material-symbols-outlined mr-3 left">pregnant_woman</span>
											<span> {{ $paciente->mae ?? 'Não informado' }} </span>
										</a>
									</li>
									<li>
										<a title="Nome do pai">
											<span class="material-symbols-outlined mr-3 left">man</span>
											<span> {{ $paciente->pai ?? 'Não informado' }} </span>
										</a>
									</li>
								</ul>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="col s9 scroller">

			<div class="row">

				<div class="col s12 pr-4">

					<div class="container pt-2">

						<!-- timeline -->
						<ul class="timeline">

							@for($i = 2022 ; $i <= 2122; $i++)
								<li>
									<div class="timeline-badge blue tooltipped" data-position="bottom" data-tooltip="Atendimento">
										<h5 class="white-text">22</h5>
										<h6 class="white-text">SET</h6>
										<div class="divider"></div>
										<span class="white-text">{{ $i }}</span>
									</div>
									<div class="timeline-panel">
										<div class="card m-0 hoverable flow-text" id="profile-card">
											<div class="card-content">

												<h5 class="card-title activator grey-text text-darken-4 mt-1">
													Roger Waters
												</h5>

												<ul class="collapsible">

													<li>

														<div class="collapsible-header">

															<div class="row">

																<div class="col s12">

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

																</div>

															</div>

														</div>

														<div class="collapsible-body">

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

														</div>

													</li>


												</ul>

												<div class="row">
													<div class="col s12">
														<button class="btn col transparent z-depth-0 right" data-trigger="toggle">
															<span class="icon"></span>
														</button>
													</div>
												</div>

											</div>

										</div>

									</div>

								</li>
							@endfor

							<li class="clearfix"></li>

						</ul>
						<!-- / timeline -->

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

@endsection
