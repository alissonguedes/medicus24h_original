<header>

	<nav class="nav-extended nav-fixed white">

		<div class="nav-wrapper container">

			<div class="menu-header">

				<a href="<?php echo e(route('main.home')); ?>" itemprop="url" class="brand-logo site-logo">
					<img src="<?php echo e(asset('img/site/logo/logo.png')); ?>" alt="" class="logo">
				</a>

				<div class="flex flex-center flex-end">

					<div class="hide-on-med-and-down">
						<ul class="hide-on-med-and-down" id="ul-horizontal-nav">
							<?php echo $__env->yieldContent('menu-list'); ?>
						</ul>
					</div>

					<div class="form-search hide">
						<input type="search" class="hide-on-small-only" placeholder="Pesquisar no site...">
						<button type="submit" class="btn btn-flat btn-floating waves-effect">
							<i class="material-icons">search</i>
						</button>
					</div>

					<a href="#" data-target="slide-out" class="sidenav-trigger">
						<i class="material-icons">menu</i>
					</a>

				</div>

			</div>

		</div>

	</nav>

</header>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/main/header.blade.php ENDPATH**/ ?>