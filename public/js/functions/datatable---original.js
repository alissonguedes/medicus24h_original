'use strict';


var Datatable = {

	table: null,
	url: null,
	datatable: null,
	order: 1,
	direction: 'asc',
	search: null,

	constructor: (element) => {

		Datatable.table = element ? element : $('table.dataTable');
		Datatable.url = Datatable.table.data('url') ? Datatable.table.data('url') : window.location.href;

		if (!Datatable.table || (typeof Datatable.table.data('ajax') !== 'undefined' && !Datatable.table.data('ajax'))) {
			return false;
		}

		Datatable.create();
		Datatable.request();

	},

	reload: () => {
		Datatable.datatable.draw();
	},

	request: () => {

		$('.table.grid')
			.find('.grid-head')
			.find('.grid-row')
			.find('.grid-col')
			.each(function(e) {

				var column = $(this);
				var isDisabled = $(this).data('disabled') == '' || $(this).data('disabled') === true;

				if (!isDisabled) {

					$(this)
						.parents('.table.grid')
						.find('.grid-body')
						.find('.grid-row')
						.each(function() {

							$(this).find('.grid-col').each(function() {
								if ($(this).index() === column.index()) {
									$(this).on('click', function() {
										Http.get($(this).parent('.grid-row').data('href'));
									});
								}
							});

						});

				} else {

					$(this)
						.parents('.table.grid')
						.find('.grid-body')
						.find('.grid-row')
						.each(function() {
							$(this).find('.grid-col').each(function() {
								if ($(this).index() === column.index()) {
									$(this).attr('data-disabled', true);
								}
							});
						});

				}

			});

		Request.constructor();

	},

	ajax: (data) => {

		var data = !data ? {
			'order': Datatable.order,
			'direction': Datatable.direction,
			'search': Datatable.search
		} : data;

		Http.get(window.location.href, {
			datatype: 'html',
			data
		}, (response) => {

			$('.grid-body').html(response);
			Datatable.request();

		});

	},

	create: () => {

		// -----------------------------------------------
		$('.table.grid').each(function() {

			$(this).find('.grid-head').find('.grid-col').on('click', function(e) {

				var isDisabled = $(this).data('disabled') == '' || $(this).data('disabled') === true;

				if (isDisabled) {
					return;
				}

				progress('in', 'bar');

				Datatable.order = $(this).index();
				Datatable.direction = $(this).data('order');

				$(this).parent().find('[data-order]').each(function() {
					if (Datatable.order != $(this).index())
						$(this).removeAttr('data-order');
				});

				if ($(this).attr('data-order') == 'asc') {
					Datatable.direction = 'desc';
				} else if (!$(this).attr('data-order') || $(this).data('order') == 'desc') {
					Datatable.direction = 'asc';
				}

				$(this).attr('data-order', Datatable.direction);

				Datatable.ajax();

			});

		});

		// -----------------------------------------------

		if (typeof Datatable.table.data('ajax') !== 'undefined' && !Datatable.table.data('ajax')) {
			return false;
		}

		if ($('body').find('table.dataTable').length === 0) return;

		Datatable.datatable = Datatable.table.DataTable({
			retrieve: true,
			serverSide: true,
			processing: true,
			scrollCollapse: true,
			displayLength: 50,
			ajax: {
				type: 'get',
				dataType: 'html',
				url: Datatable.url,
				beforeSend: () => {
					progress('in', 'bar');
				},
				success: (response) => {

					var parser = new DOMParser();
					var content = parser.parseFromString(response, 'text/html');
					var tr;

					Datatable.table.find('tbody').html(response).find('#pagination, #info').remove();

					Datatable.table.find('tr').each(function() {

						tr = $(this);

						var modal = tr.data('target');
						var is_modal = /^modal_[a-z]+/i.test(modal);
						var disabled = false;

						// Aqui, verifico se a coluna clicada é desabilitada
						$(this).find('td').on('click', function() {
							if ($(this).data('disabled')) {
								disabled = true;
							} else {
								disabled = false;
							}
						});

						// Aqui, modifico a forma como cursor é apresentado,
						// de acordo com a propriedade "disabled"
						if ($(this).data('disabled')) {
							$(this).addClass('disabled').find('td').css({
								'cursor': 'text !important'
							});
						}

						// Aqui, verifico se o evento modal deve ser acionado,
						// ao clicar na linha da tabela
						$(this).on('click', function() {
							if (!disabled && tr.data('target') && is_modal) {
								var mod = $('#' + $(this).data('target'));
								var url = $(this).data('url');
								var m = Materialize.modal(mod, url);
								var m = M.Modal.getInstance(m);
								m.open();
							}
						});

						if (!tr.data('target') && !is_modal) {
							if (!$(this).data('disabled') && !disabled) {
								// Adiciona eventos de click a botões de ação
								Request.constructor($(this));
							}
						}

						// if (!disabled && tr.data('trigger') == 'sidenav') {
						// 	Buttons.sidenav(tr);
						// }

						// Ativa o botão de edição na modal.
						Materialize.btn_modal($(this).find('[data-trigger="modal"]'));

					}).find('td').each(function(e) {

						var disabled = false;

						$(this).bind('click', function(e) {

							if (!$(this).data('disabled')) {

								e.preventDefault();
								Request.createElement($(this).parent('tr'));

								var id = $(this).parent('tr').attr('id');

								if ($(this).parent('tr').hasClass('form-sidenav-trigger') && $('.form-sidenav').length) {

									var data = {
										'url': BASE_URL + 'agendamentos/id/' + id,
										'modal': 'agendamento',
										// 'data': {
										// 	'data': date,
										// 	'hora': hour
										// }
									}

									formSidenav(data);

								} else {

								}

							} else {
								disabled = true;
							}

						});

						if ($(this).parent('tr').data('trigger') != 'modal') {

							if (!$(this).data('disabled')) {

								var params = {
									url: $(this).parent('tr').data('url'),
									target: $(this).parent('tr').data('target'),
								}

								Buttons.sidenav($(this), params);

							} else {

								var btn = $(this).find('[data-trigger="sidenav"]');
								var params = {
									url: btn.data('url'),
									target: btn.data('target'),
								}

								Buttons.sidenav(btn, params);
							}
						}

					});

					var pagination = $(content).find('#pagination').html();
					var info = $(content).find('#info').html();

					Datatable.table.parents('.dataTables_wrapper').find('.dataTables_info').html(info);
					Datatable.table.parents('.dataTables_wrapper').find('.dataTables_paginate').html(pagination).each(function() {
						Request.constructor($(this));
					});

					Datatable.table.parents('.dataTables_wrapper').find('.dataTables_processing').hide();
					progress('out');

				},

				error: (error) => {
					var parser = new DOMParser();
					var response = parser.parseFromString(error.responseText, 'text/html');
					alert('Abra o console do navegador para analisar os erros.', 'Existem erros!!!', 'error');
					console.log(response);
					progress('out');
				}

			},
			// sPaginationType: 'materialize',
			oLanguage: {
				sEmptyTable: 'Nenhum dado encontrado.',
				sInfo: '_START_ - _END_ / _TOTAL_',
				sInfoEmpty: 'Nenhum dado encontrado.',
				sInfoFiltered: '_COUNT_ registro(s) encontrado(s).',
				sInfoPostFix: null,
				sInfoThousands: '.',
				sLengthMenu: '_MENU_',
				sLoadingRecords: 'Carregando...',
				sProcessing: '<div class="progress"></div class="indeterminate"></div></div>',
				sZeroRecords: '',
				sSearch: Datatable.table.data('label') || '',
				sSearchPlaceholder: Datatable.table.data('placeholder') || '',
				oPaginate: {
					sNext: 'Próximo',
					sPrevious: 'Anterior',
					sFirst: 'Primeiro',
					sLast: 'Último',
				},
				order: [Datatable.order, Datatable.direction],
				columnDefs: [{

				}]
			}
		});

		Datatable.search();

	},

	draw: (value) => {

		if ($('table.dataTable').length) {

			Datatable.datatable.search(value).draw();

		} else {

			$('.table.grid').each(function() {

				var url = $(this).data('url') || window.location.href;

				Datatable.search = value ? value : null;
				Datatable.ajax();

			});

			progress('out');

		}

	},

	search: (input) => {

		var search = input ? $(input) : $('body').find('.dataTable_search');

		if (search) {

			search.bind('keyup paste', delay(function() {
				Datatable.draw(this.value);
			}, 200));

			if (search.val()) {
				Datatable.draw(search.value);
			}
		}

	}

}
