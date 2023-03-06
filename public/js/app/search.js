'use strict';

var search = $('[data-search]');

$('body').find(search).each(function() {

	var datatable = $(this).data('json-datatable');

	$(this).bind('keydown paste', () => {
		if ($(this).val() == '')
			progress('in', 'bar');
	});

	if (datatable) {

		Datatable.search(this);

	} else {

		$(this).bind('keyup paste', delay(() => {

			var datatable = $(this).data('json-datatable');

			var url = window.location.href;
			// var url = BASE_URL + $(this).data('search');
			var query = $(this).val();

			if (!datatable) {
				var id = $('#dropdown-registros').find('a.active').data('id');
				var value = $('#dropdown-registros').find('a.active').data('value');

				var params = {
					datatype: 'html',
					data: {
						'query': query,
						// 'filter': id,
						// 'value': value
					}
				}

				Http.get(url, params, (response) => {


					var parse = new DOMParser();
					var total;

					total = parse.parseFromString(response, 'text/html');
					total = $(total).find('#total_results').val();

					$('#results').html(response);
					$('#total-results').find('span').text(total + ' registro' + (total > 1 ? 's' : ''));

					Request.constructor($('#results'));
					btn_form_sidenav();

					progress('out', 'bar');

				});

			}

		}, 200));

	}

})
