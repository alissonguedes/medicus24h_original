{? $records = [] ?}

@if ($paginate->total() > 0)

    @foreach ($paginate as $row)

        <tr class="{{ $row->status === '0' ? 'blocked' : null }}" id="{{ $row->id }}" data-disabled="false">

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
                <button data-href="{{ route('admin.usuarios.edit', $row->id) }}" class="btn btn-flat btn-edit btn-floating float-none">
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
