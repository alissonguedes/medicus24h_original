'use strict';

var object,
	fn;

var Mask = {

	maxlength: {
		cep: 9,
		cnpj: 14,
		cpf: 11,
		date: 10,
		email: null,
		time: 8,
		credit_card: 19
	},

	format: {
		cep: /(\d{5}\-(\d{3}))/,
		cnpj: /(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})\-(\d{2})/,
		cpf: /(\d{3})\.(\d{3})\.(\d{3})\-(\d{2})/,
		date: /(([0-2][0-9])|([3][0-1]))\/(([0][0-9])|[1][0-2])\/(\d{4})/,
		email: /^$/,
		time: /(([0-1][0-9])|([2][0-3]))\:([0-5][0-9])(\:[0-5][0-9])?/,
		credit_card: /[(\d{4})(\s)]+/
	},

	exec: (input, mask) => {

		for (var i in Mask) {
			if (typeof Mask[i] === 'function' && i === mask) {
				return input.value = Mask[i](input.value);
			}
		}

		console.error(mask + ' Não existe em Mask');
		return false;

	},

	string: (v) => {

		return v;

	},

	numeric: (v) => {

		console.log(v);

		return v;

	},

	cpf: (v) => {

		v = v.replace(/\D/g, '');

		v = v.replace(/(\d{3})(\d)/, '$1.$2');
		v = v.replace(/(\d{3})(\d)/, '$1.$2');
		v = v.replace(/(\d{3})(\d{1,2})/, '$1-$2');

		return v;

	},

	cnpj: (v) => {

		v = v.replace(/\D/g, '');

		v = v.replace(/(\d{2})(\d)/, '$1.$2');
		v = v.replace(/(\d{3})(\d)/, '$1.$2');
		v = v.replace(/(\d{3})(\d)/, '$1/$2');
		v = v.replace(/(\d{4})(\d)/, '$1-$2');

		return v;

	},

	cpfcnpj: (v) => {

		if (v.length <= 14) {
			v = Mask.cpf(v);
		} else {
			v = Mask.cnpj(v);
		}

		return v;

	},

	date: (v) => {

		v = v.replace(/\D/g, '');

		v = v.replace(/(\d{2})(\d)/, '$1/$2');
		v = v.replace(/(\d{2})(\d)/, '$1/$2');
		v = v.replace(/(\d{4})(\d)/, '$1/$2');

		return v;

	},

	time: (v) => {

		v = v.replace(/\D/g, '');

		v = v.replace(/(\d{2})(\d)/, '$1:$2');
		v = v.replace(/(\d{2})(\d)/, '$1:$2');

		return v;

	},

	phone: (v) => {

		v = v.replace(/\D/g, '');

		v = v.replace(/(\d{2})(\d)/, '($1) $2');

		if (v.length < 14) {
			v = v.replace(/(\d{4})(\d)/, '$1.$2');
		} else {
			v = v.replace(/(\d{5})(\d)/, '$1.$2');
			v = v.replace(/(\d{1})(\d{2})/, '$1 $2');
		}

		return v;

	},

	celular: (v) => {

		v = v.replace(/\D/g, '');

		v = v.replace(/(\d{2})(\d)/, '($1) $2');
		v = v.replace(/(\d{3})(\d)/, '$1 $2');
		v = v.replace(/(\d{3})(\d)/, '$1 $2');

		return v;

	},

	cep: (v) => {

		v = v.replace(/\D/g, '');

		v = v.replace(/(\d{5})(\d)/, '$1-$2');

		return v;

	},

	email: (v) => {

		return v;

	},

	credit_card: (v, len) => {

		var len = len || 4;
		console.log(v);
		v = v.replace(/\D/g, '');

		for (var i = 1; i <= 4; i++) {
			v = v.replace(/(\d{4})(\d)/, '$1 $2');
		}

		return v;

	},

	init: () => {

		$('[data-mask]').each(function() {

			var mask = $(this).data('mask');
			var maxlength = $(this).attr('maxlength') || Mask.maxlength[mask];
			var placeholder = $(this).attr('placeholder') || null;

			if (maxlength)
				$(this).attr('maxlength', maxlength);

			if (placeholder) {
				$(this).attr('placeholder', placeholder)
					.parent('.input-field')
					.find('label')
					.addClass('active');
			}

			Mask.exec(this, mask, maxlength);

			if ($(this).attr('type') == 'hidden') {

				var text = $(this).val();

				$(this).parent().append($('<label/>', {
					for: mask,
					text: text || 'Não informado',
				}).css({
					'color': text ? 'inherit' : null
				}))

			} else {

				$(this).bind('keyup keypress', function() {

					Mask.exec(this, mask);

					$(this).parent('.input-field').removeClass('error').find('.error').remove();

					var format = Mask.format[mask];

					if (format && !format.test($(this).val())) {
						$(this).parent('.input-field').addClass('error').append($('<div>', {
							'class': 'error',
							'html': 'Formato inválido.',
						}));
					}

					if (!$(this).val())
						$(this).parent('.input-field').removeClass('error').find('.error').remove();

				});

			}

		});

	}

}
