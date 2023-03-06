<footer class="teal darken-1">

	<div class="page-footer container">

		<div class="row">

			<div class="col l3 m4 s12">
				<div class="logo logo-footer">
					<a href="<?php echo e(route('main.home')); ?>" class="brand-logo white-text">
						<img src="<?php echo e(asset('img/site/logo/logo-white.png')); ?>" alt="">
					</a>
				</div>
			</div>

			<div class="col l3 m4 s12 mb-3 flex flex-column">
				<h5>Institucional</h5>
				<ul class="menu">
					<?php echo $__env->yieldContent('menu-list'); ?>
				</ul>
			</div>

			<div class="col l6 m4 s12">

				<div class="row">
					<div class="col s12 flex">
						<h5>Endereços</h5>
					</div>
				</div>

				<div class="row">
					<div class="col s12 m6 l6">
						<div class="address">
							<h6>Unidade João Pessoa</h6>
							<p>
								Av. Carneiro da Cunha, 64<br>
								Torre - João Pessoa - PB<br>
								<i class="material-icons hide-on-med-and-down" style="font-size: inherit; margin-top: 4px; position: relative; float: left; margin-right: 10px;">phone</i> (83) 3024·9880<br>
								<i class="icon whatsapp hide-on-med-and-down" style="margin-top: 4px; position: relative; float: left; margin-right: 10px;"></i> (83) 986 786 130
							</p>
						</div>
					</div>
					<div class="col s12 m6 l6">
						<div class="address">
							<h6>Unidade Campina Grande</h6>
							<p>
								Rua Ascendino Toscano Brito, 114<br>
								Santa Cruz - Campina Grande - PB<br>
								<i class="material-icons hide-on-med-and-down" style="font-size: inherit; margin-top: 4px; position: relative; float: left; margin-right: 10px;">phone</i> (83) 3339·1592<br>
								<i class="icon whatsapp hide-on-med-and-down" style="margin-top: 4px; position: relative; float: left; margin-right: 10px;"></i> (83) 988 699 434

							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row">

				<div class="col s12">
					
					<ul class="social">
						
						<li>
							<a href="#">
								<i class="icon instagram"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="icon facebook"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="icon youtube"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>

		</div>


	</div>

	<div class="teal darken-3">
		<div class="container">
			<div class="row">
				<div class="copy col s12 l6">
					<?php echo e(date('Y')); ?> - Todos os direitos reservados &copy; <?php echo $__env->yieldContent('site-title'); ?>
				</div>
				<div class="dev col s12 l6">
					Desenvolvido por Alisson Guedes
				</div>
			</div>
		</div>
	</div>

</footer>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/main/footer.blade.php ENDPATH**/ ?>