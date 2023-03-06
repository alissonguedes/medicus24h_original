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

						<div class="card-body scroller" style="height: calc(100vh - 330px);overflow: scroll;">

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

						<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

						<!-- timeline -->
						<ul class="timeline">
							<li>
								<div class="timeline-badge blue tooltipped" data-position="bottom" data-tooltip="Atendimento">
									<h5 class="white-text">22</h5>
									<h6 class="white-text">SET</h6>
									<div class="divider"></div>
									<span class="white-text">2022</span>
								</div>
								<div class="timeline-panel">
									<div class="card m-0 hoverable flow-text" id="profile-card">
										<div class="card-content">
											<h5 class="card-title activator grey-text text-darken-4 mt-1">
												Roger Waters
											</h5>

											<div class="row mb-6">
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">local_hospital</span>
														<span class="bold">Clínica:</span>
														<span>Unidade Manaíra</span>
													</p>
												</div>
												<div class="col s12">
													<p>
														<span class="material-symbols-outlined profile-card-i">stethoscope</span>
														<span class="bold">Médico:</span>
														<span>Unidade Manaíra</span>
													</p>
												</div>
											</div>

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
														<span class="bold">Queixa principal:</span>
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

									</div>

								</div>
							</li>

							<li class="clearfix"></li>

						</ul>
						<!-- / timeline -->

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<style>
	.prontuario .title {
		line-height: 28px;
		margin: 0;
	}

	.prontuario .idade {
		line-height: 0.789rem;
		font-size: 0.789rem;
	}

	.prontuario .estatisticas {
		font-size: .789rem;
	}

	ul.dados-pessoais {
		display: inline-block;
		list-style-type: none;
		margin: 0;
		padding: 0;
		width: 100%;
	}

	ul.dados-pessoais li.divider {
		margin: 8% 0;
	}

	ul.dados-pessoais li:not(.divider) {
		margin: 0 0 3px;
		height: 23px;
		line-height: 23px;
		font-size: 0.789rem;
		display: flex;
		align-items: center;
	}

	ul.dados-pessoais li a {
		cursor: pointer;
		color: inherit;
		display: block;
		width: inherit;
		text-overflow: ellipsis;
		white-space: nowrap;
		height: inherit;
		line-height: inherit;
		position: relative;
		overflow: hidden;
		min-width: 99%;
		max-width: 99%;
	}

	ul.dados-pessoais li a span {
		height: inherit;
		line-height: inherit;
		display: inline;
	}

	ul.dados-pessoais li a span.material-icons,
	ul.dados-pessoais li a span.material-symbols,
	ul.dados-pessoais li a span.material-icons-outlined,
	ul.dados-pessoais li a span.material-symbols-outlined {
		font-size: 16px;
	}

	.timeline>li .timeline-panel::after,
	.timeline>li .timeline-panel::before {
		display: inline-block;
		content: ' ';
		position: absolute
	}

	.timeline {
		position: relative
	}

	.timeline .descricao-medica p {
		margin-top: 8px !important;
	}

	.timeline:before {
		position: absolute;
		z-index: -1;
		top: 35px;
		left: 44px;
		width: 3px;
		height: 100%;
		content: ' ';
		background-color: #eee;
	}

	.timeline>li {
		position: relative;
		float: left;
		clear: left;
		width: 50%;
		margin-bottom: 35px;
	}

	.timeline>li .timeline-panel {
		position: relative;
		width: calc(100% - 43px);
		left: 15px;
	}

	.timeline>li .timeline-panel::before {
		top: 26px;
		left: -15px;
		border-top: 15px solid transparent;
		border-right: 0 solid #ccc;
		border-bottom: 15px solid transparent;
		border-left: 15px solid #ccc
	}

	.timeline>li .timeline-panel::after {
		top: 27px;
		left: -14px;
		border-top: 14px solid transparent;
		border-right: 0 solid #fff;
		border-bottom: 14px solid transparent;
		border-left: 14px solid #fff
	}

	.timeline>li .timeline-badge {
		position: absolute;
		z-index: 8;
		top: 27px;
		left: 10px;
		width: 70px;
		height: 90px;
		text-align: center;
		border-radius: 5%;
	}

	.timeline>li .timeline-badge {
		top: 22px;
		left: 10px;
		margin-left: 0;
	}

	.timeline>li .timeline-badge a i {
		font-size: 1.4rem;
		line-height: 35px
	}

	.timeline .timeline-badge h5 {
		margin: 10px 0 0;
	}

	.timeline .timeline-badge h6 {
		margin-top: 0;
	}

	.timeline .timeline-badge span {
		margin: 0;
		font-size: 18px;
	}

	.timeline>li.timeline-inverted {
		float: right;
		clear: right;
		margin-top: 60px;
		margin-bottom: 50px
	}

	.timeline>li.timeline-inverted .timeline-panel {
		float: right
	}

	.timeline>li.timeline-inverted .timeline-panel::before {
		right: auto;
		left: -15px;
		border-right-width: 15px;
		border-left-width: 0
	}

	.timeline>li.timeline-inverted .timeline-panel::after {
		right: auto;
		left: -14px;
		border-right-width: 14px;
		border-left-width: 0
	}

	.timeline>li.timeline-inverted .timeline-badge {
		left: -15px
	}

	.timeline>li .card .card-header {
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-align: center;
		-webkit-align-items: center;
		-ms-flex-align: center;
		align-items: center
	}

	.timeline>li .card .card-text .flow-text {
		font-size: 1.4rem
	}

	.timeline>li .card .horizontal-avatar li {
		display: inline-block;
		margin-right: .9rem
	}

	.timeline>li {
		position: relative;
		float: left;
		clear: left;
		width: 100%;
		margin-bottom: 20px
	}

	.timeline>li .timeline-panel {
		float: right;
		width: calc(100% - 90px)
	}

	.timeline>li .timeline-panel::before {
		right: auto;
		left: -15px;
		border-right-width: 15px;
		border-left-width: 0
	}

	.timeline>li .timeline-panel::after {
		right: auto;
		left: -14px;
		border-right-width: 14px;
		border-left-width: 0
	}

	.timeline>li.timeline-inverted {
		float: left;
		clear: left;
		margin-top: 30px;
		margin-bottom: 30px
	}

	.timeline>li.timeline-inverted .timeline-badge {
		left: 28px
	}
	}
</style>

@endsection
