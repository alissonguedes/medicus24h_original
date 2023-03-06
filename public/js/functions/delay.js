'use strict';

// function delay(callback, ms) {

function delay(func, wait, immediate) {

	// var timer = 0;

	// return function() {

	// 	var context = this,
	// 		args = arguments;

	// 	clearTimeout(timer);

	// 	timer = setTimeout(function() {
	// 		callback.apply(context, args);
	// 	}, ms || 200);

	// }

	var timeout;
	return function(args) {
		const context = this;
		const later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};

		const callnow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callnow) func.apply(context, args);
	}


}
