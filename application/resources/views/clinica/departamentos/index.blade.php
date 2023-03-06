@extends('clinica.layouts.index')

@section('title', 'Departamentos')

@section('search')
<div class="input-field search bordered border-round z-depth-1">
	<label for="">Pesquisar departamentos</label>
	<input type="search" id="search-on-page" class="dataTable_search">
</div>
@endsection

@section('btn-add-title','Adicionar departamento')
@section('btn-add')
<button class="btn btn-floating gradient-45deg-deep-orange-orange waves-effect waves-light z-depth-3" data-url="{{ go('clinica.departamentos.add') }}" data-trigger="modal" data-target="modal_departamento" data-tooltip="@yield('btn-add-title')" data-position="left" data-href="@yield('btn-add-route')">
	<i class="material-icons bolder">add</i>
</button>
@endsection

@section('container')
<div class="row">
	<div class="col s12">
		<div class="card">
			<div class="card-content scroller">
				<div class="card-body responsive-table">
					<table class="table dataTable no-footer dataTable-fixed" data-link="{{ go('clinica.departamentos.index') }}">
						<thead>
							<tr>
								<th data-orderable="false">
									<label class="grey-text text-darken-2 font-14 left">
										<input type="checkbox" name="check-all" id="check-all" class="filled-in">
										<span></span>
									</label>
								</th>
								<th>Departamento</th>
								<th>Descrição</th>
								<th class="center-align">Data de cadastro</th>
								<th class="center-align">Status</th>
								<th class="center-align" class="center-align" data-orderable="false">Ações</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@include('clinica.departamentos.form')

@endsection
