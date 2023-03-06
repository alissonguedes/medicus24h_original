{? $records = [] ?}

@php
	use App\Models\PermissaoModel;
@endphp

@if($paginate->total() > 0)

	@php
		$permissao = new PermissaoModel();
		$permissao = $permissao->getPermissao('clinica.pacientes.edit');
		$disabled = !$permissao ? true : false;
	@endphp

	@foreach($paginate as $ind => $row)
		<tr class="{{ $row->status === '0' ? 'blocked' : null }}" style="position: relative;" id="{{ $row->id }}" data-disabled="{{ $disabled ? 'true' : 'false' }}">
			<td width="1%" data-disabled="true">
				<label>
					<input type="checkbox" name="id[]" class="filled-in" value="{{ $row->id }}" data-status="{{ $row->status }}">
					<span></span>
				</label>
			</td>
			<td width="25%">
				{{ $row->nome }}
			</td>
			<td width="15%">
				{{ $row->telefone ?? $row->celular }}
			</td>
			<td width="15%">
				{{ $row->codigo }}
			</td>
			<td>
				{{ $row->data_nascimento }}
			</td>
			<td width="1px">
				{{ $row->convenio }}
			</td>
			<td>
				{{ $row->status === '0' ? 'Inativo' : 'Ativo' }}
			</td>
			<td data-disabled="true" width="15%" class="center-align">
				@if(!$disabled)
					<button data-href="{{ go('clinica.pacientes.edit', $row->id) }}" class="btn-small btn-flat btn-edit btn-floating float-none waves-effect" data-tooltip="Editar">
						<i class="material-icons grey-text">edit</i>
					</button>
				@endif
				@if(!$disabled)
					{? $status = ($row->status === '0' ? '1' : '0'); ?}
					<button class="btn-small btn-flat btn-edit btn-floating waves-effect" name="status" value="{{ $status }}" data-tooltip="{{ $status === '0' ? 'Bloquear' : 'Desbloquear' }}" data-link="{{ go('clinica.pacientes.patch', 'status', $row->id) }}" data-method="patch">
						<i class="material-icons grey-text">{{ $row->status === '1' ? 'lock' : 'lock_open' }}</i>
					</button>
				@endif
				@if(!$disabled)
					<button class="btn-small btn-flat btn-floating excluir waves-effect" data-link="{{ go('clinica.pacientes.delete', $row->id) }}" data-method="delete" data-tooltip="Excluir">
						<i class="material-icons grey-text">delete</i>
					</button>
				@endif
			</td>
		</tr>
	@endforeach

	<div id="pagination">

		<ul>

			<li>
				<button class="btn btn-flat btn-floating waves-effect" data-tooltip="Anterior" data-href="{{ !$paginate->onFirstPage() ? $paginate->previousPageUrl() : '#' }}" {{ $paginate->onFirstPage() ? 'disabled' : null }}>
					<i class="material-icons">keyboard_arrow_left</i>
				</button>
			</li>

			<li>
				<button class="btn btn-flat btn-floating waves-effect" data-tooltip="Próxima" data-href="{{ $paginate->currentPage() < $paginate->lastPage() ? $paginate->nextPageUrl() : '#' }}" {{ $paginate->currentPage() === $paginate->lastPage() ? 'disabled' : null }}>
					<i class="material-icons">keyboard_arrow_right</i>
				</button>
			</li>

		</ul>

	</div>

	<div id="info">
		<button data-href="#" class="btn btn-flat waves-effect">
			{{ $paginate->firstItem() }} - {{ $paginate->lastItem() }} de {{ $paginate->total() }}
			{{-- {{ $paginate -> perPage() }} --}}
		</button>
	</div>

@else

	<div class="no-results white-text center-align">
		Nenhum registro encontrado.
	</div>

	<div id="pagination"></div>

	<div id="info"></div>

@endif
