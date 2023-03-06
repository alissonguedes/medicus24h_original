'use strict';

var Materialize = {

	constructor: () => {

		$(".dropdown-trigger").each(function() {

			var content = $(this).data('target');

			if ($('#' + content).length) {
				$(this).dropdown({
					inDuration: 300,
					outDuration: 225,
					constrainWidth: !(typeof $(this).data('constrain-width') !== 'undefined' && $(this).data('constrain-width') === true),
					coverTrigger: !(typeof $(this).data('cover-trigger') !== 'undefined' && $(this).data('cover-trigger') === true),
					alignment: typeof $(this).data('align') !== 'unedfined' && $(this).data('align') != '' ? $(this).data('align') : 'left',
					hover: (typeof $(this).data('hover') !== 'undefined' && $(this).data('hover') === true),
					closeOnClick: !(typeof $(this).data('autoclose') !== 'undefined' && $(this).data('autoclose') === false)
				});
			} else {
				$('.material-icons.arrow-down').hide();
			}

		});

		Materialize.tooltip();
		Materialize.tabs();
		Materialize.modal();
		Materialize.select();
		Materialize.btn_modal();
		Materialize.datepicker();
		Materialize.timepicker();

		// Resetar valores dos campos de textos
		Materialize.inputs();

		$('.slider').slider();

	},

	filters: () => {

		$('#dropdown-registros').find('a').each(function() {

			var url = $(this).data('url');

			$(this).parents('#dropdown-registros').find('.active').removeClass('active');
			$(this).parents('#dropdown-registros').find('a[data-url="' + window.location.href + '"]').addClass('active');

			$(this).on('click', function(e) {

				e.preventDefault();
				progress('in', 'bar');

				$(this).parents('#dropdown-registros').find('.active').removeClass('active');
				$(this).addClass('active');

				var search = $('input[id="search-on-page"');

				var query = search.val();

				var params = {
					datatype: 'html',
					data: {
						'query': query,
					}
				}

				Http.get(url, params, (response) => {

					var parse = new DOMParser();
					var total;

					total = parse.parseFromString(response, 'text/html');
					total = $(total).find('#total_results').val();

					$('#results').html(response);
					$('#total-results').find('span').text(total + ' registro' + (total > 1 ? 's' : ''));

					Materialize.constructor();
					Request.constructor($('#results'));
					btn_form_sidenav();
					Scroller.toTop();

					progress('out', 'bar');

					window.history.pushState('', '', url);

				});

			})

		});
	},

	// Resetar valores dos campos de textos
	inputs: () => {
		$('.input-field').each(function() {

			var field = $(this).find('input,textarea,select');

			if (field.val() != '') {
				$(this).find('label').addClass('active');
			}

		});
	},

	tooltip: () => {

		$('[data-tooltip]').tooltip({
			transitionMovement: 10
		});

	},

	tabs: () => {

		$('.tabs').tabs({
			swipeable: false,
			onShow: () => {
				Scroller.toTop();
			}
		});

	},

	datepicker: () => {

		$('body').find('.datepicker, [data-mask="date"]').each(function() {

			var date = new Date();
			// var curDate = date.getDate();
			// var curMonth = (date.getMonth() < 10 ? '0' : null) + (date.getMonth() + 1);
			var curYear = date.getFullYear();

			var defaultDate = $(this).val() != '' ? $(this).val().split('/') : null;
			var minDate = $(this).data('min-date') ? $(this).data('min-date').split('/') : null;
			var maxDate = $(this).data('max-date') ? $(this).data('max-date').split('/') : null;
			var yearRange = minDate ? [minDate[2], curYear + 100] : maxDate ? [1900, curYear - 0] : [curYear - 100, curYear + 100];

			minDate = minDate ? new Date(minDate[2], minDate[1] - 1, minDate[0]) : null;
			maxDate = maxDate ? new Date(maxDate[2], maxDate[1] - 1, maxDate[0]) : null;
			defaultDate = defaultDate ? new Date(defaultDate[2], defaultDate[1] - 1, defaultDate[0]) : null;

			$(this).datepicker({
				format: $(this).data('format') || 'dd/mm/yyyy',
				startView: 1,
				autoClose: true,
				setDefaultDate: true,
				showClearBtn: false,
				defaultDate: defaultDate,
				isRTL: false,
				minDate: minDate,
				maxDate: maxDate,
				yearRange: yearRange,
				i18n: {
					months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
					monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
					weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
					weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
					weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
					cancel: 'Cancelar'
				},
				onDraw: function() {
					// var dropdown = $(".datepicker-container").find(".select-dropdown");
					// dropdown.dropdown('destroy');
					// dropdown.dropdown({
					// 	alignment: 'right'
					// });
				}
			});

		});

		// $('.input-field:not(.browser-default) select').on('change', function() {
		// 	$(this).parents('.select-wrapper').find(':input:text').addClass('selected');
		// }).formSelect({
		// 	isMultiple: true
		// });

	},

	timepicker: () => {

		$('.timepicker, [data-mask="time"]').each(function() {

			$(this).timepicker({
				'twelveHour': false
			});

		});

	},

	select: () => {

		$('select:not(.autocomplete)').each(function() {

			$(this).formSelect();

		});

		$('select[data-url].autocomplete').each(function() {
			autocomplete($(this));
		});

	},

	btn_modal: (button) => {

		var form;
		var button = button ? $(button) : $('[data-trigger="modal"]');

		button.on('click', function(e) {

			e.preventDefault();

			var url = $(this).data('url');
			var modal = $(this).data('target');

			var modal = Materialize.modal('#' + modal, url);

			modal = M.Modal.getInstance(modal);
			modal = modal.open();

		})

	},

	modal: (modal, url) => {

		var form;

		if (typeof modal === 'string') {

			var $modal = $(modal);
			var dismissible = $(modal).data('dismissible') || true;

			var modal = $modal.modal({

				dimissible: dismissible,
				onOpenStart: () => {

					var load = `<div class="preloader-wrapper small active" style="margin-right: 20px;">
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
						Carregando o formulário. Por favor, aguarde!`;

					var texto = $('<div>', {
						'style': 'display: flex; align-items: center; place-content: center; position: absolute; top: 50%; left: 0; bottom: 50%; right: 0; margin-top: -25px; margin-bottom: -25px; text-align: center;'
					});

					// $modal.find('.modal-content').html($(texto).html(load));
					$modal.find('form').html($(texto).html(load));

					var data = {
						datatype: 'html',
						'data': {}
					}

					Http.get(url, data, (response) => {
						// console.log(response);
						form = $(response).find('form').html();
						$modal.find('form').html(form);

						Materialize.tooltip();
						Materialize.tabs();
						Materialize.select();
						Materialize.modal($modal.find('.modal'));
						Scroller.constructor($modal);

					});

				},

			});

		} else {


			var $modal = typeof modal !== 'undefined' ? modal : $('.modal');

			var modal = $modal.modal({
				dismissible: $modal.data('dismissible')
			});

		}

		return modal;

	},

	m: () => {
		var sidenavMain = $(".sidenav-main"),
			contentOverlay = $(".content-overlay"),
			navCollapsible = $(".navbar .nav-collapsible"),
			breadcrumbsWrapper = $("#breadcrumbs-wrapper");

		function defaultMenuCollapse() {
			$("body").hasClass("menu-collapse") && 993 < $(window).width() &&
				(
					sidenavMain.removeClass("nav-lock"),
					// $(".nav-collapsible .navbar-toggler i").text("radio_button_unchecked"),
					navCollapsible.removeClass("sideNav-lock"),
					toogleMenuCollapse(),
					navigationCollapse()
				)
		}

		function toogleMenuCollapse() {
			sidenavMain.hasClass("nav-expanded") &&
				!sidenavMain.hasClass("nav-lock") &&
				sidenavMain.toggleClass("nav-expanded"),
				$(".horizontal-layout, #main").toggleClass("main-full");

			// Alterar no banco de dados a exibição de menu para o usuário
			// $.ajax({
			//     'type': 'post',
			//     'url': BASE_URL + 'ajax',
			//     'dataType': 'json',
			//     'success': (data) => {
			//         console.log(data);
			//     }
			// })

		}

		function navigationCollapse() {

			if (!$(".sidenav-main.nav-collapsible").hasClass("nav-lock")) {
				var n = $(".collapsible .open").children().length;
				$(".sidenav-main.nav-collapsible, .navbar .nav-collapsible")
					.addClass("nav-collapsed")
					.removeClass("nav-expanded"),

					$("#slide-out > li.open > a").parent().addClass("close").removeClass("open"),
					setTimeout(function() {
						if (1 < n) {
							var e = $(".sidenav-main .collapsible");
							M.Collapsible.getInstance(e).close(
								$(".collapsible .close").index()
							)
						}
					}, 100)
			}
		}

		function slideOutChat() {
			var e = $(".search").val();
			if ("" != e) {
				var n = '<li class="collection-item display-flex avatar justify-content-end \
                    pl-5 pb-0" data-target="slide-out-chat"> \
                    <div class="user-content speech-bubble-right"> \
                        <p class="medium-small">' + e + '</p> \
                    </div> \
                </li>';
				$("#right-sidebar-nav #slide-out-chat .chat-body .collection").append(n),
					$(".search").val("");
				var a = $("#right-sidebar-nav #slide-out-chat .chat-body .collection");
				0 < a.length && (a[0].scrollTop = a[0].scrollHeight)
			}
		}

		$(window).on("load", function() {
			$("body").removeClass("preload-transitions")
		});


		$("[data-tooltip]").tooltip({
			transitionMovement: 10
		});

		$('[data-count="true"]').each(function() {
			var maxlength = $(this).attr('maxlength');
			$(this).attr('data-length', maxlength).characterCounter();
		});

		defaultMenuCollapse(),
			$(function() {
				"use strict";

				function e() {
					var e = " -webkit- -moz- -o- -ms- ".split(" "),
						n = function(e) {
							return window.matchMedia(e).matches
						};
					return !!("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch) || n(["(", e.join("touch-enabled),("), "heartz", ")"].join(""))
				}

				$(".tabs").tabs({
						swipeable: false
					}),
					$(".datepicker").datepicker({
						autoClose: !0,
						format: "dd/mm/yyyy",
						container: "body",
						onDraw: function() {
							$(".datepicker-container").find(".datepicker-select").addClass("browser-default"),
								$(".datepicker-container .select-dropdown.dropdown-trigger").remove()
						}
					}),
					$("#tabs-swipe-demo").length && $("#tabs-swipe-demo").tabs({
						swipeable: !0
					});

				$('.input-field:not(.browser-default) select').on('change', function() {
					$(this).parents('.select-wrapper').find(':input:text').addClass('selected');
				}).formSelect({
					isMultiple: true
				});

				$('.chips').each(function() {

					var self = $(this);
					var tags = self.data('tags');

					var chips = self.chips({
						'data': tags,
						'placeholder': self.attr('placeholder'),
						'secondaryPlaceholder': '+Tag',
						'limit': 10,
						'onChipAdd': function() {
							var tag = $(this)[0].chipsData
							var tags = [];
							for (var i = 0; i < tag.length; i++) {
								tags.push(tag[i].tag);
							}
							$('[name="' + chips.find('input').attr('id') + '"]').val(tags.toString());
						},
						'onChipDelete': function() {
							var tag = $(this)[0].chipsData
							var tags = [];
							for (var i = 0; i < tag.length; i++) {
								tags.push(tag[i].tag);
							}
							$('[name="' + chips.find('input').attr('id') + '"]').val(tags.toString());
						}
					});

				});

				var n = document.getElementById("indeterminate-checkbox");

				var slideInterval = 6000;

				var slider = $(".slider").slider({
					height: '600px',
					duration: 500,
					interval: slideInterval
				});

				null !== n && (n.indeterminate = !0),
					$(".dropdown-trigger").dropdown(),
					$(".dropdown-button").dropdown({
						inDuration: 300,
						outDuration: 225,
						constrainWidth: !1,
						hover: !0,
						gutter: 0,
						coverTrigger: !0,
						alignment: "left"
					}),
					$(".notification-button, .profile-button, .btn-dropdown, .translation-button, .dropdown-settings").dropdown({
						inDuration: 300,
						outDuration: 225,
						constrainWidth: !1,
						hover: !1,
						gutter: 0,
						coverTrigger: !1,
						alignment: "right",
						hover: !1,
						closeOnClick: !0
					}),
					$(".dropdown-menu").dropdown({
						inDuration: 300,
						outDuration: 225,
						constrainWidth: !1,
						hover: !1,
						gutter: 0,
						coverTrigger: !1,
						alignment: "right",
						hover: !1,
						closeOnClick: !1
					}),
					$(".dropdownSub-menu").dropdown({
						closeOnClick: !1,
						constrainWidth: !1,
						alignment: "left",
						inDuration: 300,
						outDuration: 225,
						gutter: 0,
						coverTrigger: !0,
						hover: !0
					}),
					$(".dropdown-submenu").on("mouseenter", function() {
						var e = $(this);
						$(this).find(".dropdownSub-menu").dropdown("open");
						var n = e.find(".dropdown-content");
						if (n) {
							var a = n.offset().left,
								l = n.width();
							0 < $("html[data-textdirection='rtl']").length ? l <= a ? e.find(".dropdown-content").removeClass("right-open").addClass("left-open") :
								e.find(".dropdown-content").removeClass("left-open").addClass("right-open") :
								window.innerWidth - (a + l) <= l ? e.find(".dropdown-content").removeClass("left-open").addClass("right-open") :
								e.find(".dropdown-content").removeClass("right-open").addClass("left-open")
						}
					}),
					$(".dropdown-submenu").on("mouseleave", function() {
						var e = $(this);
						e.find(".dropdownSub-menu").dropdown("close"),
							e.find(".dropdown-content").removeClass("right-open"),
							e.find(".dropdown-content").removeClass("left-open")
					}),
					$(".fixed-action-btn").floatingActionButton(),
					$(".fixed-action-btn.horizontal").floatingActionButton({
						direction: "left"
					}),
					$(".fixed-action-btn.click-to-toggle").floatingActionButton({
						direction: "left",
						hoverEnabled: !1
					}),
					$(".fixed-action-btn.toolbar").floatingActionButton({
						toolbarEnabled: !0
					}),
					$(".tab-demo").show().tabs(),
					$(".tab-demo-active").show().tabs(),
					$(".scrollspy").scrollSpy(),
					$(".tooltipped").tooltip({
						delay: 50
					});

				var a = document.querySelectorAll(".collapsible");

				M.Collapsible.init(a);

				var l = document.querySelector(".collapsible.expandable");

				M.Collapsible.init(l, {
					accordion: !1
				});

				if (breadcrumbsWrapper.attr("data-image")) {
					var o = breadcrumbsWrapper.attr("data-image");
					breadcrumbsWrapper.addClass("breadcrumbs-bg-image"),
						breadcrumbsWrapper.css("background-image", "url(" + o + ")")
				}

				var t,
					i = $("li.active .collapsible-sub .collapsible"),
					s = document.querySelectorAll(".sidenav-main .collapsible");

				if (
					M.Collapsible.init(s, {
						accordion: !0,
						onOpenStart: function() {
							$(".collapsible > li.open").removeClass("open"),
								setTimeout(function() {
									$("#slide-out > li.active > a").parent().addClass("open")
								}, 10)
						}
					}),
					$("body").hasClass("menu-collapse")
				) {
					var d = $(".sidenav-main .collapsible");
					1 < $("#slide-out > li.active").children().length &&
						$("#slide-out > li.active > a").parent().addClass("close"),
						M.Collapsible.getInstance(d).close($(".collapsible .close").index())
				} else
					1 < $("#slide-out > li.active").children().length &&
					$("#slide-out > li.active > a").parent().addClass("open");
				if (0 < i.find("a.active").length &&
					(i.find("a.active").closest("div.collapsible-body").show(),
						i.find("a.active").closest("div.collapsible-body").closest("li")
						.addClass("active")),
					t = 0 < $(".sidenav-main li a.active").parent("li.active")
					.parent("ul.collapsible-sub").length ?
					$(".sidenav-main li a.active").parent("li.active")
					.parent("ul.collapsible-sub").position() :
					$(".sidenav-main li a.active").parent("li.active").position(),
					setTimeout(function() {
						void 0 !== t && $(".sidenav-main ul").stop().animate({
							scrollTop: t.top - 300
						}, 300)
					}, 300),
					$(".nav-collapsible .navbar-toggler").click(function() {
						var value;
						toogleMenuCollapse(),

							$(this).parents('.nav-collapsible').removeClass('nav-expanded nav-collapsed').hasClass('nav-lock') ?
							(

								value = 'collapsed',
								$(this).parents('.nav-collapsible').removeClass('nav-lock'),
								$('.sidenav-main .show-buttons').find('button').addClass('btn-floating').find('.material-icons').removeClass('left'),
								$('.sidenav-main .show-buttons .btn-floating').find('span').text('')

							) :
							(

								value = 'expanded',
								$(this).parents('.nav-collapsible').addClass('nav-lock'),
								$('.sidenav-main .show-buttons .btn-floating').find('span').text('Menu'),
								$('.sidenav-main .show-buttons').find('button').removeClass('btn-floating').find('.material-icons').addClass('left')

							);

						M.Toast.dismissAll();

						// Http.post(BASE_URL + 'config', {
						// 	'method': 'patch',
						// 	'data': {
						// 		'config': 'main-menu-type',
						// 		'value': value
						// 	}
						// }, (response) => {

						// 	M.toast({
						// 		html: response.message,
						// 	});

						// });

					}),

					$(".sidenav-main.nav-collapsible, .navbar .brand-sidebar").mouseenter(function() {
						$(".sidenav-main.nav-collapsible").hasClass("nav-lock") ||
							($(".sidenav-main.nav-collapsible, .navbar .nav-collapsible")
								.addClass("nav-expanded").removeClass("nav-collapsed"),
								$("#slide-out > li.close > a").parent()
								.addClass("open").removeClass("close"),
								setTimeout(function() {
									if (1 < $(".collapsible .open").children().length) {
										var e = $(".sidenav-main .collapsible");
										M.Collapsible.getInstance(e).open($(".collapsible .open").index())
									}
								}, 100)
							)
					}),
					// Ocultar a barra de menus após clicar quando estiver em modo responsivo
					$('#slide-out').find('li a').on('click', function() {

						if (window.innerWidth < 993)
							if (Request.isLink($(this).attr('href'))) {
								$('.sidenav').sidenav('close')
							}

					}),
					$(".sidenav-main.nav-collapsible, .navbar .brand-sidebar").mouseleave(function() {
						navigationCollapse()
					}),
					// $('.sidenav#agendamento').on('click', function() {
					// 	$("#sidenav-overlay").trigger("click");
					// 	return false;
					// }),
					$(".sidenav").sidenav({
						edge: "left"
					}),
					$(".slide-out-right-sidenav").sidenav({
						edge: "right"
					}),
					$(".slide-out-right-sidenav-chat").sidenav({
						edge: "right"
					}),
					e()
				)
					$(".leftside-navigation,.slide-out-right-body, .chat-body .collection, #ul-horizontal-nav").css("overflow", "scroll");
				else {
					if (0 < $("#slide-out.leftside-navigation").length && !$("#slide-out.leftside-navigation").hasClass("native-scroll"))
						new PerfectScrollbar(".leftside-navigation", {
							wheelSpeed: 2,
							wheelPropagation: !1,
							minScrollbarLength: 20
						});
					if (0 < $(".slide-out-right-body").length)
						new PerfectScrollbar(".slide-out-right-body, .chat-body .collection", {
							suppressScrollX: !0,
							wheelPropagation: !1
						});
					if (0 < $(".chat-body .collection").length)
						new PerfectScrollbar(".chat-body .collection", {
							suppressScrollX: !0
						});
					if (0 < $("#ul-horizontal-nav").length)
						var c = new PerfectScrollbar("#ul-horizontal-nav", {
							wheelPropagation: !1
						});
					$("#ul-horizontal-nav").on("mouseenter", function() {
						c.update()
					})
				}
				// $("#messages .header-search-input").on("keyup", function() {
				//     $(".chat-user").css("animation", "none");
				//     var e = $(this).val().toLowerCase();
				//     "" != e ? $(".right-sidebar-chat .right-sidebar-chat-item").filter(function() {
				//             $(this).toggle(-1 < $(this).text().toLowerCase().indexOf(e))
				//         }) :
				//         $(".right-sidebar-chat .right-sidebar-chat-item").show()
				// });
				var r = $("#right-sidebar-nav #slide-out-chat .chat-body .collection");

				function e() {
					try {
						return document.createEvent("TouchEvent"), !0
					} catch (e) {
						return !1
					}
				}
				0 < r.length && (r[0].scrollTop = r[0].scrollHeight),
					$(".toggle-fullscreen").click(function() {
						document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ?
							document.documentElement.requestFullScreen ?
							document.documentElement.requestFullScreen() :
							document.documentElement.mozRequestFullScreen ?
							document.documentElement.mozRequestFullScreen() :
							document.documentElement.webkitRequestFullScreen ?
							document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) :
							document.documentElement.msRequestFullscreen && (document.msFullscreenElement ?
								document.msExitFullscreen() :
								document.documentElement.msRequestFullscreen()) :
							document.cancelFullScreen ?
							document.cancelFullScreen() :
							document.mozCancelFullScreen ?
							document.mozCancelFullScreen() :
							document.webkitCancelFullScreen && document.webkitCancelFullScreen()
					}),
					e() && $("#nav-mobile").css({
						overflow: "auto"
					});
				$(".dropdown-language .dropdown-item").on("click", function(event) {
						var e = $(this);
						e.siblings(".selected").removeClass("selected"), e.addClass("selected");
						var n = e.find(".flag-icon").attr("class");
						$(".translation-button .flag-icon").removeClass().addClass(n);

						var a = e.find("a,button");

						event.preventDefault();
						var idioma = a.data('language');
						console.log(idioma)
						setCookie('idioma', idioma, 365);
						translate(a.data('url'), idioma);
					}),
					0 < $("#ul-horizontal-nav li.active").length && $("#ul-horizontal-nav li.active").closest("ul").parents("li").addClass("active"),
					0 < $("html[data-textdirection='rtl']").length && ($(".sidenav").sidenav({
							edge: "right"
						}),
						$(".slide-out-right-sidenav").sidenav({
							edge: "left"
						}),
						$(".slide-out-right-sidenav-chat").sidenav({
							edge: "left"
						}))
			}),
			$(window).on("resize", function() {

				$(window).width() < 994 ? sidenavMain.hasClass("nav-collapsed") &&
					(sidenavMain.removeClass("nav-collapsed").addClass("nav-lock nav-expanded"),
						navCollapsible.removeClass("nav-collapsed").addClass("sideNav-lock")) :
					993 < $(window).width() && $("body").hasClass("menu-collapse") &&
					sidenavMain.hasClass("nav-lock") &&
					(sidenavMain.removeClass("nav-lock nav-expanded").addClass("nav-collapsed"),
						navCollapsible.removeClass("sideNav-lock").addClass("nav-collapsed"))
			});

		var searchListLi = $(".search-list li"),
			searchList = $(".search-list"),
			searchSm = $(".search-sm"),
			searchBoxSm = $(".search-input-sm .search-box-sm"),
			searchListSm = $(".search-list-sm");

		$(function() {
				"use strict";
				if ($(".header-search-input").focus(function() {
						$(this).parent("div").addClass("header-search-wrapper-focus")
					}).blur(function() {
						$(this).parent("div").removeClass("header-search-wrapper-focus")
					}), $(".search-button").click(function(e) {
						searchSm.is(":hidden") ? (searchSm.show(), searchBoxSm.focus()) : (searchSm.hide(), searchBoxSm.val(""))
					}), $(".search-input-sm").on("click", function() {
						searchBoxSm.focus()
					}), $(".search-sm-close").click(function(e) {
						searchSm.hide(), searchBoxSm.val("")
					}),
					0 < $(".search-list").length)
					var e = new PerfectScrollbar(".search-list", {
						wheelSpeed: 2,
						wheelPropagation: !1,
						minScrollbarLength: 20
					});

				if (0 < searchListSm.length)
					var s = new PerfectScrollbar(".search-list-sm", {
						wheelSpeed: 2,
						wheelPropagation: !1,
						minScrollbarLength: 20
					});

				var a = $(".header-search-wrapper .header-search-input,.search-input-sm .search-box-sm").data("search");

				$(".search-sm-close").on("click", function() {
						searchBoxSm.val(""),
							searchBoxSm.blur(),
							searchListLi.remove(),
							searchList.addClass("display-none"),
							contentOverlay.hasClass("show") && contentOverlay.removeClass("show")
					}),
					contentOverlay.on("click", function() {
						searchListLi.remove(),
							contentOverlay.removeClass("show"),
							searchSm.hide(),
							searchBoxSm.val(""),
							searchList.addClass("display-none"),
							$(".search-input-sm .search-box-sm, .header-search-input").val("")
					})

				$("#navbarForm").on("submit", function(e) {
						e.preventDefault()
					}),
					$(window).on("keydown", function(e) {
						var s, a, r = $(".search-list li.current_item");
						if (40 === e.keyCode ? (
								s = r.next(),
								r.removeClass("current_item"),
								r = s.addClass("current_item")) :
							38 === e.keyCode && (
								a = r.prev(),
								r.removeClass("current_item"),
								r = a.addClass("current_item")),
							13 === e.keyCode && 0 < $(".search-list li.current_item").length
						) {
							var t = $("li.current_item a");
							window.location = $("li.current_item a").attr("href"), $(t).trigger("click")
						}
					}),
					searchList.mouseenter(function() {
						0 < $(".search-list").length && e.update(),
							0 < searchListSm.length && s.update()
					}),
					$(document).on("mouseenter", ".search-list li", function(e) {
						$(this).siblings().removeClass("current_item"),
							$(this).addClass("current_item")
					}),
					$(document).on("click", ".search-list li", function(e) {
						e.stopPropagation()
					})
			}),
			$(window).on("resize", function() {
				$(window).width() < 992 &&
					(
						$(".header-search-input").val(""),
						$(".header-search-input").closest(".search-list li").remove()
					),
					993 < $(window).width() && (
						searchSm.hide(),
						searchBoxSm.val(""),
						$(".search-input-sm .search-box-sm").val("")
					)
			});

		$(function() {
			$(".popup-gallery").magnificPopup({
				delegate: "a",
				type: "image",
				closeOnContentClick: !0,
				fixedContentPos: !0,
				tLoading: "Loading image #%curr%...",
				mainClass: "mfp-img-mobile mfp-no-margins mfp-with-zoom",
				gallery: {
					enabled: !0,
					navigateByImgClick: !0,
					preload: [0, 1]
				},
				image: {
					verticalFit: !0,
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
					titleSrc: function(e) {
						return e.el.attr("title") + "<small>by Marsel Van Oosten</small>"
					},
					zoom: {
						enabled: !0,
						duration: 300
					}
				}
			});

			$('#album').masonry({
				'itemSelector': '.col'
			});

		});

		// function getData(autocomplete, url, query = null, limit = 10) {

		// 	if (url !== null) {

		// 		var $data = {};

		// 		if (query !== null) var $data = {
		// 			query: query
		// 		};

		// 		Http.get(url, {
		// 			datatype: 'json',
		// 			$data
		// 		}, (response) => {
		// 			autocomplete.updateData(response);
		// 		});

		// 	}

		// }

		// // Create element Autocomplete
		// $('body').find('input.autocomplete').each(function() {

		// 	// $(this).on('focus', function() {

		// 	var autocomplete = $(this);
		// 	var limit = autocomplete.data('limit') || 10;
		// 	var url = autocomplete.data('url') || null;
		// 	var input = null;

		// 	if (autocomplete.length === 0) return;

		// 	autocomplete.autocomplete({
		// 		minLength: 0,
		// 		limit: limit,
		// 		onAutocomplete: (name, value) => {
		// 			input = name;
		// 			autocomplete.parent().find(':hidden[name="' + name + '"]').remove();
		// 			autocomplete.parent().append($('<input>', {
		// 				type: 'hidden',
		// 				name: name,
		// 				value: value
		// 			}));
		// 		}
		// 	});


		// 	autocomplete_instance = M.Autocomplete.getInstance($(this));
		// 	getData(autocomplete_instance, url);
		// 	// $(this).select();

		// 	// })

		// 	$(this).on('keydown', function(e) {
		// 		var url = $(this).data('url') || null;
		// 		var key = e.keyCode;
		// 		var hidden = $(this).parent().find(':hidden[name="' + input + '"]');
		// 		if (key === 8 || key === 46) {
		// 			$(this).val('');
		// 			if (hidden.length)
		// 				hidden.val('');
		// 		} else {
		// 			getData($(this), url);
		// 		}
		// 	});

		// });


	}

}
