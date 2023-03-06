@section('site-title', 'Médicus24h - Soluções em Saúde')

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>@yield('site-title')</title>

	@section('styles')
	@include('styles')
	@show

</head>

<body>

	<div class="progress">
		<div class="indeterminate blue accent-1"></div>
	</div>

	<div id="loading"></div>

	<div id="page">

		@yield('body')

		<script>
			var BASE_URL = "{{ base_url() }}";
			var BASE_PATH = "{{ asset('/') }}";
			var SITE_URL = "{{ site_url() }}";
		</script>

		<meta name="csrf-token" content="{{ csrf_token() }}">

	</div>

	<div class="row" style="position: fixed; z-index: 999999; top: 0;">
		<div class="col s4">
			<div id="alerts" class="modal modal-fixed-footer">
				<div class="modal-content">
					<h5 class="title"></h5>
					<br>
					<p class="info"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn blue lighten-1 modal-close">Ok</button>
				</div>
			</div>
		</div>
	</div>

	@section('scripts')
	@include('scripts')
	@show

</body>

</html>
