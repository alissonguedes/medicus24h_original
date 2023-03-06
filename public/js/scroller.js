'use strict'

var Scroller = {

	scroller: null,

	constructor: () => {

		var scroll = Scroller.scroller;

		$('.scroller').each(function() {

			var suppressScrollX = (typeof $(this).data('hide-x') !== 'undefined' && $(this).data('hide-x') === true);
			var suppressScrollY = (typeof $(this).data('hide-y') !== 'undefined' && $(this).data('hide-y') === true);
			var wheelPropagation = (typeof $(this).data('propagation') !== 'undefined' && $(this).data('propagation') === true);

			scroll = new PerfectScrollbar(this, {
				theme: "dark",
				wheelSpeed: 1,
				wheelPropagation: wheelPropagation,
				suppressScrollX: suppressScrollX,
				suppressScrollY: suppressScrollY
			});

			scroll.update();

		});

	},

	toTop: (top) => {

		var top = typeof top !== 'undefined' ? top : 0;

		var container = $('.scroller');

		$(container).parent(':not(.sidenav-main)')
			.find(container)
			.stop()
			.animate({
				scrollTop: top
			}, 300);

		window.scrollTo(0, 0)

	}

}
