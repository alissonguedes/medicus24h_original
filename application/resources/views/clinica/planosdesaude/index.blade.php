@extends('clinica.layouts.index')

@section('title', 'Pacientes')

@section('search-label', 'Pesquisar pacientes')
@section('data-search', 'pacientes')

@section('btn-add-title','Adicionar paciente')
@section('btn-add-icon', 'person_add_alt_1')
@section('btn-add-route', go('clinica.pacientes.add'))

@section('total-results')
{{ $pacientes->total() }} registro{{ (($pacientes->total()>1) ? 's' : null) }}
<ul id="dropdown-registros" class="dropdown-content">
	<li><a data-url="{{ go('clinica.pacientes.index') }}" class="active">Todos</a></li>
	{{-- <li class="divider" tabindex="-1"></li> --}}
	<li><a data-url="{{ go('clinica.pacientes.index') }}?status=1&obito=0">Ativos</a></li>
	<li><a data-url="{{ go('clinica.pacientes.index') }}?status=0&obito=0">Inativos</a></li>
	{{-- <li class="divider" tabindex="-1"></li> --}}
	<li><a data-url="{{ go('clinica.pacientes.index') }}?obito=0">Vivos</a></li>
	<li><a data-url="{{ go('clinica.pacientes.index') }}?status=0&obito=1">Falecidos</a></li>
</ul>
@endsection

@section('container')
@include('clinica.pacientes.results')
@endsection

@section('left-sidebar')
@include('clinica.agendamentos.form')
@endsection
