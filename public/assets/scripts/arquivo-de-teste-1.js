$('body').find('.responsive-table').find(button_del).bind('click', function() {

	var self = $(this);
	var id = [];
	var type = null;
	var status = $(this).val();
	var method = typeof $(this).data('method') !== 'undefined' ? $(this).data('method') : 'patch';

	if (self.parents('.responsive-table').find('.dataTables_wrapper').length > 0) {
		self.parents('.responsive-table').find('.dataTables_wrapper').find('tbody :checkbox:checked').each(function() {
			id.push($(this).val());
		});
	} else {
		id.push(self.val());
		type = 'back';
	}

	Http.post($(this).data('link'), {
		'method': 'delete/patch',
		'datatype': 'json',
		'headers': {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		'data': {
			'id': id,
			'type': type,
			'value': status
		}
	}, ($response) => {

		if ($response.type === 'back')
			Http.goTo((typeof $response.url !== 'undefined' ? $response.url : $(this).data('link')), {
				'message': $response.message,
				'status': $response.status
			});
		else {

			if (typeof $response.message !== 'undefined')
				Form.showMessage($response.message, $response.status);

			DataTable(true);

		}

	});

});
