'use strict';

var isJSON = (str) => {

	if (typeof str === 'object') return true;

	if (typeof str === 'string') {

		try {
			return (JSON.parse(str) && !!str);
		} catch {
			return false;
		}

	}

}
