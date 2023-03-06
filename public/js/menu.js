'use strict';

var sidenavMain = $('.sidenav-main');
var navCollapsible = $('.navbar .nav-collapsible');

var Menu = {

	constructor: (element) => {

		let url = [];
		let local = window.location.href.split(BASE_URL).splice(1);

		if (local.length > 0 && typeof local[0].split(/\W+/) !== 'undefined' && local[0].split(/\W+/).length > 1) {
			local = local[0].split(/\W+/).splice(0, 1);
		}

		if (typeof local[0] !== 'undefined') {

			var link = local[0].split('/');
			var $default = link === window.location.href ? 'default' : 'pointer';

			if ($('aside').hasClass('nav-expanded')) {

				$('#slide-out').removeClass('active').find('.active').removeClass('active');

				for (var i in link) {
					url.push(link[i]);

					if ($('#slide-out li').find('a[href="' + BASE_URL + url.join('/') + '"]').length == 1) {
						$('#slide-out li')
							.find('a[href="' + BASE_URL + url.join('/') + '"]')
							.addClass('active')
							.css('cursor', $default)
							.parents()
							.addClass('active').show();
						break;
					} else {

						$('#slide-out li').find('a').first().addClass('active').parents().addClass('active').show();
						break;

					}

				}

			} else {

				// var a = $('#slide-out li').find('a[href="' + BASE_URL + link.join('/') + '"]')
				// console.log($(a).parents('#slide-out li').find('a:first-child').addClass('active').next('.collapsible-body').removeClass('active').find('a:not([href="' + BASE_URL + link.join('/') + '"])').removeClass('active'));

				// $('#slide-out li').find('a[href="' + BASE_URL + link.join('/') + '"]')
				// 	// .addClass('active')
				// 	// .css('cursor', $default)
				// 	.parents('#slide-out li > a')
				// 	.addClass('active');

			}

		} else {

			$('#slide-out li').find('a').first().addClass('active').parents().addClass('active').show();

		}

		Menu.menuCollapse();

		Menu.init();

	},

	menuCollapse: () => {

		$('body').hasClass('menu-collapse') && 993 < $(window).width() &&
			(
				sidenavMain.removeClass('nav-lock'),
				navCollapsible.removeClass('sideNav-lock'),
				Menu.toggleMenuCollapse(),
				Menu.navigationCollapse()
			)

	},

	toggleMenuCollapse: () => {

		sidenavMain.hasClass('nav-expanded') &&
			!sidenavMain.hasClass('nav-lock') &&
			sidenavMain.toggleClass('nav-expanded');

		if (!$('body, .horizontal-layout, #main').hasClass('main-full')) {
			$('.horizontal-layout, #main').addClass('main-full')
		} else {
			$('.horizontal-layout, #main').removeClass('main-full')
		}
	},

	navigationCollapse: () => {

		if (!$('.sidenav-main.nav-collapsible').hasClass('nav-lock')) {

			var n = $('.collapsible .open').children().length;

			$('.sidenav-main.nav-collapsible, .navbar .nav-collapsible')
				.addClass('nav-collapsed')
				.removeClass('nav-expanded');

			$('#slide-out > li.open > a').parent()
				.addClass('close')
				.removeClass('open');

			setTimeout(function() {
				if (1 < n) {
					var e = $('.sidenav-main .collapsible');
					M.Collapsible.getInstance(e).close(
						$('.collapsible .close').index()
					)
				}
			}, 100);
		}

	},

	init: () => {

		var t;
		var i = $('li.active .collapsible-sub .collapsible');
		var s = document.querySelectorAll('.sidenav-main .collapsible');
		var a = document.querySelectorAll('.collapsible');
		var l = document.querySelector('.collapsible.expandeble');

		M.Collapsible.init(a);

		M.Collapsible.init(l, {
			accordion: !1
		});

		var menuInit = M.Collapsible.init(s, {
			accordion: true,
			onOpenStart: () => {
				$('.collapsible > li.open').removeClass('open');
				setTimeout(function() {
					$('#slide-out > li.active > a')
						.parent()
						.addClass('open');
				})
			}
		});

		$(".sidenav-main.nav-collapsible, .navbar .brand-sidebar").mouseleave(function() {
			Menu.navigationCollapse()
		})

		if (menuInit && $('body').hasClass('menu-collapse')) {

			var d = $('.sidenav-main .collapsible');

			1 < $('#slide-out > li.active').children().length && $('#slide-out > li.active > a').parent().addClass('close');

			M.Collapsible.getInstance(d).close($('.collapsible .close').index());


		} else {

			1 < $('#slide-out > li.active').children().length && $('#slide-out > li.active').parent().addClass('open');

			if (
				0 < i.find('a.active').length && (i.find('a.active').closest('div.collapsible-body').show(), i.find('a.active').closest('div.collapsible-body').closest('li').addClass('active')),
				t = 0 < $('.sidenav-main li a.active').parent('li.active')
				.parent('ul.collapsible-sub').length ?
				$('.sidenav-main li a.active').parent('li.active').parent('ul.collapsible-sub').position() :
				$('.sidenav-main li a.active').parent('li.active').position(),
				setTimeout(function() {
					void 0 !== t && $('.sidenav-main ul').stop().animate({
						scrollTop: t.top - 300
					}, 300)
				}, 300),
				$(".nav-collapsible .navbar-toggler").click(function() {
					var value;
					Menu.toggleMenuCollapse();

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

					var data = {
						'method': 'patch',
						'data': {
							'config': 'main-menu-type',
							'value': value
						}
					};

					Http.post(BASE_URL + 'config', data, (response) => {

						M.toast({
							html: response.message,
						});

					});

				})
			) {

			}

		}

	}

}
