@extends('clinica.layouts.index')

@section('title', 'Atendimentos')

@section('search')
<div class="input-field search bordered border-round z-depth-1">
	<label for="">Pesquisar atendimentos</label>
	<input type="search" id="search-on-page" class="dataTable_search">
</div>
@endsection

@section('btn-add-title','Agendar paciente')
@section('btn-add')
<a href="#" data-target="agendamento" data-link="{{ go('clinica.agendamentos.add') }}" class="form-sidenav-trigger btn btn-floating gradient-45deg-deep-orange-orange waves-effect waves-light z-depth-3" data-tooltip="Agendar" data-position="left">
	<i class="material-icons bolder">add</i>
</a>
@endsection

@section('container')

<div class="container">

	<div class="row">
		<div class="col s12">
			<h5 class="title clock" data-format="LLLL">{{ convert_to_date('d/m/Y H:i:s', 'l, d {de} F {de} Y, H:i:s', false) }}</h5>
		</div>
	</div>

	<style>
		.card-content:after {
			content: '';
			position: absolute;
			height: 30px;
			width: 100%;
			background: #fff;
			bottom: 0;
			left: 0;
		}
	</style>

	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					{{-- <div class="card-title">

					</div> --}}
					<div class="card-body scroller fixed-height" style="overflow: auto; height: calc(100vh - 300px)">
						<table class="table dataTable">
							<thead>
								<tr>
									<th>Horário</th>
									<th>Paciente</th>
									<th>Médico</th>
									<th>Tipo</th>
									<th>Convênio</th>
									<th>Situação</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('left-sidebar')
@include('clinica.agendamentos.form')
@endsection

@section('right-sidebar')
@include('clinica.atendimentos.datelhes_atendimento')
{{-- @include('clinica.atendimentos.form') --}}
@endsection
