function load_scripts() {

	// console.log('Carregando scripts...');
	$.ajax({
		url: BASE_URL + 'api/js',
		datatype: 'json',
		success: (files) => {

			if (!isJSON(files)) return false;

			if (files) {

				var info = '';

				for (var i of files) {

					$.getScript(i.path).done(() => {
						// console.log('Scripts carregados.')
					});

				}

			}

		},
		error: (error, status) => {

			console.log(error, status);

		}
	});
}
