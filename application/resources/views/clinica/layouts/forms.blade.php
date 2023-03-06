@extends('clinica.body')

@section('back-button', '')

@section('main')

@section('topbar')
<div class="topbar flex flex-center" style="height: 60px;">
	<div class="topbar-fixed topbar-color flex flex-auto z-depth-1">
		@yield('topbar-options')
	</div>
</div>
@show

<style>
	.alert {
		margin-top: 5px;
		padding: 15px;
		border-radius: 5px;
		text-align: center;
	}

	.alert.success {
		color: var(--green-darken-2);
		background-color: var(--green-lighten-1);
		border: 1px solid var(--green-lighten-3);
	}

	.topbar ul li {
		display: block;
		margin-right: 10px;
	}

	.topbar ul li .btn {
		color: #000;
	}
</style>

<div class="container pt-1 scroller" style="height: 100vh ; width: 100%;">

	@if(session('message'))
		<div class="row">
			<div class="col s12">
				<div class="alert {{ session('status') ?? 'success' }}">
					{{ session('message') }}
				</div>
			</div>
		</div>
	@endif

	<div id="results">
		@yield('container')
	</div>

</div>

@yield('left-sidebar')
@yield('right-sidebar')

@endsection
