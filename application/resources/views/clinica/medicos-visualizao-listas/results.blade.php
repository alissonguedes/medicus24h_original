@php
	use App\Models\PermissaoModel;
@endphp

@if($medicos->total() > 0)

	@if(request()->get('query'))
		<div class="row">
			<div class="col s12">
				<h6>{{ $medicos->total() }} @if ($medicos->total()>1) resultados encontrados @else resultado encontrado. @endif </h6>
			</div>
		</div>
	@endif

	<div class="row">

		@foreach($medicos as $medico)
			<div class="col s12 m6 l3 grid-view">
				<div class="pacientes card card-border border-radius-6 z-depth-3 gradient-45deg-indigo-light-blue">
					<div class="card-content white-text">
						<div class="foto-pacientes">
							<div class="foto circle z-depth-4 left">
								<img class="img-responsive" src="{{ asset($medico->imagem ?? (is_null($medico->sexo) ? 'img/avatar/icon.png' : ($medico->sexo == 'M' ? 'img/avatar/homem.png' : 'img/avatar/mulher.png') ) ) }}" alt="">
							</div>
							<h6 class="white-text">{{ $medico->nome }}</h6>
							<p>
								<a href="#"><i class="material-icons">cake</i>{{ $medico->data_nascimento ?? 'Não informado' }}</a>
								<a href="#"><i class="material-icons">credit_card</i>{{ $medico->cpf ?? 'Não informado' }}</a>
							</p>
							<div class="clear"></div>
						</div>
						<div class="contato">
							<p class="mt-4">
								<a href="#"><i class="material-icons left">phone</i> {{ $medico->telefone ?? 'Não informado' }}</a>
								<a href="#"><i class="material-icons left">message</i> {{ $medico->whatsapp ?? 'Não informado' }}</a>
								<a href="#"><i class="material-icons left">mail</i> {{ $medico->email ?? 'Não informado' }}</a>
							</p>
						</div>
						{{-- <p class="center-align">
							<a href="{{ go('clinica.medicos.edit', $medico->id) }}" class="waves-effect waves-light btn gradient-45deg-deep-orange-orange border-round mt-7 z-depth-4">Alterar</a>
						</p> --}}
						<div class="acoes flex flex-center mt-5">
							<a class="waves-effect gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto" data-tooltip="Prontuário">
								<i class="material-icons">content_paste</i>
							</a>
							<a href="#" class="waves-effect gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto" data-tooltip="Agendar">
								<i class="material-icons">event</i>
							</a>
							<a href="{{ go('clinica.medicos.edit', $medico->id) }}" class="waves-effect gradient-45deg-deep-orange-orange center-align icon-background circle white-text z-depth-3 mx-auto" data-tooltip="Editar">
								<i class="material-icons">edit</i>
							</a>
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
