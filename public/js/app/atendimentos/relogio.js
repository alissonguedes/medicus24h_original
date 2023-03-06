'use strict';


var Clock = {

	startClock: null,
	startCronometro: 0,
	cronometroStarted: false,
	time: null,
	clock: null,
	format: null,
	milissegundo: 0,
	segundo: 0,
	minuto: 0,
	hora: 0,

	relogio: (clock) => {

		Clock.clock = $(clock) || $('.clock')
		Clock.format = Clock.clock.data('format') || 'LLLL'

		Clock.startClock = setInterval(function() {
			Clock.time = moment().format(Clock.format);
			Clock.clock.html(Clock.time);
		}, 1000);

	},

	cronometro: (clock, time) => {

		if (!$(clock).length) return console.log(clock + ' não está definido.');

		var format = $(clock).data('format') || '00 : 00 : 00';

		let timeRef = document.querySelector(clock);

		time = time ? time.split(/\:/g) : null;

		let hora = time != 0 ? time[0] : null;
		let minuto = time != 0 ? time[1] : null;
		let segundo = time != 0 ? time[2] : null;

		Clock.hora = hora;
		Clock.minuto = minuto;
		Clock.segundo = segundo;

		Clock.startCronometro = setInterval(function() {

			Clock.milissegundo += 10;

			if (Clock.milissegundo === 1000) {
				Clock.milissegundo = 0;
				Clock.segundo++;
				if (Clock.segundo === 60) {
					Clock.segundo = 0;
					Clock.minuto++;
					if (Clock.minuto === 60) {
						Clock.minuto = 0;
						Clock.hora++;
					}
				}
			}

			let h = Clock.hora > 0 && Clock.hora < 10 ? '0' + Clock.hora : Clock.hora;
			let m = Clock.minuto > 0 && Clock.minuto < 10 ? '0' + Clock.minuto : Clock.minuto;
			let s = Clock.segundo > 0 && Clock.segundo < 10 ? '0' + Clock.segundo : Clock.segundo;
			let ms = Clock.milissegundo > 0 && Clock.milissegundo < 10 ? '00' + Clock.milissegundo : Clock.milissegundo;

			$(timeRef).html(`${h} : ${m} : ${s}`);
			$(':input[name="tempo_total"]').val(`${h}:${m}:${s}`);

		}, 10);

		function return_format(v, f) {

			v = v.replace(/\D/g, '');

			f = f.split('');

			// for (var i in f) {

			// 	console.log(f[i]);

			// }
			// var reg = /[a-zA-Z0-9]/;

			// var format = '';
			// var regex = '';
			// var l = 0;
			// var a = '';

			// for (var i in f) {

			// 	if (reg.test(f[i])) {
			// 		l += 1;
			// 	} else {
			// 		var o = f[i];
			// 		l = 0;
			// 	}

			// 	if (l > 0)
			// 		regex = /(\d{`${l}`})(\d)/;

			// 	var o = o || '';

			// 	v = v.replace(regex, "$1" + o + "$2");

			// console.log(v);

			// }


			// v = eval(a);
			// v = v.replace(/(\d{2})(\d)/, '$1:$2');
			// v = v.replace(/(\d{2})(\d)/, '$1:$2');

			return v;

		}

		return Clock.startCronometro;

	},

	start: (clock, time) => {

		if (!$(clock).length) return console.log(clock + ' não está definido.');

		if (!Clock.cronometroStarted) {
			Clock.cronometro(clock, time);
			Clock.cronometroStarted = true;
		}

	},

	pause: () => {

		if (Clock.cronometroStarted) {
			clearInterval(Clock.startCronometro);
			Clock.cronometroStarted = false;
		}

	},

	stop: (clock) => {

		let timeRef = document.querySelector(clock);

		clearInterval(Clock.startCronometro);

		Clock.milissegundo = 0;
		Clock.segundo = 0;
		Clock.minuto = 0;
		Clock.hora = 0;

		var datetime = '00 : 00 : 00';
		timeRef.innerHTML = datetime;
		$(':input[name="tempo_total"]').val('00:00:00');
		Clock.cronometroStarted = false;

	},

}

var controleTime = (interval) => {

	var autosave = 0;

	$('[data-trigger="cronometro"]').each(function() {

		var clock = $(this);

		clock.click(function() {

			var status = null;
			var target = $(this).data('target') || null;
			var time = $(this).data('time') || null;
			var tempo_total = $(':input[name="tempo_total"]');
			var hora_inicial, hora_final;

			console.log(time);

			if ($(this).hasClass('play')) {

				Clock.start(target, tempo_total.val());
				$(this).addClass('pause').removeClass('play').find('.play').addClass('pause').removeClass('play').text('pause');

				message('Atendimento iniciado');

				status = 'I';
				hora_inicial = moment().format('LTS');
				hora_final = null;

				console.log('started');

				var id = $(':input[name="atendimento"]').val();

				$.ajax({
					url: BASE_PATH + 'atendimentos/id/' + id,
					method: 'post',
					dataType: 'json',
					data: {
						id: id,
						status: status,
						hora_inicial: hora_inicial,
						time: tempo_total.val()
					},
					success: (response) => {
						console.log(response);
					}
				});

				autosave = setInterval(function() {

					$.ajax({
						url: BASE_PATH + 'atendimentos/id/' + id,
						method: 'post',
						dataType: 'json',
						data: {
							id: id,
							time: tempo_total.val()
						},
						success: (response) => {
							console.log(response);
						}
					});

				}, 10000)

			} else if ($(this).hasClass('pause')) {

				confirm({
					'titulo': 'Esta ação não poderá ser desfeita',
					'message': 'Tem certeza que deseja finalizar este atendimento?'
				}, (response) => {

					$(this).addClass('play').removeClass('pause').find('.pause').addClass('play').removeClass('pause').text('play_arrow');
					$(this).data('time', tempo_total);

					message('Atendimento finalizado');

					status = 'F';
					hora_final = moment().format('LTS');

					console.log('paused');

					var id = $(':input[name="atendimento"]').val();

					$.ajax({
						url: BASE_PATH + 'atendimentos/id/' + id,
						method: 'post',
						dataType: 'json',
						data: {
							id: id,
							status: status,
							hora_final: hora_final,
							time: tempo_total.val()
						},
						success: (response) => {
							console.log(response);
						}
					});

					Clock.stop(target);
					clearInterval(autosave);

				});

			}

		});

		// var clock = $(this);

		// clock.click(function() {
		// 	var target = clock.data('target') || null;
		// 	Clock.pause(target);
		// 	console.log('paused')
		// });

		// var clock = $(this);

		// clock.click(function() {
		// 	var target = clock.data('target') || null;
		// 	Clock.stop(target);
		// 	console.log('stopped')
		// });

	});

	$('[data-trigger="pause-clock"]').each(function() {



	});

	$('[data-trigger="stop-clock"]').each(function() {


	});

}

controleTime();
Clock.relogio('.clock');
