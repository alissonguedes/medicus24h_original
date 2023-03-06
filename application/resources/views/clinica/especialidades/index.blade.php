@extends('clinica.layouts.index')

@section('title', 'Especialidades')

@section('search')
<div class="input-field search bordered border-round z-depth-1">
	<label for="">Pesquisar especialidades</label>
	<input type="search" id="search-on-page" class="dataTable_search">
</div>
@endsection

@section('btn-add-title','Adicionar especialidade')
@section('btn-add')
<button class="modal-trigger btn btn-floating gradient-45deg-deep-orange-orange waves-effect waves-light z-depth-3" data-url="{{ go('clinica.especialidades.add') }}" data-trigger="modal" data-target="modal_especialidade" data-tooltip="@yield('btn-add-title')" data-position="left" data-href="@yield('btn-add-route')">
	<i class="material-icons bolder">add</i>
</button>
@endsection

@section('container')
<div class="row">
	<div class="col s12">
		<div class="card">
			<div class="card-content scroller">
				<div class="card-body responsive-table">
					<table class="table dataTable no-footer dataTable-fixed" data-link="{{ go('clinica.especialidades.index') }}">
						<thead>
							<tr>
								<th data-orderable="false">
									<label class="grey-text text-darken-2 font-14 left">
										<input type="checkbox" name="check-all" id="check-all" class="filled-in">
										<span></span>
									</label>
								</th>
								<th class="center-align">Especialidade</th>
								<th class="center-align">Descrição</th>
								<th class="center-align">Data de cadastro</th>
								<th class="center-align">Data de atualiação</th>
								<th class="center-align" class="center-align" data-orderable="false">Ações</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@include('clinica.especialidades.form')

@endsection
