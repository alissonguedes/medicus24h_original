@if(session()->has('userdata'))

	{? $menu_type = (get_config('main-menu-type') ? 'nav-' . get_config('main-menu-type') : null) ?}
	{? $nav_lock = (get_config('main-menu-type') == 'expanded') ? 'nav-lock': null ?}

	<aside class="{{ $menu_type }} {{ $nav_lock }} sidenav-main nav-collapsible sidenav-light sidenav-active-square scrollbar">

		<div class="brand-sidebar">

			{{-- <a class="navbar-toggler btn-floating btn-flat grey-text text-darken-1 waves-effect">
				<i class="material-icons">menu</i>
			</a> --}}

			<h1 class="logo-wrapper">

				<div class="text-logo">
					<h5>Clinic</h5>
					<h2>Cloud</h2>
				</div>
				{{-- <img src="{{ asset('assets/tacticweb/img/ltw.png') }}" class="img_cem" width="100"> --}}
			</h1>

		</div>

		@php
			echo getMenus('main-menu', null, [
			'id' => 'slide-out',
			'class' => 'sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow scrollbar scrollbar-primary',
			]);
		@endphp

		<a href="#" data-target="slide-out" class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only">
			<div class="bt_mob" id="menu_mob" data-element=".menu_dashboard">
				<img src="img/bt_mob.png" class="img_cem">
			</div>
			<i class="material-icons">menu</i>
		</a>

	</aside>
@endif
