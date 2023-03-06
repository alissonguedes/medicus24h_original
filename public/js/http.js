'use strict';

if (window.XMLHttpRequest) {
	var xhr = new XMLHttpRequest();
} else {
	var xhr = ActiveXObject('Microsoft.XMLHTTP');
}

var Http = {

	/**
	 * @param {String} url
	 * @param {Object} params
	 * @param  {Function} callback
	 */
	get: (url, params, ...callback) => {

		if (params && typeof params === 'object') {

			var array = [];

			$.ajax({
				async: true,
				dataType: (params.datatype || 'json'),
				data: (params.data || null),
				method: (params.method || 'get'),
				url: url,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
					'Request-Type': 'ajax'
				},
				beforeSend: () => {

					if (params.loading) {
						progress('in');
					}

				},
				success: (response) => {
					for (var i in callback) {
						if (typeof callback[i] === 'function') {
							callback[i](response);
						}
					}
					progress('out');
				},
				error: (error) => {

					progress('out', 0);

					console.log(error);
					alert('Não foi possível continuar. Erro: ' + error);

				}

			});

		} else {

			Http.open('GET', url, ...callback);

		}

	},

	post: (url, params, ...callback) => {

		if (params && typeof params === 'object') {

			var array = [];

			$.ajax({
				async: true,
				dataType: (params.datatype || 'json'),
				data: (params.data || null),
				method: (params.method || 'get'),
				url: url,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
					'Request-Type': 'ajax'
				},
				beforeSend: () => {

					if (params.loading) {
						progress('in');
					}

				},
				success: (response) => {
					for (var i in callback) {
						if (typeof callback[i] === 'function') {
							callback[i](response);
						}
					}
					progress('out');
				},
				error: (error) => {

					progress('out', 0);

					console.log(error);
					alert('Não foi possível continuar. Erro: ' + error);

				}

			});

		} else {

			Http.open('POST', url);

		}

	},

	open: (type, url, ...callback) => {

		xhr.open(type, url);
		xhr.setRequestHeader('Request-Type', 'xmlhttprequest');
		Http.send(url, callback);

	},

	send: (url, ...callback) => {

		var c = callback;

		xhr.onprogress = function(e) {
			// var progressBar = $('.progress').children();
			// var percent = Math.round((e.loaded / e.total) * 100);
			// console.log(percent + '%');

			// console.log(progressBar);
			// // progressBar.css({
			// // 	'width': e.total
			// // });
		}

		xhr.onreadystatechange = function(e) {

			// var status = xhr.getResponseHeader('Location');
			// if (status === 302)
			// 	console.log(xhr.responseUrl);

		}

		xhr.onloadstart = function(e) {

			var s = $('.sidenav'),
				i;

			if (s.length) {
				s.sidenav();
				i = M.Sidenav.getInstance(s)
				i.close();
			}

			progress('in');

		}

		xhr.onloadend = function(e) {

			if (xhr.readyState === 4) {

				if (xhr.status === 0 || xhr.status >= 200 && xhr.status < 400) {
					view(xhr);
				} else {
					alert('Ocorreu algum problema na requisição.');
				}

				for (var i = 0; i < c.length; i++) {
					for (var j = 0; j <= i; j++) {
						if (typeof c[i][j] === 'function') {
							c[i][j](c[i][j]);
						}
					}
				}

			}

			constructor();
			load_scripts();
			progress('out');

		}

		xhr.onload = function(e) {

		}

		xhr.noerror = function(e) {

		}

		xhr.send(null);

	}

}
