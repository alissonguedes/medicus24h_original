@extends('app')

@section('styles')
@include('admin.styles')
@endsection

@section('body')

	@include('admin.sidebar')

	<div id="main">
		@yield('main')
	</div>

@endsection
