'use strict';

/**
 * Substitui a caixa de alerta padrão do navegador
 * @param {string|object|array} message
 * @param {string|function} title
 * @param {string} type
 */
var alert = (message, title, type) => {

	var m = $('#alerts');
	var i = title,
		t = type;

	m.addClass(t).modal({
		dismissible: true,
		inDuration: 100,
		startingTop: '35%',
		endingTop: '35%',
		onCloseStart: () => {
			m.removeClass(t);
			if (typeof i === 'function') {
				return i(i);
			}
		},
	});

	if (message !== null && typeof message === 'object') {

		title = message.title;
		message = message.message;

	}

	m.find('.modal-content').find('.title').html(title);
	m.find('.modal-content').find('.info').html(message);

	var buttons = `<button type="button" class="btn blue lighten-1 modal-close">
	Ok
	</button>`;

	m.find('.modal-footer').html(buttons);

	setTimeout(function() {
		m.modal('open');
	}, 1);

}

var message = (info, status, title) => {

	if (typeof message === 'object') {
		var info = info.message;
	}

	var classes = 'z-depth-2';

	M.Toast.dismissAll();
	M.toast({
		classes: classes + ' ' + (typeof status !== null ? status : ''),
		html: info
	});

}

var confirm = (message, ...func) => {


	var m = $('#alerts');

	m.addClass('info').modal({
		dismissible: false,
		inDuration: 100,
		startingTop: '15%',
		endingTop: '15%',
	});

	if (typeof message === 'object') {
		var titulo = typeof message.titulo !== 'undefined' ? message.titulo : '';
		var message = typeof message.message !== 'undefined' ? message.message : '';

		m.find('.modal-content').find('.title').html(titulo);

	}

	m.find('.modal-content').find('.info').html(message);

	var buttons = `<button type="button" class="btn white black-text mr-3 modal-close" id="no">
	<i class="material-icons-outlined">close</i>
	</button>`;

	buttons += `<button type="button" class="btn red" id="yes">
	<i class="material-icons-outlined">check</i>
	</button>
	`;

	m.find('.modal-footer').html(buttons);

	setTimeout(function() {
		m.modal('open');
	}, 1);

	$(m.find('.modal-footer').find(':button:button')).on('click', function() {

		var button = $(this).attr('id');
		var confirm = button == 'yes' ? true : false;

		if (confirm) {

			if (typeof func === 'object') {
				for (var i in func) {
					func[i](func);
				}
			} else if (typeof func === 'function') {
				return func(func);
			}

			m.modal('close');

		}

	});

}
