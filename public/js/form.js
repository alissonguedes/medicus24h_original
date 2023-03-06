'use strict';

var Form = {

	constructor: () => {

		$('body').find('form').each(function() {

			var autoinitialize = typeof $(this).data('autoinitialize') === 'undefined' || $(this).data('autoinitialize') === true;

			if (autoinitialize) {
				Form.addSubmit($(this));
			}

		});

	},

	addSubmit: (form) => {

		if (typeof form === 'undefined') return false;

		form.on('submit', function(e) {

			e.preventDefault();

			Form.submit($(this));

			progress('out');
			var btn_submit = form.find(':submit');
			btn_submit.attr('disabled', false);

		});

	},

	submit: (form, ...callback) => {

		var method = form.attr('method') || 'post';
		var action = form.attr('action') || null;
		var btn_submit = form.find(':submit');

		$(form).ajaxSubmit({
			method: method,
			action: action,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: (e) => {
				progress('in')
				btn_submit.attr('disabled', true);
			},
			success: (response) => {

				var response = typeof response === 'string' ? JSON.parse(response) : response;

				// Se a função existir, permanecer neste bloco e continuar a partir dela
				if (callback.length > 0) {

					for (var i in callback) {

						if (typeof callback[i] === 'function') {

							callback[i](response);

						}

					}

					return false;

				}

				if (response.statusCode === 200 || response.status === 'success') {

					if (response.message) {
						Form.showMessages(form, response.message, response.status);
					}

					Form.reload(form, response);

				} else {

					progress('out');

					// var error = errors.responseJSON;

					// console.log(error);

					// Form.clearErrors(form);
					// Form.showErrors(form, errors, 'error');

					// alert(error.message, error.title, error.status);

					btn_submit.attr('disabled', false);

				}

				progress('out');
				btn_submit.attr('disabled', false);


			},
			error: (errors) => {

				progress('out');

				var error = errors.responseJSON;

				console.log(error);

				Form.clearErrors(form);
				Form.showErrors(form, errors, 'error');

				alert(error.message, error.title, error.status);

				btn_submit.attr('disabled', false);

			}
		});

	},

	reload: (form, data) => {

		console.log(form);

		switch (data.type) {
			case 'refresh':
				Datatable.reload();
				break;
			case 'redirect':
				Http.get(data.url);
				// Http.get(response.url, null, (response) => {
				// 	progress('out')
				// });
				break;
		}

		if (data.close_modal || data.reset_form) {
			form.find(':button:reset').click();
		}

		if (data.clean_form) {
			form.find(':button:submit').attr('disabled', false);
		}

		if (data.message) {
			Form.showMessages(form, data.message);
		}

		progress('out');

	},

	showMessages: (form, info, status) => {

		Form.clearErrors(form);
		message(info, status);

	},

	showErrors: (form, info, status, title) => {

		if (typeof info.errors !== 'undefined') {

			var fields = info.errors;

			form.find('.input-field')
				.removeClass(status)
				.find('.' + status)
				.remove();

			for (var i in fields) {

				form.find('[name="' + i + '"]')
					.parent('.input-field')
					.addClass(status)
					.append($('<div/>', {
						'class': status,
						'html': fields[i]
					}));

			}

		}

	},

	clearErrors: (form) => {

		form.find('.input-field')
			.removeClass('error')
			.find('.error')
			.remove();

	}

}
