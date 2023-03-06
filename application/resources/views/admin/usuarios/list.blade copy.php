{? $records = [] ?}
{? $records = [] ?}

@php
	use App\Models\PermissaoModel;
@endphp

@if($paginate->total() > 0)

	@php
		$permissao = new PermissaoModel();
		$permissao = $permissao->getPermissao('clinica.clinicas.edit');
		$disabled = !$permissao ? true : false;
	@endphp

	@foreach($paginate as $row)

		{{-- <tr class="{{ $row->status === '0' ? 'blocked' : null }}" id="{{ $row->id }}" data-disabled="false" data-href="{{ go('clinica.usuarios.edit', $row->id) }}">
		<td width="1%" data-disabled="true">
			<label>
				<input type="checkbox" name="id[]" class="filled-in" value="{{ $row->id }}" data-status="{{ $row->status }}">
				<span></span>
			</label>
		</td>
		<td>{{ $row->nome }}</td>
		<td>{{ $row->grupo }}</td>
		<td>{{ $row->email }}</td>
		<td>{{ $row->ultimo_login }}</td>
		<td class="center-align">
			{{ $row->status === '0' ? 'Inativo' : 'Ativo' }}
		</td>
		<td data-disabled="true" width="18%" class="center-align border-rl">
			@if(!$disabled)
				<button type="button" class="btn-small grey lighten-4 btn-floating float-none waves-effect" name="edit" value="{{ $row->id }}" data-href="{{ route('clinica.usuarios.edit', $row->id) }}" data-tooltip="Editar">
					<i class="material-icons-outlined grey-text">edit</i>
				</button>
			@endif
			@if(!$disabled)
				{? $status = ($row->status === '0' ? '1' : '0'); ?}
				<button type="button" class="btn-small ml-3 mr-3 teal lighten-3 btn-edit btn-floating waves-effect" name="status" value="{{ $status }}" data-url="{{ go('clinica.clinicas.patch', 'status', $row->id) }}" data-tooltip="{{ $status === '0' ? 'Bloquear' : 'Desbloquear' }}" data-method="patch">
					<i class="material-icons white-text">{{ $row->status === '1' ? 'lock' : 'lock_open' }}</i>
				</button>
			@endif
			@if(!$disabled)
				<button type="button" class="btn-small red lighten-3 btn-floating excluir waves-effect" value="{{ $row->id }}" data-url="{{ go('clinica.clinicas.delete', $row->id) }}" data-tooltip="Excluir" data-method="delete">
					<i class="material-icons-outlined white-text">delete</i>
				</button>
			@endif
		</td>
		</tr> --}}

		<div class="grid">
			<div class="grid-col" data-disabled="true" data-orderable="false">
				<label class="grey-text text-darken-2 font-14 left">
					<input type="checkbox" name="check-all" id="check-all" class="filled-in">
					<span></span>
				</label>
			</div>
			<div class="grid-col">
				<span>{{ random(['Alisson Guedes Pereira', 'Debora Chianca de Albuquerque Pires','Chrislaine Barboza Leite', 'Aline', 'André Andrade', 'Amanda Kelle de Albuquerque Mello']) }}</span>
			</div>
			@php
				$array = ['super administrador', 'administrador', 'médico', 'recepcionista'];
			@endphp
			<div class="grid-col left-align">{{ random($array) }}</div>
			<div class="grid-col left-align">{{ random(['alissonguedes@emial.com', 'não informado']) }}</div>
			<div class="grid-col">Ultimo Login</div>
			<div class="grid-col center-align">Status</div>
			<div class="grid-col disabled center-align" data-orderable="false">Ação</div>
		</div>

	@endforeach

	<div id="pagination">

		<ul>

			<li>
				<button class="btn btn-flat btn-floating waves-effect" data-href="{{ !$paginate->onFirstPage() ? $paginate->previousPageUrl() : '#' }}" data-tooltip="Anterior" {{ $paginate->onFirstPage() ? 'disabled' : null }}>
					<i class="material-icons">keyboard_arrow_left</i>
				</button>
			</li>

			{{-- @for ($i = 1; $i <= $paginate->lastPage(); $i++)
			{? $class = ($i === $paginate -> currentPage() ) ? 'active' : null ?}
				<li>
					<button data-href="{{ $paginate->currentPage() !== $i ? $paginate->url($i) : '#' }}"
			class="btn btn-small btn-floating waves-effect {{ $class }}">{{ $i }}</button>
			</li>
@endfor--}}

<li>
	<button class="btn btn-flat btn-floating waves-effect" data-href="{{ $paginate->currentPage() < $paginate->lastPage() ? $paginate->nextPageUrl() : '#' }}" data-tooltip="Próxima" {{ $paginate->currentPage() === $paginate->lastPage() ? 'disabled' : null }}>
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

@if ($paginate->total() > 0)

    @foreach ($paginate as $row)

        <tr class="{{ $row->status === '0' ? 'blocked' : null }}" id="{{ $row->id }}" data-disabled="false" data-href="{{ route('clinica.usuarios.edit', $row->id) }}" >

            <td width="1%" data-disabled="true">
                <label>
                    <input type="checkbox" name="id[]" class="light-blue" value="{{ $row->id }}" data-status="{{ $row->status }}">
                    <span></span>
                </label>
            </td>
            <td>{{ $row->nome }}</td>
            <td>{{ $row->grupo }}</td>
            <td>{{ $row->email }}</td>
            <td>{{ $row->ultimo_login }}</td>
            <td class="center-align"><i class="material-icons">{{ $row->status === '0' ? 'lock' : 'check' }}</i>
            </td>
            <td class="center-align" data-disabled="true">
                <button data-href="{{ route('clinica.usuarios.edit', $row->id) }}" class="btn btn-flat btn-edit btn-floating float-none">
                </button>
            </td>
        </tr>

    @endforeach

    <div id="pagination">

        <ul>

            <li>
                <button class="btn btn-flat btn-floating waves-effect" data-href="{{ !$paginate->onFirstPage() ? $paginate->previousPageUrl() : '#' }}" data-tooltip="Anterior" {{ $paginate->onFirstPage() ? 'disabled' : null }}>
                    <i class="material-icons">keyboard_arrow_left</i>
                </button>
            </li>

            {{-- @for ($i = 1; $i <= $paginate->lastPage(); $i++)
			{? $class = ($i === $paginate -> currentPage() ) ? 'active' : null ?}
				<li>
					<button data-href="{{ $paginate->currentPage() !== $i ? $paginate->url($i) : '#' }}"
						class="btn btn-small btn-floating waves-effect {{ $class }}">{{ $i }}</button>
				</li>
			@endfor --}}

            <li>
                <button class="btn btn-flat btn-floating waves-effect" data-href="{{ $paginate->currentPage() < $paginate->lastPage() ? $paginate->nextPageUrl() : '#' }}" data-tooltip="Próxima" {{ $paginate->currentPage() === $paginate->lastPage() ? 'disabled' : null }}>
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
