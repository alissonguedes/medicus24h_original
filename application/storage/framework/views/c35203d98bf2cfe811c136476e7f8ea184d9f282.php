<?php if(session()->has('userdata')): ?>

	<?php  $menu_type = (get_config('main-menu-type') ? 'nav-' . get_config('main-menu-type') : null)  ?>
	<?php  $nav_lock = (get_config('main-menu-type') == 'expanded') ? 'nav-lock': null  ?>

	<aside class="<?php echo e($menu_type); ?> <?php echo e($nav_lock); ?> sidenav-main nav-collapsible sidenav-light sidenav-active-square scrollbar">

		<div class="brand-sidebar">

			

			<h1 class="logo-wrapper">

				<div class="text-logo">
					<h5>Clinic</h5>
					<h2>Cloud</h2>
				</div>
				
			</h1>

		</div>

		<?php
			echo getMenus('main-menu', null, [
			'id' => 'slide-out',
			'class' => 'sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow scrollbar scrollbar-primary',
			]);
		?>

		<a href="#" data-target="slide-out" class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only">
			<div class="bt_mob" id="menu_mob" data-element=".menu_dashboard">
				<img src="img/bt_mob.png" class="img_cem">
			</div>
			<i class="material-icons">menu</i>
		</a>

	</aside>
<?php endif; ?>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/admin/sidebar.blade.php ENDPATH**/ ?>