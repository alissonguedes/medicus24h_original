'use strict';

var loader = (id, action, timeout = 100) => {

	var timeFade = 100;

	if (action === 'undefined' || action === 'out') {

		setTimeout(function() {
			id.animate({
				'opacity': '0',
				'visibility': 'hidden',
				'display': 'none'
			}, timeFade, () => {
				id.hide();
			});
		}, timeout);

	} else {

		id.show();
		id.animate({
			'opacity': '1',
			'visibility': 'visible',
			'display': 'flex'
		}, timeFade, () => {
			id.show();
		});

	}

}

var progress = (action, type = null, timeout = 100) => {

	var timeFade = 100;

	switch (type) {
		case null:
		default:
			loader($('.progress, #loading'), action, timeout);
			break;
		case true:
		case 'bar':
			loader($('.progress'), action, timeout);
			break;
		case false:
		case 'block':
			loader($('#loading'), action, timeout);
			break;
	}

}

var loading = (action, timeout = 100) => {

	loader($('#loading'), action, timeout);

}
