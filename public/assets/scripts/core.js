var checkLogs;

window.onload = () => {

	window.addEventListener("popstate", function() {
		var href = this.location.href;
		if (Request.isLink(href)) {
			Http.get(href);
		}
	}, true);

	core();

	setTimeout(function() {
		$("#carregando").remove();
	}, 550);

	// checkLogs = setInterval(checkLog, 200);3

	if ($('body').find('[data-url-lang]').length)
		translate($('[data-url-lang]').data('url-lang'));

};

function core() {

	$('.material-tooltip,.sidenav-overlay,.modal-overlay').remove();

	$("select").formSelect({
		isMultiple: false
	});

	Request.menu();
	Request.addEvent();
	Form.init();

	// checkAll();
	// resizeBody();
	// buttonActions(table.find(':button[data-link]:not([data-target])'));
	// btnModalForms(table.find('[data-target]'));

	resizeble();
	DataTable();
	buttonActions($('#dropdown-actions').find(':button[data-link]'));
	btnModalForms($('body').find('button[data-link][data-target]'));
	Materializecss();
	editor();
	preview_map();
	Mascaras.aplicarMascaras();
	fullcalendar_init();

	$('.dd').nestable({
		maxDepth: Infinity
	});

	$('h4.title').each(function() {
		var w = $(this).text().length;

		$('h4.title::after').css({
			'padding-left': 'calc(100% - ' + w + 'px)',
			'background': 'pink !important'
		});

	})

	var id_item = null;
	$('.dd').each(function() {
		var self = $(this);

		self.on('change', function() {
			Http.post('paginas/menus', {
				'data': {
					'menus': self.nestable('serialize'),
					'idMenu': self.find('.dd-list').data('menu')
				}
			}, function(response) {
				// console.log('Response: ', response);
			})
		});
	})

	// setTimeout(function() {
	// 	Storage.checkSession();
	// }, 200);

	$(".materialboxed").each(function() {
		var materialbox = $(this);
		materialbox.materialbox({
			// 'onOpenStart': function() {
			//     materialbox.removeClass('circle');
			// },
			onCloseEnd: function() {
				materialbox.parents(".collection").css("overflow-y", "inherit");
			},
		});
	});

	$(window).on("resize", function() {
		resizeble();
	});

	// Isotope
	// init Isotope
	var $grid = $("#produtos").isotope({
		itemSelector: ".produtos",
		layoutMode: "fitRows",
	});

	// bind filter button click
	$("#filters").on("click", "[data-filter]", function() {
		var filterValue = $(this).attr("data-filter");
		// use filterFn if matches value
		$grid.isotope({
			filter: filterValue,
		});
	});

	// botão para exibir o forumlário da página de e-mail
	// $('[data-trigger-on]').each(function() {
	//     $(this).bind('click', function() {
	//         var trigger = $(this).data('trigger-on');
	//         animate($(trigger).show(), 'slideInRight faster', function(e) {
	//             e.removeClass('animated slideInLeft faster')
	//         });
	//         animate('.dataTables_wrapper', 'slideOutLeft faster', function(e) {
	//             e.hide().removeClass('animated slideInLeft faster');
	//         });
	//         $(this).parents('.panel').find('#form_mail_actions').css('display', 'flex')
	//             .find('button').attr('disabled', false)
	//         $(this).parents('.panel').find('.show-buttons, .panel-header .input-field').hide();
	//     });
	// });
	// botão voltar para esconder o formulário da página de e-mail
	var modal = $('.modal').modal({
		dismissible: typeof $(modal).data('dismissible') !== 'undefined' && $(modal).data('dismissible') != '' ? $(modal).data('dismissible') : false,
		inDuration: 150,
		outDuration: 200,
		outDuration: 200,
		startingTop: "30%",
		endingTop: "30%",
	});

	$(".btn-back").each(function() {
		$(this).bind("click", function() {
			var trigger = $(this).data("trigger-off");
			var modal = $(".modal");
			$(".modal").modal({
				dismissible: false,
				inDuration: 150,
				outDuration: 200,
				outDuration: 200,
				startingTop: "33%",
				endingTop: "33%",
				onOpenEnd: function(el) {
					modal.find("button").bind("click", function() {
						var confirm = $(this).data("confirm");
						if (confirm) {
							$(this).parents(".panel").find("#form_mail_actions").css("display", "none").find("button").attr("disabled", true);
							animate($(".dataTables_wrapper").show(), "slideInLeft faster", function(e) {
								e.removeClass("animated slideInLeft faster");
							});
							animate($(trigger), "slideOutRight faster", function(e) {
								e.hide().removeClass("animated slideOutRight faster");
							});
							Form.reset();
							$(this).parents(".panel").find(".show-buttons, .panel-header .input-field").show();
							modal.modal("close");
						}
					});
				},
				onCloseStart: function(el) {},
			});
			modal.modal("open");
		});
	});

	$('.form-sidenav-trigger').on('click', function() {

		var link = typeof $(this).data('link') !== 'undefined' && $(this).data('link') != '' ? $(this).data('link') : null;
		var modal = typeof $(this).data('target') !== undefined && $(this).data('target') != '' ? $(this).data('target') : null;

		var name = typeof $(this).attr('name') !== 'undefined' ? $(this).attr('name') : null;
		var id = typeof $(this).attr('id') !== 'undefined' ? $(this).attr('id') : null;

		var params = {
			[name]: id
		};

		Http.get(link, {
			'datatype': 'html',
			'data': params,
		}, (response) => {

			Form.clearErrors();

			var errors = isJSON(response) ? JSON.parse(response) : null;

			if (errors != null) {

				$('.form-sidenav#' + target).find('.modal-close').click(function() {
					sidenav.removeClass('open')
					sidenav.next('div.modal-overlay').remove();
				});
				$('.form-sidenav#' + target).find('.modal-close').click();

				alert(errors, errors.status);

				return false;

			}

			var target = $(this).data('target');
			var sidenav = $('#' + target);
			var overlay = $('<div class="modal-overlay" style="z-index: 9; display: block; opacity: 0.5">');
			sidenav.addClass('open').parent().remove('div.modal-overlay').append(overlay);


			$('#' + target).find('form').html($(response).find('#' + target).html());

			if (typeof sidenav.data('dismissible') !== 'undefined' && !sidenav.data('dismissible')) {
				overlay.on('click', function() {
					sidenav.removeClass('open');
					sidenav.next('div.modal-overlay').remove();
				});
			}

			$('.form-sidenav#' + target).find('.modal-close').click(function() {
				sidenav.removeClass('open')
				sidenav.next('div.modal-overlay').remove();
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

			Mascaras.aplicarMascaras();
			autocomplete();

			requirejs([BASE_PATH + '/js/app.js'], () => {

				var app = new App();
				// app.select_specialidade();

			});


		});


	})


	if ($(".sidenav").length > 0) new PerfectScrollbar(".sidenav");
	if ($("div.table").length > 0) new PerfectScrollbar(".table .table-body", {
		'suppressScrollX': true
	});

	$scroller = '.scroller';

	if (0 < $(".scroller").length) new PerfectScrollbar($scroller, {
		theme: "dark",
		'wheelPropagation': false,
		'suppressScrollY': typeof $($scroller).data('hide-y') !== 'undefined' && $($scroller).data('hide-y') != '' ? $($scroller).data('hide-y') : false,
		'suppressScrollX': typeof $($scroller).data('hide-x') !== 'undefined' && $($scroller).data('hide-x') != '' ? $($scroller).data('hide-x') : false
	});

	$("#contact-sidenav").sidenav({
		edge: "left",
		onOpenStart: function() {
			$("#sidebar-list").addClass("sidebar-show");
		},
		onCloseEnd: function() {
			$("#sidebar-list").removeClass("sidebar-show");
		},
	});

	// $(".sidenav-trigger").on("click",function(){$(window).width()<960&&($(".sidenav").sidenav("close"),$(".app-sidebar").sidenav("close"))}),$(window).on("resize",function(){resizetable(),899<$(window).width()&&$("#contact-sidenav").removeClass("sidenav"),$(window).width()<900&&$("#contact-sidenav").addClass("sidenav")}),resizetable(),$(window).width()<900&&($(".sidebar-left.sidebar-fixed").removeClass("animate fadeUp animation-fast"),$(".sidebar-left.sidebar-fixed .sidebar").removeClass("animate fadeUp"));

	$(function() {
		$("#bt_menu, #bt_interesse, #bt_x").click(function(e) {
			el = $(this).data("element");
			$(el).toggle();
		});
	});

	var c = $(".carousel").carousel({
		noWrap: true,
		numVisible: 10,
	});

	setInterval(function() {
		$(".carousel").carousel("next");
	}, 3000);

	if ($('input[name="url"]#url').length) {
		var URL = window.location.href;
		if (URL.split("/").pop() !== "login") document.getElementById("url").value = URL;
	}

	/**
	 * Ação para remoção de lista de arquivos em uma página
	 */
	$(".remover_arquivo").on("click", function(e) {
		e.preventDefault();
		var self = $(this);
		Http.delete($(this).data("url"), function(response) {

			var len = self.parents("ul").find("li").length;
			self.parents("#file_" + self.attr("id")).remove();
			$(".count-files").html(len - 1);
			if ($('body').find('#album').length) {
				$('#album').masonry({
					'itemSelector': '.col'
				});
			}

		});
	});

	/**
	 * Ação para verificação do Log de importação na página [/imports]
	 */
	$("form#import-files").on("submit", function() {
		var self = $(this);
		if (self.is(":valid")) {
			setTimeout(function() {
				self.find("*").attr("disabled", true);
			}, 200);
			Http.post(BASE_URL + "api/log", {
				data: {
					arquivo: $('select[name="arquivo"]').val(),
				},
			}, (response) => {
				// console.log(response);
			});
			checkLogs = setInterval(checkLog, 200);
		}
	});

	// clearInterval(checkLogs);
	// checkLogs = setInterval(checkLog, 200);

	$("#log").find("button#log-rotate").on("click", function() {
		if ($(this).hasClass("play")) {
			checkLogs = setInterval(checkLog, 200);
			$(this).removeClass("play").addClass("pause").find("i").html("pause");
		} else if ($(this).hasClass("pause")) {
			clearInterval(checkLogs);
			$(this).removeClass("pause").addClass("play").find("i").html("play_arrow");
		}
	});

	/**
	 * check system updates
	 */
	// 	$.ajax({
	// 		'url': 'api/updates',
	// 		'success': (response) => {
	// 			if (response.updates) Form.showMessage('Existem atualizações pendentes');
	// 		}
	// 	});

	/**
	 * Selecionar opções de traduções
	 */
	$('.languages').each(function() {

		$(this).on('click', function(e) {

			e.preventDefault();
			var idioma = $(this).attr('id');

			setCookie('idioma', idioma, 365);
			translate($(this).attr('data-url'), idioma);

		});

	});

	$.fn.extend({
		toggleText: function(a, b) {
			return this.text(this.text() == b ? a : b);
		}
	});

	$('#change-mode').on('click', function() {

		var mode = $(this).hasClass('grid') ? 'list' : 'grid';

		$(this).toggleClass(mode);

		$('.grid-view').each(function() {
			if (mode == 'list') {
				$(this).toggleClass('grid-view');
				$(this).toggleClass('l4');
				$(this).toggleClass('l12');
			} else if (mode == 'grid') {
				$(this).toggleClass('l4');
				$(this).toggleClass('l12');
				$(this).toggleClass('list-view');
			}
		});

		if (mode == 'list') {
			$(this).removeClass('list').addClass('grid');
			$(this).find('i').toggleText('list', 'grid_view')
		} else {
			$(this).removeClass('grid').addClass('list');
			$(this).find('i').toggleText('grid_view', 'list')
		}

	});


	$('.change-photo').each(function() {

		$(this).on('click', function() {

			$(this).find('[type="file"]').on('change', function() {

				var self = $(this);
				var $len = self.parent().find('[type="file"]').length;

				if (typeof id === 'undefined')
					var id = $(this).attr('id');
				else
					var id = 'file' + id;

				if ($('#' + id).is(':visible')) {

					for (var i = 0; i < document.getElementById(id).files.length; i++) {

						src = window.URL.createObjectURL(document.querySelector('#' + id).files[i]);

						var div = $('<div/>', {
							'class': 'miniaturas',
						});

						var img = $('<img/>', {
							'src': src,
							'class': '',
						});

						// $(this).parents('#foto').find('#preview').find('img').remove();
						$(this).parents('.foto').find('.preview').html(img);

					}

				}

			})

		});

	});

	var search = $('[data-search]');

	search.bind('keyup paste', function() {
		$('.progress').show();
	});

	search.bind('keyup paste', delay(function() {

		var query = $(this).val();
		var url = BASE_URL + $(this).data('search');

		Http.get(url, {
			'datatype': 'html',
			data: {
				'query': query
			}
		}, (response) => {
			$('#index').hide();
			$('#results').show().html(response);
			$('.progress').hide();
			core();
		});

	}, 500));

}
