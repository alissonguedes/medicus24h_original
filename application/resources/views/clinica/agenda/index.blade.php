@extends('clinica.layouts.index')

@section('title', 'Pacientes')

@section('search-label', 'Pesquisar pacientes')
@section('data-search', 'pacientes')

@section('btn-add-title','Adicionar paciente')
@section('btn-add-route', go('clinica.pacientes.add'))

@section('container')

{{-- @include('clinica.agenda.results') --}}
@include('clinica.agenda.form')

@endsection
