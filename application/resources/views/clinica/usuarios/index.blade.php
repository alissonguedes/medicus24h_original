@extends('clinica.layouts.index')

@section('title', 'Usuários')

@section('search-label', 'Pesquisar Usuários')
@section('data-search', 'usuarios')
@section('json-datatable', 'true')

@section('btn-add-title','Adicionar Usuário')
@section('btn-add-icon', 'person_add_alt')
@section('btn-add-route', go('clinica.usuarios.add'))

@section('container')

<div class="row">
	<div class="col s12">
		<div class="card">
			<div class="card-content">
				<div class="card-body">
					<div class="table grid bordered">
						<div class="grid-head">
							<div class="grid grid-row">
								<div class="grid-col" data-disabled="true" data-orderable="false">
									<label class="grey-text text-darken-2 font-14 left">
										<input type="checkbox" name="check-all" id="check-all" class="filled-in">
										<span></span>
									</label>
								</div>
								<div class="grid-col" data-order="asc">
									<span class="direction">Name</span>
								</div>
								<div class="grid-col">
									<span class="direction">Grupo</span>
								</div>
								<div class="grid-col">
									<span class="direction">Email</span>
								</div>
								<div class="grid-col">
									<span class="direction">Ultimo Login</span>
								</div>
								<div class="grid-col center-align">
									<span class="direction">Status</span>
								</div>
								<div class="grid-col center-align" data-disabled="true" data-orderable="false">
									<span>Ação</span>
								</div>
							</div>
						</div>
						<div class="grid grid-body">
							<div class="scroller" style="height: calc(100vh - 290px)">
								@include('clinica.usuarios.list')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
