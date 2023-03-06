<?php if(session()->has('userdata')): ?>
	<header id="header" class="page-topbar">
		<div class="navbar navbar-fixed">
			<nav class="navbar-main navbar-color navbar-collapsible blue lighten-1">
				<div class="nav-wrapper">

					<?php $__env->startSection('header'); ?>
					<div class="page-title" style="display: inline-block;">
						<div class="flex flex-center">
							<?php $__env->startSection('back-button'); ?>
							<button class="btn btn-flat btn-floating btn-small waves-effect" data-href="<?php echo $__env->yieldContent('prev-url'); ?>">
								<span class="material-icons">arrow_back</span>
							</button>
							<?php echo $__env->yieldSection(); ?>
							<h5 class="title">
								<?php echo $__env->yieldContent('title'); ?>
							</h5>
						</div>
					</div>
					<?php echo $__env->yieldSection(); ?>

					<?php $__env->startSection('navbar-header'); ?>
					<ul class="navbar-list right">
						
<li class="hide-on-med-and-down">
	<a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);">
		<i class="material-icons">settings_overscan</i>
	</a>
</li>
<li class="hide-on-large-only search-input-wrapper">
	<a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);">
		<i class="material-icons">search</i>
	</a>
</li>

<li>
	<a href="javascript:void(0);" class="waves-effect waves-block waves-light dropdown-trigger" data-cover-trigger="true" data-align="right" data-target="profile-dropdown">
		<span class="avatar-status avatar-online">
			<img src="<?php echo e(asset('assets/images/perfil/foto.jpg')); ?>" alt="avatar">
			<i></i>
		</span>
	</a>
	<ul class="dropdown-content" id="profile-dropdown" tabindex="0">
		<li tabindex="0">
			<a class="grey-text text-darken-1" href="user-profile-page.html">
				<i class="material-icons">person_outline</i>
				Profile
			</a>
		</li>
		
		<li tabindex="0">
			<a href="<?php echo e(go('logout')); ?>" class="grey-text text-darken-1">
				<i class="material-icons">keyboard_tab</i>
				Logout
			</a>
		</li>
	</ul>
</li>

</ul>
<?php echo $__env->yieldSection(); ?>

</div>
</nav>
</div>
</header>
<?php endif; ?>
<?php /**PATH /home/alissonp/www/transvida/application/resources/views/clinica/header.blade.php ENDPATH**/ ?>