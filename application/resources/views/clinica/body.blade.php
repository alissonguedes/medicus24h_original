@extends('app')

@section('main-menu-type', get_config('main-menu-type') == 'collapsed' ? 'main-full' : null )

@section('search', '')

@section('styles')
@include('clinica.styles')
@endsection

@section('body')

<div class="horizontal-layout @yield('main-menu-type')">

	@include('clinica.header')
	@include('clinica.sidebar')

	<div id="main" class="@yield('main-menu-type')">

		@yield('main')

	</div>

</div>

@endsection
