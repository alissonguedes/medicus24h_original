'use strict';

var login = () => {

	let titulo = null;

	$('#frm-login').on('submit', function(e) {

		e.preventDefault();
		progress('out')

		var self = $(this);
		var method = self.attr('method') || 'post';
		var action = self.attr('action') || null;
		var btn_submit = self.find(':submit');

		self.ajaxSubmit({
			method: method,
			action: action,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: (e) => {
				btn_submit.attr('disabled', true);
			},
			success: (response) => {

				var response = typeof response === 'string' ? JSON.parse(response) : response;

				let status = response.statusCode;
				titulo = 'Olá, ' + response.data.user + ', seja bem-vindo!';

				if (status === 201) {

					if (response.message) {
						Form.showMessages(self, response.message, response.status);
					}

					$('#boas-vindas')
						.removeClass('fadeOutLeft fadeInLeft fadeInRight fadeOutRight')
						.find('h5')
						.html(titulo);

					$('#boas-vindas')
						.removeClass('fadeOutLeft')
						.addClass('fadeInLeft')

					$('#input-login')
						.removeClass('fadeOutLeft fadeInLeft fadeInRight fadeOutRight')
						.addClass('fadeOutLeft')
						.find('[name="login"]')
						.attr('disabled', true);

					$('#input-pass')
						.removeClass('fadeOutLeft fadeInLeft fadeInRight fadeOutRight')
						.addClass('fadeInRight')
						.show()
						.find('[name="senha"]')
						.attr('disabled', false);

					setTimeout(function() {
						$('#input-pass').find('[name="senha"]')
							.focus()
						self.find(':submit').attr('disabled', false)
					}, 700);

					$('#relembrar_login')
						.hide();

					$('#btn-back,#relembrar_senha')
						.css('display', 'flex')
						.attr('disabled', false);

				} else {

					if (response.message) {
						Form.showMessages(self, response.message, response.status);
					}

					Http.get(response.url);

				}

			},
			error: (error) => {

				var errors = error.responseJSON;
				Form.clearErrors(self);
				Form.showErrors(self, errors, 'error');

				btn_submit.attr('disabled', false);
				progress('out')

			}
		});

	});

	$('#frm-login').find('#btn-back').on('click', function() {

		$('#boas-vindas')
			.removeClass('fadeOutLeft fadeInLeft fadeInRight fadeOutRight');

		$('#boas-vindas')
			.removeClass('fadeOutRight')
			.addClass('fadeInRight')

		$('#input-pass')
			.removeClass('fadeOutLeft fadeInLeft fadeInRight fadeOutRight')
			.addClass('fadeOutRight')
			.find('[name="senha"]')
			.val('')
			.attr('disabled', true);

		$('#input-pass').find('.input-field').find('label').removeClass('active');

		$('#btn-back,#relembrar_senha')
			.css('display', 'flex')
			.attr('disabled', true)
			.hide();

		$('#input-login')
			.removeClass('fadeOutLeft fadeInLeft fadeInRight fadeOutRight')
			.addClass('fadeInLeft')
			.show()
			.find('[name="login"]')
			.attr('disabled', false)
			.focus()
			.select();

		$('#relembrar_login').show();

	});

}
