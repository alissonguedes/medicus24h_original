<?php $__env->startSection('main' ); ?>

<div id="login-page" class="row">

	<div class="col m8 l8 hide-on-med-and-down gradient-45deg-light-blue-cyan h-100vh">
		<div class="logo">
			<div class="container">
				<div class="row">
					<div class="col s12">
						<div class="text-logo white-text">
							<h5>Clinic</h5>
							<h2>Cloud</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="login-form padding-3 col s12 m12 l4 white h-100vh z-depth-5">

		<div id="client-logo">
			<img src="<?php echo e(asset('img/site/logo/logo.png')); ?>" alt="" class="responsive-img">
		</div>

		<form novalidate="" id="frm-login" class="" action="<?php echo e(route('account.auth.login')); ?>" method="post" enctype="multipart/form-data" autocomplete="off" data-autoinitialize="false">

			<div class="card-panel border-radius-6 z-depth-0 bg-opacity-2 white col s8 m6 l12 offset-s2 offset-m3 pb-5">

				<div class="card-content">

					<div id="boas-vindas" class="vertical-align no-padding flex flex-center mb-10">
						<button type="button" id="btn-back" class="btn btn-small btn-floating z-depth-0 transparent" disabled="disabled">
							<i class="material-icons grey-text text-darken-4">keyboard_arrow_left</i>
						</button>
						<h5 class="animated lightSpeedInRight fast delay-15">
							Bem-vindo!
						</h5>
					</div>

					<div class="inputs">

						<div id="input-login" class="animated">
							<div class="input-field">
								<input type="email" name="login" id="login" autofocus="autofocus">
								<label for="login" class="">
									Usuário
								</label>
							</div>
						</div>

						<div id="input-pass" class="animated">
							<div class="input-field">
								<input type="password" name="senha" id="senha" disabled="disabled" minlength="5">
								<label for="pass" class="active">
									Senha
								</label>
							</div>
						</div>

					</div>

					<br>

					<button type="submit" id="entrar" name="entrar" class="btn btn-small blue darken-2 waves-effect waves-light col s12 mb-10 next">
						<span>Próximo</span>
						<i class="material-icons margin-right">input</i>
					</button>

				</div>

			</div>

			<?php
				if(session('url'))
				$url = session('url');
				else
				$url = session()->get('curl');
			?>

			<input type="hidden" name="acao" value="login">
			<input type="hidden" name="url" id="url" value="<?php echo e(url($url )); ?>">
			<input type="hidden" name="_method" value="post">
			<?php echo csrf_field(); ?>

		</form>

	</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('authentication.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/authentication/login.blade.php ENDPATH**/ ?>