@extends('clinica.layouts.index')

@section('title', 'Agendamentos')

@section('search')
<div class="input-field search bordered border-round z-depth-1">
	<label for="">Pesquisar agendamentos</label>
	<input type="search" id="search-on-page" class="dataTable_search">
</div>
@endsection

@section('btn-add-title','Agendar paciente')
@section('btn-add')
<a href="#" data-target="agendamento" data-link="{{ go('clinica.agendamentos.add') }}" class="form-sidenav-trigger btn btn-floating gradient-45deg-deep-orange-orange waves-effect waves-light z-depth-3" data-tooltip="Agendar">
	<i class="material-icons bolder">add</i>
</a>
@endsection

@section('main')

<div class="container pt-1 scroller" style="overflow: auto; height: calc(100vh - 65px)">
	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					<div class="card-title">
						<a href="#" data-target="agendamento" data-link="{{ go('clinica.agendamentos.add') }}" class="form-sidenav-trigger btn btn-floating gradient-45deg-deep-orange-orange waves-effect waves-light z-depth-3 hide" data-tooltip="Agendar">
							<i class="material-icons bolder">add</i>
						</a>
						<button class="btn btn-small white modal-trigger waves-effect" data-target="modal-filter" style="padding: 10px 15px;line-height: 1;height: auto;">
							<i class="material-icons-outlined black-text">filter_alt</i>
						</button>
					</div>
					<div id="calendar" class="calendar">
						<div style="display: flex; align-items: center;">
							<div class="preloader-wrapper small active" style="margin-right: 20px;">
								<div class="spinner-layer spinner-green-only">
									<div class="circle-clipper left">
										<div class="circle"></div>
									</div>
									<div class="gap-patch">
										<div class="circle"></div>
									</div>
									<div class="circle-clipper right">
										<div class="circle"></div>
									</div>
								</div>
							</div>
							<p class="calendar-loading">
								Carregando o calendário...
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_add_event_calendar" class="modal">
	<div class="modal-content">modal_add_event_calendar</div>
	<div class="modal-footer"></div>
</div>

<div id="modal-filter" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h5>Filtros</h5>
			</div>
		</div>
		<div class="row">
			<div class="col s12">
				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<label for="filtro_categoria_atendimento" class="active">Tipo de atendimento</label>
							<select name="filtro_categoria_atendimento" id="filtro_categoria_atendimento" data-url="{{ go('clinica.atendimentos.autocomplete', 'categorias') }}" data-placeholder="Tipo de atendimento" data-value="1">
								<option value="1" selected>Consulta</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<label for="filtro_paciente" class="active">Paciente</label>
							<select name="filtro_paciente" id="filtro_paciente" data-url="{{ go('clinica.pacientes.autocomplete') }}" data-placeholder="Nome do paciente"></select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<label for="filtro_medico" class="active">Médico</label>
							<select name="filtro_medico" id="filtro_medico" data-url="{{ go('clinica.medicos.autocomplete') }}" data-placeholder="Nome do médico">
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<label for="filtro_clinica" class="active">Clínica</label>
							<select name="filtro_clinica" id="filtro_clinica" data-url="{{ go('clinica.clinicas.autocomplete') }}" data-placeholder="Nome do médico">
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="reset" class="btn white black-text lighten-1 mr-2">Redefinir</button>
		<button class="btn blue lighten-1 modal-close">Ok</button>
	</div>
</div>

@include('clinica.agendamentos.form')

@endsection
