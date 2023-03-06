function html(content) {

	var parser = new DOMParser();
	var content = parser.parseFromString(content.response, 'text/html');

	return content;

}

function view(content, data = null) {

	var response = html(content);
	var url = content.responseURL;

	if (content.status === 200) {

		var title = response.querySelector('title');

		if (title)
			document.title = title.innerHTML;

		if ($(response).find('#page').length) {
			$('#page').html($(response).find('#page').html());
		} else {
			$('#main').html($(response).find('html').html());
		}

		if (url !== window.location.href)
			window.history.pushState('', '', url);

	}

}
