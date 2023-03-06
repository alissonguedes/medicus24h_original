@extends('clinica.layouts.index')

@section('title', 'Clínicas')

@section('search')
<div class="input-field search bordered border-round z-depth-1">
	<label for="">Pesquisar clinicas</label>
	<input type="search" id="search-on-page" class="dataTable_search">
</div>
@endsection

@section('btn-add-title','Adicionar clinica')
@section('btn-add-icon', 'person_add_alt_1')
@section('btn-add-route', go('clinica.clinicas.add'))

{{-- @section('btn-add')
<button class="btn btn-floating gradient-45deg-deep-orange-orange waves-effect waves-light z-depth-3" data-href="{{ go('clinica.clinicas.add') }}" data-tooltip="@yield('btn-add-title')" data-position="left">
	<i class="material-icons bolder">add</i>
</button>
@endsection --}}

@section('container')

<div class="row">
	<div class="col s12">
		<div class="card">
			<div class="card-content scroller">
				<div class="card-body responsive-table">
					<table class="table dataTable no-footer dataTable-fixed">
						<thead>
							<tr>
								<th data-disabled="true" data-orderable="false">
									<label class="grey-text text-darken-2 font-14 left">
										<input type="checkbox" name="check-all" id="check-all" class="filled-in">
										<span></span>
									</label>
								</th>
								<th class="center-align" width="20%">Razão Social</th>
								<th class="center-align" width="20%">Descrição</th>
								<th class="center-align" width="20%">cnpj</th>
								<th class="center-align" width="15%">cidade</th>
								<th class="center-align">estado</th>
								<th class="center-align">Data de cadastro</th>
								{{-- <th class="center-align">Data de atualização</th> --}}
								<th class="center-align" data-disabled="true">status</th>
								<th class="center-align" width="15%" data-disabled="true" data-orderable="false">Ações</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
