@extends('clinica.body')

@section('title', 'Prontuários')

@section('main')

<div class="container pt-1">
	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					<div class="card-title mb-3">
						<div class="flex flex-center flex-auto">
							<button class="dropdown-trigger btn pl-1 pr-1 white black-text mr-1 z-depth-1" data-target="dropdown-actions">
								<i class="material-icons checkbox">check_box</i>
								<i class="material-icons">keyboard_arrow_down</i>
							</button>
							<span class="grey-text selecteds-label"> </span>
							<button data-href="{{ go('clinica.pacientes.add') }}" class="btn blue lighten-1 waves-effect waves-light">
								<i class="material-icons">person_add_alt_1</i>
							</button>
						</div>
					</div>
					<ul id="dropdown-actions" class="dropdown-content">
						<li>
							<a>
								<i class="material-icons">file_download</i>PDF
							</a>
						</li>
						<li>
							<a>
								<i class="material-icons">file_download</i>XLS
							</a>
						</li>
						<li class="divider" tabindex="-1"></li>
						<li class="disabled red-text">
							<button disabled>
								<i class="material-icons">delete</i>Excluir
							</button>
						</li>
					</ul>
					<div class="card-body scroller responsive-table" data-scroll-x="true">
						<table class="table dataTable no-footer dataTable-fixed" data-link="{{ go('clinica.pacientes.index') }}">
							<thead>
								<tr>
									<th data-disabled="true">
										<label class="grey-text text-darken-2 font-14 left">
											<input type="checkbox" name="check-all" id="check-all" class="filled-in">
											<span></span>
										</label>
									</th>
									<th class="table-col">Nome</th>
									<th class="table-col">Telefone</th>
									<th class="table-col">Código</th>
									<th class="table-col">Data de Nascimento</th>
									<th class="table-col">Convênio</th>
									<th class="table-col">Última Consulta</th>
									<th class="table-col" class="center-align" data-disabled="true">Ações</th>
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
