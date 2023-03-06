@php
	use App\Models\PermissaoModel;
@endphp

<input type="hidden" id="total_results" value="{{ $pacientes->total() }}">

@if($pacientes->total() > 0)

	@if(request()->get('query'))
		<div class="row">
			<div class="col s12">
				<h6>{{ $pacientes->total() }} @if ($pacientes->total()>1) resultados encontrados @else resultado encontrado. @endif </h6>
			</div>
		</div>
	@endif

	<div class="row">

		@foreach($pacientes as $i => $paciente)

			<div class="col s12 m6 l3 grid-view animated fadeIn slow delay-{{ $i }}">
				<div class="pacientes card card-border border-radius-6 z-depth-3 gradient-45deg-indigo-light-blue" @if ($paciente->obito === '1') style="filter: grayscale(1)" @endif>
					<div class="card-content white-text">
						<div class="foto-paciente">
							<div class="foto circle z-depth-4 left">
								@php
									$style = null;
									if ($paciente->status === '0'):
									$style = 'opacity: 0.3; filter: grayscale(1)';
									endif;
								@endphp
								<img class="img-responsive" src="{{ asset($paciente->imagem ?? (is_null($paciente->sexo) ? 'img/avatar/icon.png' : ($paciente->sexo == 'M' ? 'img/avatar/homem.png' : 'img/avatar/mulher.png') ) ) }}" alt="" style="{{ $style }}">
								@if($paciente->status === '0')
									<i class="material-icons" style="position: absolute; left: 18px; top: 18px;">lock</i>
								@endif
							</div>
							<h6 class="white-text">{{ $paciente->nome }}</h6>
							<p>
								<a href="#"><i class="material-icons-outlined left">cake</i>{{ $paciente->data_nascimento ?? 'Não informado' }}</a>
								<a href="#"><i class="material-icons-outlined left">credit_card</i>{{ $paciente->cpf ?? 'Não informado' }}</a>
							</p>
							<div class="clear"></div>
						</div>
						<div class="contato">
							<p class="mt-4">
								<a href="#"><i class="material-icons-outlined left">phone</i> {{ $paciente->telefone ?? 'Não informado' }}</a>
								<a href="#"><i class="material-icons-outlined left">message</i> {{ $paciente->whatsapp ?? 'Não informado' }}</a>
								<a href="#"><i class="material-icons-outlined left">mail</i> {{ $paciente->email ?? 'Não informado' }}</a>
							</p>
						</div>
						{{-- <p class="center-align">
							<a href="{{ go('clinica.pacientes.edit', $paciente->id) }}" class="waves-effect waves-light btn gradient-45deg-deep-orange-orange border-round mt-7 z-depth-4">Alterar</a>
						</p> --}}
						{? $link = ($paciente->status === '1' && $paciente->obito === '0') ? 'data-link='. go('clinica.pacientes.{id_paciente}.agendamento',$paciente->id) : null; ?}
						{? $targ = ($paciente->status === '1' && $paciente->obito === '0') ? 'data-target=agendamento' : null; ?}
						{? $classe = ($paciente->status === '1' && $paciente->obito === '0') ? 'form-sidenav-trigger waves-effect' : null; ?}
						{? $disabled = ($paciente->status === '0' || $paciente->obito === '1') ? 'disabled' : null; ?}
						<div class="acoes flex flex-center mt-5">
							<button data-href="{{ go('clinica.pacientes.{id_paciente}.prontuarios', $paciente->id) }}" name="id" id="{{ $paciente->id }}" data-target="prontuario" class="waves-effect gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto border-0 " data-tooltip="Prontuário">
								<i class="material-icons-outlined">assignment_ind</i>
							</button>
							<button name="id" {{ $link }} {{ $targ }} id="{{ $paciente->id }}" class="gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto border-0 {{ $classe }}" {{ $disabled }} data-tooltip="Agendar">
								<i class="material-icons-outlined">event</i>
							</button>
							<button data-href="{{ go('clinica.pacientes.edit', $paciente->id) }}" class="waves-effect gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto border-0 " data-tooltip="Editar">
								<i class="material-icons-outlined">edit</i>
							</button>
						</div>
					</div>
				</div>
			</div>
		@endforeach

	</div>

@else

	<div class="row">
		<div class="col s12">
			<h6>Nenhum resultado encontrado.</h6>
		</div>
	</div>

@endif
