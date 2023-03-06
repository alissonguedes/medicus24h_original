@extends('app')

@section('page-title', 'Sobre nós')

@section('capa')
<div class="nav-background">
	<div class="capa animated fadeIn teal lighten-2"></div>
	<div class="nav-header">
		<h1>@yield('page-title')</h1>
	</div>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col s12">
		<div class="container mt-8 pt-6 pb-6">
			<p>
				A <a href="#" class="bold red-text darken-2">Médicus24h</a> possui uma frota completa
				de ambulâncias próprias equipeadas com UTI Móvel com assitência 24 horas.
			</p>
		</div>
	</div>
</div>

@endsection
