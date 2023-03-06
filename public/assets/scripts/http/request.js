'use strict';

var links = '[href], [data-href], .link';

var Request = {

	addEvent: (link) => {

		$("[data-action]").on("click", function(e) {
			var action = $(this).data("action");
			if (action === "back") window.history.back();
			else if (action === "next") window.history.forward();
		});

		var ln = typeof link === 'undefined' ? links : link;

		$('body').find(ln).on('click', function(e) {

			var icon = $(this).find('.material-icons-outlined,.material-icons');
			var icon = typeof icon !== 'undefined' && icon != '' ? icon.text() : null;
			var link = $(this).data('href') || $(this).attr('href');
			var target = $(this).attr('target') || false;

			e.preventDefault();
			Form.__button__(icon, true, $(this));

			if (Request.isLink(link) && !target) {

				if (link !== window.location.href) {
					$('.progress').show();
					Http.goTo(link);
				}

			} else {

				if (target) {
					if (target == '_self')
						window.location.href = link;
					else if (target == '_top')
						return null;
					else
						window.open(link, target);
				}
			}

			Form.__button__(icon, false, $(this));

		});

	},

	refreshUrl: (url) => {

		if (BASE_URL + url !== window.location.href)
			window.history.pushState('', '', url);

	},

	isLink: (href) => {

		if (typeof href === 'undefined') return false;

		var URL = typeof href.split(BASE_URL)[1] === 'undefined' ? href : href.split(BASE_URL)[1];
		var isAnchor = /^[jJ]ava[sS]cript(\:[a-z]+)?/i.test(URL);
		var isNotLink = /^#([a-z0-9]+)?/i.test(URL);

		return href !== '' && !isAnchor && !isNotLink && typeof URL !== 'undefined';

	},

	// Alterado para expandir o menu a partir de qualquer link no sistema.
	menu: () => {

		var url = [];
		var local = window.location.href.split(BASE_URL).splice(1);

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

					if ($('#slide-out li').find('a[href="' + BASE_URL + url.join('/') + '"').length == 1) {

						$('#slide-out li').find('a[href="' + BASE_URL + url.join('/') + '"').addClass('active').css('cursor', $default).parents().addClass('active').show();
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


	}

}
