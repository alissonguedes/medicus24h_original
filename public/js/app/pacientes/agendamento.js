'use strict';

var SidenavForm = (target, action, callback) => {

	var modal = $('.form-sidenav#' + target);

	var overlay = $('<div/>', {
		class: 'modal-overlay agendamento',
		style: 'z-index: 996; display: block; opacity: 0.5;'
	})

	if (action === 'close') {

		modal.find('.modal-close').click(function() {
			modal.removeClass('open')
			modal.next('div.modal-overlay').remove();
		});

		modal.find('.modal-close').click();

	} else if (action === 'open') {

		modal.find('form').html('Carregando formulário');

		if (typeof modal.data('dismissible') !== 'undefined' && !modal.data('dismissible')) {
			overlay.on('click', function() {
				modal.find('.modal-close').click();
			});
		}

		modal.addClass('open').parent().remove('.modal-overlay').append(overlay);

	}

	if (typeof callback == 'function') {
		callback(callback);
	}

	$('.form-sidenav').find('.modal-close').click(function() {
		$(this).parents('.form-sidenav').removeClass('open')
		$(this).parents('.form-sidenav').next('div.modal-overlay').remove();
	});

	$('#delete_event').bind('click', function() {

		var id = modal.find('form').find(':input[name="id"]').val();
		var url = $(this).data('url')

		confirm('Deseja cancelar este agendamento?', function() {
			$.ajax({
				'url': url,
				'method': 'delete',
				'dataType': 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				'data': {
					'id': id,
					'_method': 'delete'
				},
				success: (response) => {
					alert(response.message, (r) => {

						var tipo = $('select[name="filtro_categoria_atendimento"]').val();

						Calendar({
							'tipo': tipo
						});

						SidenavForm(modal.attr('id'), 'close');

					});
				}
			})
		});

	});

	Materialize.constructor();
	Request.constructor(modal);
	// Scroller.constructor();
	Mask.init();
	progress('out');

}

/**
 * Função para abrir o formulário lateral da página.
 * @param data Object {
 * @param link String
 * @param name String
 * @param id String
 * @param modal String }
 */
var formSidenav = (data) => {

	var link = data.url,
		name = data.name,
		id = data.id,
		target = data.modal,
		modal = modal = $('.form-sidenav#' + target),
		parametros = data.data;

	progress('in', true)

	var params = {
		[name]: id
	};

	for (var i in parametros) {
		params[i] = parametros[i];
	}

	Http.get(link, {
		datatype: 'html',
		data: params
	}, (response) => {

		var errors = isJSON(response) ? JSON.parse(response) : null;

		if (errors != null) {
			SidenavForm(target, 'close');
			alert(errors, errors.status);
			progress('out')
			return false;
		}

		SidenavForm(target, 'open', () => {
			modal.find('form').html($(response).find('#' + target).find('form').html());
		});

		$('#recorrente').on('change', function() {

			if ($(this).prop('checked')) {
				$(this).parents('.input').css({
					'border-bottom-left-radius': '0px',
					'border-bottom-right-radius': '0px'
				}).next('.days-of-week').slideDown(100);
			} else {
				$(this).parents('.input').css({
					'border-bottom-left-radius': '24px',
					'border-bottom-right-radius': '24px'
				}).next('.days-of-week').slideUp(100);
			}
		});

		// Selects
		var clinica, especialidade, medico;

		autocomplete($('#especialidade'), () => {

			$('#especialidade').on('change', function() {

				especialidade = $(this).val();

				$('#clinica').val('');
				$('#medico').val('');

				autocomplete($('#clinica'), {
					'especialidade': especialidade
				});

				autocomplete($('#medico'), {
					'especialidade': especialidade
				});

			})

		})

		var f = $('#especialidade').val() == '' ? () => {

			$('#clinica').on('change', function() {

				clinica = $(this).val();

				$('#medico').val('');

				autocomplete($('#medico'), {
					'especialidade': especialidade,
					'clinica': clinica,
				})

			})

		} : {
			'especialidade': $('#especialidade').val()
		}

		autocomplete($('#clinica'), f);

		autocomplete($('#medico'), {
			'especialidade': $('#especialidade').val(),
			'clinica': $('#clinica').val()
		})

		autocomplete($('#tipo'));
		autocomplete($('#categoria'));

		// if (!$('input[name="paciente"]').val()) {
		if ($('select[name="nome_paciente"]').length) {
			autocomplete($('#nome_paciente'), () => {
				$('#nome_paciente').on('change', function() {
					var id = $(this).val();
					$('input[name="paciente"]').val(id);
					$.ajax({
						url: BASE_URL + 'pacientes/' + id + '/dados',
						method: 'get',
						success: (response) => {
							for (var i in response) {
								var val = response[i] ? response[i] : '-';
								$('[name="' + i + '"]').val(val).parent('.input-field').find('label').addClass('active');
							}
						}
					})
				});
			});
		}

	});

}

var btn_form_sidenav = () => {

	$('.form-sidenav-trigger').on('click', function() {

		var url = typeof $(this).data('link') !== 'undefined' && $(this).data('link') != '' ? $(this).data('link') : null;
		var modal = typeof $(this).data('target') !== 'undefined' && $(this).data('target') != '' ? $(this).data('target') : null;
		var name = typeof $(this).attr('name') !== 'undefined' ? $(this).attr('name') : null;
		var id = typeof $(this).attr('id') !== 'undefined' ? $(this).attr('id') : null;

		var data = {
			'url': url,
			'name': name,
			'id': id,
			'modal': modal
		}

		formSidenav(data);

	});
}

$(document).ready(function() {

	btn_form_sidenav();

})
