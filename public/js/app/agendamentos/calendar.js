'use strict';

$(document).ready(function() {

	var tipo = $('select[name="filtro_categoria_atendimento"]').val();

	var data = tipo !== 'undefined' && tipo != null ? {
		'tipo': tipo
	} : null;

	Calendar(data);

	$('select[name="filtro_categoria_atendimento"]').on('change', function() {
		tipo = $(this).val();
		Calendar({
			'tipo': tipo
		})
	});

	$('#modal-filter').find(':button:reset').on('click', function() {
		$(this).parents('#modal-filter').find('select,input').each(function() {
			var value = $(this).data('value');
			$(this).val(value).trigger('change');
		})

	})


	$('#agendamento').find('form').on('submit', function(e) {

		e.preventDefault();

		var url = $(this).attr('action')
		var method = $(this).attr('method');
		var tipo = $('select[name="filtro_categoria_atendimento"]').val();

		Form.submit($(this), (response) => {

			if (response.close_modal)
				$(this).find(':button:reset').click();

			if ($('#calendar').length) {

				Form.showMessages($(this), response.message, response.status);

				Calendar({
					'tipo': tipo
				});

			} else {

				Form.reload($(this), response);

			}

		});

	});

})

function Calendar(params, el) {

	if ($('body').find('.calendar').length === 0) {
		// // console.log('calendaŕio não existe');
		// $('body,horizontal-layout').removeClass('main-full').removeClass('active').find('.sidenav-main').find('.active').removeClass('active');
		// $('.sidenav-main').addClass('nav-expanded nav-lock').removeClass('nav-collapsed').find('.collapsible-body').hide();
		// $('#main').removeClass('main-full')

		return false;
	}

	var loading = `<div style="display: flex; align-items: center;">
							<div class="preloader-wrapper small active" style="margin-right: 20px;">
								<div class="spinner-layer spinner-green-only">
									<div class="circle-clipper left">
										<div class="circle"></div>
									</div>
									<div class="gap-patch">
										<div class="circle"></div>
									</div>
									<div class="circle-clipper right">
										<div class="circle"></div>
									</div>
								</div>
							</div>
							<p class="calendar-loading">
								Carregando o calendário...
							</p>
						</div>`;
	$('#calendar').html(loading);

	// Para remover a classe caso não possua itens de calendário na página
	$('body').removeClass('main-full');

	// var calendarEl = document.getElementById('calendar');
	var calendarEl = typeof el === 'undefined' ? document.querySelector('.calendar') : document.querySelector('.calendar');

	if (calendarEl === null) return;

	var p = {};

	p['ajax'] = true;

	if (typeof params !== 'undefined') {
		for (var i in params) {
			p[i] = params[i];
		}
	}

	var calendar = new FullCalendar.Calendar(calendarEl, {
		// height: $(calendarEl).closest('#main').outerHeight() - 60,
		headerToolbar: {
			left: 'dayGridMonth,timeGridWeek,timeGridDay',
			center: 'title',
			right: 'today prev,next',
		},
		titleFormat: {
			month: 'long',
			year: 'numeric',
			day: 'numeric',
			// weekday: 'long'
		},
		timeZone: 'America/Sao_Paulo',
		locale: 'pt-br',
		buttonText: {
			today: 'Hoje',
			month: 'Mês',
			week: 'Semana',
			day: 'Dia',
			list: 'Lista'
		},
		// plugins: [ 'dayGridWeek' ],
		// initialDate: '2022-12-07',
		// navLinks: true, // can click day/week names to navigate views
		selectable: false,
		selectAllow: true,
		selectMirror: true,

		eventDragStop: function(e, a, i) {
			console.log(e);
		},

		// eventAdd: function(a, e, i, o, u) {
		// 	console.log(a, e, i, o, u);
		// },

		eventResize: function(a, b, c, d, e, f, g) {
			console.log(a, b, c, d, e, f, g);
		},

		eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {

			// alert(
			// 	event.title + " was moved " +
			// 	dayDelta + " days and " +
			// 	minuteDelta + " minutes."
			// );

			// if (allDay) {
			// 	alert("Event is now all-day");
			// } else {
			// 	alert("Event has a time-of-day");
			// }

			// if (!confirm("Are you sure about this change?")) {
			// 	revertFunc();
			// }
			console.log(event, dayDelta, minuteDelta, allDay, revertFunc);

		},

		dateClick: function(arg) {

			// arg.jsEvent.preventDefault();

			var timestamp = arg.dateStr.split('T');
			var date = timestamp.slice(0, 1).toString();
			var hour = timestamp.length == 2 ? timestamp.splice(-1).toString().split(':') : null;

			date = date.split('-');
			var d = date.splice(-1);
			var m = date.splice(1);
			var a = date.splice(0);

			var h = hour !== null ? hour.splice(0, 1) : '00';
			var i = hour !== null ? hour.splice(1) : '00';
			var s = hour !== null ? hour.splice(-1) : '00';

			var date = d + '/' + m + '/' + a;
			var hour = h + ':' + i;

			// $('.form-sidenav-trigger').click();

			// setTimeout(function() {
			// $('#agendamento').find('form').find('input[name="data"]').val(dateFormat);
			// $('#agendamento').find('form').find('input[name="hora"]').val(hourFormat);
			// Materialize.inputs();
			// }, 500);

			var data = {
				'url': BASE_URL + 'agendamentos/new',
				'modal': 'agendamento',
				'data': {
					'data': date,
					'hora': hour
				}
			}

			formSidenav(data);

		},
		eventClick: function(e) {

			e.jsEvent.preventDefault();

			// $('#agendamento').find(':button:reset').click();

			var id = e.event.id;
			var url = e.event.url;

			var data = {
				'url': url,
				'modal': 'agendamento'
			}

			formSidenav(data);

			$('.fc-popover').remove();

		},
		editable: false,
		dayMaxEvents: true, // allow "more" link when too many events
		fixedWeekCount: false,
		events: {
			url: BASE_URL + 'agendamentos/eventos',
			method: 'get',
			extraParams: p,
		},
		eventContent: (arg) => {
			return {
				html: arg.event.title
			}
		}
	});

	$('horizontal-layout').addClass('main-full').removeClass('active').find('.sidenav-main').find('.active').removeClass('active');
	$('.sidenav-main').removeClass('nav-expanded nav-lock').addClass('nav-collapsed').find('.collapsible-body').hide();
	$('#main').addClass('main-full')

	setTimeout(function() {
		$('#calendar').empty();
		$('#calendar').find('.calendar-loading').remove();
		calendar.render();
		$('.fc-button.fc-prev-button,.fc-button.fc-next-button,.fc-button.fc-today-button').each(function() {
			$(this).addClass('waves-effect waves-light');
		});
		progress('out');
	}, 200);

}
