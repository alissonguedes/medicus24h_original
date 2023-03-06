@if(session()->has('userdata'))

	{? $menu_type = (get_config('main-menu-type') ? 'nav-' . get_config('main-menu-type') : null) ?}
	{? $nav_lock = (get_config('main-menu-type') == 'expanded') ? 'nav-lock': null ?}

	<aside class="{{ $menu_type }} {{ $nav_lock }} sidenav-main nav-collapsible sidenav-light sidenav-active-rounded scrollbar">

		<a href="#" data-target="slide-out" class="sidenav-trigger btn-sidenav-toggle btn-floating blue lighten-1 btn-medium waves-effect waves-light hide-on-large-only">
			<i class="material-icons">menu</i>
		</a>

		<div class="brand-sidebar">

			<a class="navbar-toggler btn-floating btn-flat transparent grey-text text-darken-1 waves-effect">
				<i class="material-icons">menu</i>
			</a>

			<h1 class="logo-wrapper">

				<div class="text-logo">
					<h5>Clinic</h5>
					<h2>Cloud</h2>
				</div>

			</h1>

		</div>

		@php
			echo getMenus('main-menu', null, [
			'id' => 'slide-out',
			'class' => 'sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow scroller',
			]);
		@endphp

	</aside>

@endif
