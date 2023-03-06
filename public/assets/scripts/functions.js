// require('./bootstrap');

/**
 * Função para criar cookies no site
 */
function setCookie(name, value, duration) {

	var d = new Date();
	d.setTime(d.getTime() + (duration * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	var cookie = name + '=' + escape(value) + ((expires) ? '; duration=' + d.toUTCString() + ';path=/' : '');

	document.cookie = cookie;

}

/**
 * Função para verificar o cookie
 */
function getCookie(name) {

	var cookies = document.cookie;
	var prefix = name + '=';
	var begin = cookies.indexOf('; ' + prefix);

	if (begin == -1) {

		begin = cookies.indexOf(prefix);

		if (begin != 0) {
			return null;
		}

	} else {
		begin += 2;
	}

	var end = cookies.indexOf(';', begin);

	if (end == -1) {
		end = cookies.length;
	}

	return unescape(cookies.substring(begin + prefix.length, end));

}

/**
 * Função para deletar um cookie
 */
function deleteCookie(name) {

	if (getCookie(name)) {
		document.cookie = name + '=' + '; expires=Thu, 01-Jan-70 00:00:01 GMT';
	}

}

function translate(url, idioma) {

	$('[data-translate]').html('');

	var idioma = typeof idioma !== 'undefined' ? idioma : $('html').attr('lang');

	console.log(idioma);
	$.ajax({
		url: url,
		type: 'get',
		success: ($response) => {

			var $field = JSON.parse($response);

			if ($field.idioma != $('html').attr('lang'))
				$('html').attr('lang', $field.idioma);

			Http.goTo(window.location.href)

		}

	});


}

// $(function() {

// $('.languages').each(function() {

//     $(this).on('click', function(e) {

//         e.preventDefault();
//         var idioma = $(this).attr('id');

//         setCookie('idioma', idioma, 365);
//         translate($(this).attr('data-url'), idioma);

//     });

// });

// });

// window.onload = () => {

//     translate($('[data-url-lang]').data('url-lang'));

// }













function preview_map() {

	var reg = /[\<]iframe((\s+[\S+]+)+)?[\>](\S.+)?[\<][\/]iframe[\>]/i;

	$('[name="gmaps"]').each(function() {

		if ($(this).val() != '') {
			if (reg.test($(this).val())) {
				$('#preview').attr('disabled', false);
				$('.card-reveal #iframe').html($(this).val());
				$(this).parents('.input-field').removeClass('error').find('.error').remove();
			} else {
				$(this).parents('.input-field').addClass('error').append('<div class="error">O mapa está incorreto</div>');
				$('#preview').attr('disabled', true);
				$('.card-reveal #iframe').empty().html('Não há um mapa para ser carregado.');
			}
		} else {
			$('#preview').attr('disabled', true);
			$(this).parents('.input-field').removeClass('error').find('.error').remove();
		}

		$(this).on('keyup', function(e) {

			if ($(this).val() != '') {

				if (reg.test($(this).val())) {

					$('#preview').attr('disabled', false);
					$('.card-reveal #iframe').html($(this).val());
					$(this).parents('.input-field').removeClass('error').find('.error').remove();

				} else {

					$(this).parents('.input-field').addClass('error').find('.error').remove()
					$(this).parents('.input-field.error').append('<div class="error">O mapa está incorreto</div>');
					$('#preview').attr('disabled', true);
					$('.card-reveal #iframe').html('Não há um mapa para ser carregado.');

				}

			} else {

				$('#preview').attr('disabled', true);
				$('.card-reveal #iframe').empty().html('Não há um mapa para ser carregado.');
				$(this).parents('.input-field').removeClass('error').find('.error').remove();

			}

		});

	});

}

/**
 * Manipulação de seções na página do admin "Páginas > Seções"
 */
function toggle(section) {

	var section = typeof section !== 'undefined' ? $(section) : $('.card:not(.sub-section)');

	$(section).find('.toggle[data-toggle]').each(function() {

		$(this).on('click', function(e) {

			e.preventDefault();

			var content = $(this).parents('.card-content');
			var toggle = $(this).data('toggle');
			var toggle = content.find('.' + toggle).toggle();

			if (toggle.is(':visible')) {
				$(this).find('i').text('keyboard_arrow_up')
			} else {
				$(this).find('i').text('keyboard_arrow_down')
			}

		});

		$(this).click();

	});

	$('#section').sortable({
		revert: true
	});

	$(section).draggable({
		'connectToSortable': '#section',
		'start': function() {
			$(this).find('.full--editor').each(function() {
				tinyMCE.execCommand('mceRemoveEditor', true, $(this).attr('id'));
			});
		},
		'stop': function() {
			$('.card').removeAttr('style');
			$(this).find('.full--editor').each(function() {
				console.log($(this).attr('id'))
				tinyMCE.execCommand('mceAddEditor', true, $(this).attr('id'));
			});
		},
	});

	delete_section(section);
	add_subsection(section);
	editor($(section).find('.full--editor'));

}

/**
 * Manipulação de seções na página do admin "Páginas > Seções"
 */
function delete_section(section) {

	$(section).find('[data-delete]').on('click', function(e) {

		e.preventDefault();

		var id = $(this).parents('#paginas').find('#sections').find('#section').find('.card:not(.sub-section)').length + 1;
		var _index = $(this).data('delete');
		var _parent = '';

		for (var i = 0; i < _index; i++) {
			_parent += '.parent()';
		}

		if (_parent != '') {

			eval('$(this)' + _parent + '.remove()');
			$(this).parents('#sub-section').each(function() {
				console.log($(this));
				$(this).find('.card-title').find('h4').text('Caixa de apresentação ' + (id - 1))
			});
		}

		$('.material-tooltip').css({
			'opacity': '0'
		});

	});

}

/**
 * Manipulação de seções na página do admin "Páginas > Seções"
 */
function add_subsection(section) {

	var section = typeof section !== 'undefined' ? $(section) : $('.card:not(.sub-section)');

	$(section).find('.card.card-add').on('click', function(e) {

		e.preventDefault();

		var id = $(this).parents('.card').attr('id').split('_')[1];
		var len = $(this).closest('.sub-sections').find('.sub-section').find('.card.sub-section').length;

		var sub_section = '<div class="col s4"> \
				<div class="card sub-section"> \
					<div class="card-content"> \
						<div class="card-title"> \
							<h4 class="left">Caixa de apresentação ' + (len + 1) + '</h4> \
							<a href="#" class="btn btn-floating btn-flat transparent float-right waves-effect waves-light" data-delete="4" data-tooltip="Remover Caixa"> \
								<i class="material-icons red-text">delete</i> \
							</a> \
						</div> \
						<div class="card-body"> \
							<!-- BEGIN título --> \
							<div class="row"> \
								<div class="col s12 mb-1"> \
									<div class="input-field"> \
										<label for="section_title">Título da caixa</label> \
										<input type="text" name="section[' + id + '][subsection][' + len + '][title]"> \
									</div> \
								</div> \
							</div> \
							<!-- END título --> \
							<!-- BEGIN subtítulo --> \
							<div class="row"> \
								<div class="col s12 mb-1"> \
									<div class="input-field"> \
										<label>Subtítulo da caixa</label> \
										<input type="text" name="section[' + id + '][subsection][' + len + '][subtitle]"> \
									</div> \
								</div> \
							</div> \
							<!-- END subtítulo --> \
							<!-- BEGIN link --> \
							<div class="row"> \
								<div class="col s12 mb-1"> \
									<div class="input-field"> \
										<label>Link</label> \
										<input type="text" name="section[' + id + '][subsection][' + len + '][link]"> \
									</div> \
								</div> \
							</div> \
							<!-- END link --> \
							<!-- BEGIN imagem de capa --> \
							<div class="row"> \
								<div class="col s12 mb-1"> \
									<div class="file-field input-field"> \
										<div class="btn"> \
											<div class="file"> \
												<i class="material-icons">attach_file</i> \
											</div> \
											<input type="file" name="section[' + id + '][subsection][' + len + '][imagem]"> \
										</div> \
										<div class="file-path-wrapper"> \
											<input type="text" class="file-path validate" placeholder="Imagem da caixa"> \
										</div> \
									</div> \
								</div> \
							</div> \
							<!-- END imagem de capa --> \
							<!-- BEGIN ícone --> \
							<div class="row"> \
								<div class="col s12 mb-1"> \
									<div class="file-field input-field"> \
										<div class="btn"> \
											<div class="file"> \
												<i class="material-icons">attach_file</i> \
											</div> \
											<input type="file" name="section[' + id + '][subsection][' + len + '][icone]"> \
											<input type="hidden" name="section[' + id + '][subsection][' + len + '][icone]"> \
										</div> \
										<div class="file-path-wrapper"> \
											<input type="text" class="file-path validate" placeholder="Ícone da caixa"> \
										</div> \
									</div> \
								</div> \
							</div> \
							<!-- END ícone --> \
							<!-- BEGIN Texto --> \
							<div class="row"> \
								<div class="col s12 mb-1"> \
									<div class="input-field"> \
										<label class="active">Texto da caixa</label> \
										<textarea name="section[' + id + '][subsection][' + len + '][text]" class="editor full--editor" data-height="300"></textarea> \
									</div> \
								</div> \
							</div> \
							<!-- END Texto --> \
						</div> \
					</div> \
				</div> \
			</div> ';

		$(this).closest('.sub-sections').find('section.sub-section').append(sub_section);

		$('input[name="subsection[]"]').each(function(e) {
			$(this).val(e);
		});

		delete_section('.card.sub-section');
		editor($(sub_section).find('.full--editor'));


	});

}

function resizeble() {

	var index = $('#index');
	var height = $(window).outerHeight();

	index.css({
		'height': height + 'px',
	});

}

function resizeBody() {

	// var alturaBody = $('body').height();

	// var alturaTotal = alturaBody - 420;

	// setTimeout(() => {
	//     $('.dataTables_wrapper.no-footer .dataTables_scrollBody').css({
	//         'height': alturaTotal + 'px',
	//         'min-height': alturaTotal + 'px',
	//         'max-height': alturaTotal + 'px',
	//     });
	// }, 0);

}

function animate(component, animation, callback) {

	var object;
	var animations = ["animated", "bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble", "jello", "heartBeat", "bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp", "bounceOut", "bounceOutDown", "bounceOutLeft", "bounceOutRight", "bounceOutUp", "fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "fadeOut", "fadeOutDown", "fadeOutDownBig", "fadeOutLeft", "fadeOutLeftBig", "fadeOutRight", "fadeOutRightBig", "fadeOutUp", "fadeOutUpBig", "flip", "flipInX", "flipInY", "flipOutX", "flipOutY", "lightSpeedIn", "lightSpeedOut", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "rotateOut", "rotateOutDownLeft", "rotateOutDownRight", "rotateOutUpLeft", "rotateOutUpRight", "slideInUp", "slideInDown", "slideInLeft", "slideInRight", "slideOutUp", "slideOutDown", "slideOutLeft", "slideOutRight↵	", "zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp", "zoomOut", "zoomOutDown", "zoomOutLeft", "zoomOutRight", "zoomOutUp", "hinge", "jackInTheBox", "rollIn", "rollOut"]

	$(component).removeClass(animations).addClass(animation + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
		$(this).removeClass(animations);

		if (typeof callback === 'function')
			callback($(this));
	});

};

function editor(element) {

	var $element = typeof element === 'undefined' ? $('body').find('.full--editor') : element;

	// Editor completo
	$element.each(function(e) {

		var tiny = tinymce.init({
			selector: '.' + $(this).attr('class').replace(/\s/g, '.'),
			relative_urls: false,
			remove_script_host: false,
			convert_urls: true,

			// images_upload_base_path: 'teste',
			images_upload_handler: function(blobInfo, success, failure) {

				var xhr, formData;
				var token = $('meta[name="csrf-token"]').attr('content');

				xhr = new XMLHttpRequest();
				xhr.withCredentials = false;
				xhr.open('POST', BASE_URL + 'api/tinymce');

				xhr.setRequestHeader("X-CSRF-Token", token);
				xhr.onload = function() {
					var json;
					if (xhr.status != 200) {
						failure('HTTP Error: ' + xhr.status);
						return;
					}
					json = JSON.parse(xhr.responseText);

					if (!json || typeof json.location != 'string') {
						failure('Invalid JSON: ' + xhr.responseText);
						return;
					}

					success(json.location);

				};

				formData = new FormData();
				formData.append('file', blobInfo.blob(), blobInfo.filename());

				xhr.send(formData);

			},
			file_picker_callback: function(cb, value, meta) {
				var input = document.createElement('input');
				input.setAttribute('type', 'file');
				input.setAttribute('accept', 'image/*');
				input.onchange = function() {
					var file = this.files[0];
					var id = 'blobid' + (new Date()).getTime();
					var blobCache = tinymce.activeEditor.editorUpload.blobCache;
					var blobInfo = blobCache.create(id, file);
					blobCache.add(blobInfo);
					cb(blobInfo.blobUri(), {
						title: file.name
					});
				};
				input.click();
			},
			height: typeof $(this).data('height') !== 'undefined' ? $(this).data('height') : 550,
			menubar: true,
			plugins: [
				'quickbars advlist autolink link image lists charmap print preview hr anchor pagebreak',
				'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
				'table emoticons template paste help'
			],
			toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
				'bullist numlist outdent indent | link | print preview media fullpage | ' +
				'forecolor backcolor emoticons | help | image',
			menu: {
				favs: {
					title: 'My Favorites',
					items: 'code visualaid | searchreplace | emoticons'
				}
			},
			menubar: 'favs file edit view insert format tools table help',
			// content_css: typeof $(this).data('style') !== 'undefined' ? $(this).data('style') : BASE_PATH + 'styles/style.css',
			placeholder: typeof $(this).attr('placeholder') !== 'undefined' ? $(this).attr('placeholder') : null

		});

		setTimeout(function() {
			$('.tox-selectfield').find('select').formSelect();
		}, 300)

	});

}

$(window).on('resize', function(e) {

	resizeBody();

});


/**
 * Função para aplicar máscaras nos inputs do navegador.
 */
var Mascaras = {
	aplicarMascaras: function() {

		var is_num = $('.is_num');
		var is_cpf = $('.is_cpf');
		var is_crm = $('.is_crm');
		var is_date = $('.is_date');
		var is_cnpj = $('.is_cnpj');
		var is_cpf_cnpj = $('.is_cpf_cnpj');
		var is_phone = $('.is_phone');
		var is_celular = $('.is_celular');
		var is_decimal = $('.is_decimal');
		var is_time = $('.is_time');
		var is_cep = $('.is_cep');
		var is_interval_time = $('.is_interval_time');

		is_num.each(function() {
			var $class = typeof $(this).attr('data-align') !== 'undefined' && $(this).attr('data-align') != '' ? $(this).attr('data-align') : 'right';
			var $placeholder = typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') != '' ? $(this).attr('placeholder') : '0';
			var $maxlength = typeof $(this).attr('maxlength') !== 'undefined' && $(this).attr('maxlength') != '' ? $(this).attr('maxlength') : 9;

			var input = this;

			$(window).load(function(e) {
				MascaraUtils.mascara(input, MascaraUtils.NUMERICO);
			});

			$(this).keyup(function() {
				MascaraUtils.mascara(this, MascaraUtils.NUMERICO);
			}).on('keypress', function() {
				MascaraUtils.mascara(this, MascaraUtils.NUMERICO);
			}).attr('maxlength', $maxlength).attr('placeholder', $placeholder).addClass('text-' + $class);
			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.NUMERICO);
		});

		is_cnpj.each(function() {

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.CNPJ);

			$(this).keyup(function() {
				MascaraUtils.mascara(this, MascaraUtils.CNPJ);
			}).on('keypress', function() {
				MascaraUtils.mascara(this, MascaraUtils.CNPJ);
			}).attr('maxlength', 18);

			if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') != '')
				$(this).attr('placeholder', $(this).attr('placeholder'));
			else if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') == '')
				$(this).removeAttr('placeholder').parent('.input-field').find('label').removeClass('active')

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.CNPJ);
		});

		is_cpf.each(function() {

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.CPF);

			$(this).keyup(function() {
				MascaraUtils.mascara(this, MascaraUtils.CPF);
			}).on('keypress', function() {
				MascaraUtils.mascara(this, MascaraUtils.CPF);
			}).attr('maxlength', 14);

			if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') != '')
				$(this).attr('placeholder', $(this).attr('placeholder'));
			else if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') == '')
				$(this).removeAttr('placeholder').parent('.input-field').find('label').removeClass('active')

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.CPF);
		});

		is_cpf_cnpj.each(function() {

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.CPF_CNPJ);

			$(this).keyup(function() {
				MascaraUtils.mascara(this, MascaraUtils.CPF_CNPJ);
			}).on('keypress', function() {
				MascaraUtils.mascara(this, MascaraUtils.CPF_CNPJ);
			}).attr('maxlength', 18);

			if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') != '')
				$(this).attr('placeholder', $(this).attr('placeholder'));
			else if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') == '')
				$(this).removeAttr('placeholder').parent('.input-field').find('label').removeClass('active')

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.CPF_CNPJ);
		});

		is_phone.each(function() {

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.TELEFONE);

			var len = 14;
			$(this).keyup(function() {
				MascaraUtils.mascara(this, MascaraUtils.TELEFONE);
			}).on('keypress', function() {
				MascaraUtils.mascara(this, MascaraUtils.TELEFONE);
			}).attr('maxlength', len);

			if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') != '')
				$(this).attr('placeholder', $(this).attr('placeholder'));
			else if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') == '')
				$(this).removeAttr('placeholder').parent('.input-field').find('label').removeClass('active')

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.TELEFONE);
		});

		is_celular.each(function() {

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.CELULAR);

			var len = 16;
			$(this).keyup(function() {
				MascaraUtils.mascara(this, MascaraUtils.CELULAR);
			}).on('keypress', function() {
				MascaraUtils.mascara(this, MascaraUtils.CELULAR);
			}).attr('maxlength', len);

			if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') != '')
				$(this).attr('placeholder', $(this).attr('placeholder'));
			else if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') == '')
				$(this).removeAttr('placeholder').parent('.input-field').find('label').removeClass('active')

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.CELULAR);

		});

		is_interval_time.each(function() {

			console.log(MascaraUtils.INTERVAL_TIME);
			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.INTERVAL_TIME);
			$(this).keyup(function() {
				MascaraUtils.mascara(this, MascaraUtils.INTERVAL_TIME, 'patterns');
			}).on('keypress', function() {

			});

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.INTERVAL_TIME);

		});


		is_decimal.each(function() {

			var exp = /^0\,[0-9]{2}$/;
			var $val = typeof $(this).attr('data-value') !== 'undefined' && $(this).attr('data-value') != null ? $(this).attr('data-value') : '0,00';
			var $class = typeof $(this).attr('data-align') !== 'undefined' && $(this).attr('data-align') != '' ? $(this).attr('data-align') : 'right';

			$(this).val($val).parents('.input-field').find('label').addClass('active');

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.DECIMAL);

			$(this).on('keydown', function(e) {

				MascaraUtils.mascara(this, MascaraUtils.DECIMAL);

				if ($(this).val() == '' || $(this).val() == '0,00' || $(this).val() == '0') {

					if (e.keyCode == 8) {
						$(this).val('0,00');
						e.preventDefault();
						return false;
					}

				}

				if ($(this).val().length <= 2) {
					$(this).val('0' + ($(this).val()));
				}

				if (MascaraUtils.Numerico(e.key)) {

					var valor = parseFloat($(this).val().replace(',', '.'));

					if (exp.test($(this).val())) {

						if (valor < 1) {
							$(this).val(($(this).val()).slice(-2));
						}

					}

				}


			}).on('keyup', function(e) {

				if ($(this).val() == '' || $(this).val() == '0,00' || $(this).val() == '0')
					if (e.keyCode == 8) {
						$(this).val('0,00');
						e.preventDefault();
						return false;
					}

			}).attr('maxlength', (typeof $(this).attr('maxlength') !== 'undefined' ? $(this).attr('maxlength') : 20)).attr('placeholder', '0,00').addClass('text-' + $class).focus(function() {
				if ($(this).val().length == 0 || $(this).val() == 0)
					$(this).val('0,00');
			}).on('blur', function() {
				if ($(this).val().length == 0 || $(this).val() == 0)
					$(this).val('0,00');

			});

		});

		is_crm.each(function() {

			var exp = /^0{9}\-[0-9]{1}$/;
			var $val = typeof $(this).attr('data-value') !== 'undefined' && $(this).attr('data-value') != null ? $(this).attr('data-value') : '';
			var $class = typeof $(this).attr('data-align') !== 'undefined' && $(this).attr('data-align') != '' ? $(this).attr('data-align') : 'right';

			$(this).val($val).parents('.input-field').find('label').addClass('active');

			var input = this;
			MascaraUtils.mascara(input, MascaraUtils.CRM);

			$(this).on('keydown', function(e) {

				MascaraUtils.mascara(this, MascaraUtils.CRM);

				if ($(this).val() == '' || $(this).val() == '000000000-0' || $(this).val() == '0') {

					if (e.keyCode == 8) {
						// $(this).val('000000000-0');
						e.preventDefault();
						return false;
					}

				}

				if ($(this).val().length <= 9) {
					// $(this).val('0' + ($(this).val()));
				}

				if (MascaraUtils.Numerico(e.key)) {

					var valor = parseFloat($(this).val().replace('-', '.'));
					console.log(valor);

					if (exp.test($(this).val())) {

						if (valor < 1) {
							$(this).val(($(this).val()).slice(-1));
						}

					}

				}


			}).on('keyup', function(e) {

				if ($(this).val() == '' || $(this).val() == '000000000-0' || $(this).val() == '0')
					if (e.keyCode == 8) {
						// $(this).val('000000000-0');
						e.preventDefault();
						return false;
					}

			}).attr('maxlength', (typeof $(this).attr('maxlength') !== 'undefined' ? $(this).attr('maxlength') : 11)).attr('placeholder', '000000000-0').addClass('text-' + $class).focus(function() {
				// if ($(this).val().length == 0 || $(this).val() == 0)
				// 	$(this).val('000000000-0');
			}).on('blur', function() {
				// if ($(this).val().length == 0 || $(this).val() == 0)
				// 	$(this).val('000000000-0');

			});

		});

		is_date.each(function() {

			var input = this;
			var placeholder = typeof $(this).attr('placeholder') !== 'undefined' ? $(this).attr('placeholder') : 'dd/mm/aaaa';
			var $val = typeof $(this).attr('data-value') !== 'undefined' && $(this).attr('data-value') != null ? $(this).attr('data-value') : '';
			var $class = typeof $(this).attr('data-align') !== 'undefined' && $(this).attr('data-align') != '' ? $(this).attr('data-align') : 'right';
			var maxlength = 10;

			$(this).val($val).parents('.input-field').find('label').addClass('active');

			// insere o placMascaraUtils.mascara(input, MascaraUtils.INTERVAL_TIME);
			$(this).keyup(function() {
				MascaraUtils.mascara(MascaraUtils.INTERVAL_TIME);
			}).on('keypress', function() {

			});

			$date = new Date();
			// var curDate = $date.getDate();
			// var curMonth = ($date.getMonth() < 10 ? '0' : null) + ($date.getMonth() + 1);
			var curYear = $date.getFullYear();

			var $fieldValue = $(this).val() != '' ? $(this).val().split('/') : null;
			var $minDate = typeof $(this).data('min-date') !== 'undefined' ? $(this).data('min-date').split('/') : null;
			var $maxDate = typeof $(this).data('max-date') !== 'undefined' ? $(this).data('max-date').split('/') : null;
			var $yearRange = $minDate != null ? [$minDate[2], curYear + 100] : $maxDate != null ? [1900, curYear - 0] : [curYear - 100, curYear + 100];

			$minDate = $minDate != null ? new Date($minDate[2], $minDate[1], $minDate[0] - 31) : null;
			$maxDate = $maxDate != null ? new Date($maxDate[2], $maxDate[1], $maxDate[0] - 31) : null;
			$fieldValue = $fieldValue != null ? (new Date($fieldValue[2], $fieldValue[1], $fieldValue[0] - 31)) : null;

			$(this).on('keyup', function() {
					MascaraUtils.mascara(this, MascaraUtils.DATA);
				}).on('keypress', function() {
					MascaraUtils.mascara(this, MascaraUtils.DATA);
				}).attr('maxlength', (typeof $(this).attr('maxlength') !== 'undefined' ? $(this).attr('maxlength') : maxlength)).attr('placeholder', placeholder)
				.addClass('text-' + $class).focus(function() {
					if ($(this).val().length == 0 || $(this).val() == 0)
						$(this).val('');
				})
				.datepicker({
					format: 'dd/mm/yyyy',
					startView: 1,
					autoClose: false,
					setDefaultDate: true,
					defaultDate: $fieldValue,
					minDate: $minDate, // (new Date(curYear, curMonth)),
					maxDate: $maxDate, // (new Date(curYear, curMonth, curDate - 30)),
					yearRange: $yearRange,
					i18n: {
						months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'], // Names of months for drop-down and formatting
						monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'], // For formatting
						weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'], // For formatting
						weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'], // For formatting
						weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'], // Column headings for days starting at Sunday
						cancel: 'Cancelar',
					},
					showClearBtn: false
				});

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.DATA);

		});

		is_time.each(function(e) {

			var exp = /^[0-9]{2}\:[0-9]{2}$/;
			// var exp = /^(([0-1][0-9])|([2][0-3]))\:([1-5][0-9])$/;
			var $val = typeof $(this).attr('data-value') !== 'undefined' && $(this).attr('data-value') != null ? $(this).attr('data-value') : '00:00';
			var $class = typeof $(this).attr('data-align') !== 'undefined' && $(this).attr('data-align') != '' ? $(this).attr('data-align') : 'right';

			$(this).val($val).parents('.input-field').find('label').addClass('active');

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.TIME);

			$(this).on('keydown', function(e) {


					if ($(this).val() == '' || $(this).val() == '00:00' || $(this).val() == '0') {

						if (e.keyCode == 8) {
							$(this).val('00:00');
							e.preventDefault();
							return false;
						}

					}

					MascaraUtils.mascara(this, MascaraUtils.TIME);

					if (MascaraUtils.Numerico(e.key)) {

						var valor = parseFloat($(this).val().replace(':', '.'));

						if (exp.test($(this).val())) {

							if (valor < 3) {
								$(this).val(($(this).val()).slice(-4));
							}

						}

					}


				}).on('keyup', function(e) {

					if ($(this).val() == '' || $(this).val() == '00:00' || $(this).val() == '0')
						if (e.keyCode == 8) {
							$(this).val('00:00');
							e.preventDefault();
							return false;
						}

					var minuto = $(this).val().split(':').splice(1);
					var exp_minuto = /^[0-5][0-9]$/;

					$(this).parents('.input-field').removeClass('.error').find('.error').remove();

					if (!exp_minuto.test(minuto)) {

						$(this).parents('.input-field').addClass('.error').append($('<div/>', {
							'class': 'error',
							'html': 'Formato inválido <i class="material-icons-outlined sufix">error</i>'
						}))

					}


				}).attr('maxlength', (typeof $(this).attr('maxlength') !== 'undefined' ? $(this).attr('maxlength') : 5)).attr('placeholder', '00:00').addClass('text-' + $class).focus(function() {
					if ($(this).val().length == 0 || $(this).val() == 0)
						$(this).val('00:00');
				})
				.timepicker({
					'twelveHour': false
				})
				.on('blur', function() {
					if ($(this).val().length == 0 || $(this).val() == 0)
						$(this).val('00:00');
				});

		});

		is_cep.each(function() {

			var input = this;

			MascaraUtils.mascara(input, MascaraUtils.CEP);

			$(this).bind('keyup paste', function() {
				$(input).parent().removeClass('error').find('.error').remove().removeClass('error');
				MascaraUtils.mascara(this, MascaraUtils.CEP);
			}).attr('maxlength', 9);

			$(this).bind('keyup paste', delay(function(e) {
				if (e.keyCode !== 32 || e.keyCode !== 27 || e.keyCode !== 17 || e.keyCode !== 8) {
					getEndereco($(this));
				}
			}, 300));

			if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') != '')
				$(this).attr('placeholder', $(this).attr('placeholder'));
			else if (typeof $(this).attr('placeholder') !== 'undefined' && $(this).attr('placeholder') == '')
				$(this).removeAttr('placeholder').parent('.input-field').find('label').removeClass('active')

			if ($(this).val() !== '')
				MascaraUtils.mascara(this, MascaraUtils.CEP);

		});

	}

};

function getEndereco(cep) {

	if (cep.val().length === parseInt(cep.attr('maxlength'))) {

		Http.get(SITE_URL + 'api/cep/' + cep.val(), {}, (response) => {

			if (response.status === 'error') {
				// cep.parents('form').find('input[name="' + i + '"]').val(response[i]).parents('.input-field').find('label').addClass('active');
				Form.showErrors(response, response.status);
			}

			for (var i in response.fields) {
				cep.parents('form').find('input[name="' + i + '"]').val(response.fields[i])
				if (response.fields[i] != null)
					cep.parents('form').find('input[name="' + i + '"]').parents('.input-field').find('label').addClass('active');
				else
					cep.parents('form').find('input[name="' + i + '"]').parents('.input-field').find('label').removeClass('active');
			}

		});

	}

}

var obj,
	fn;

var MascaraUtils = {
	NUMERICO: 1,
	CPF: 2,
	CNPJ: 3,
	CPF_CNPJ: 4,
	TELEFONE: 5,
	CELULAR: 6,
	DECIMAL: 7,
	DATA: 8,
	TIME: 9,
	HORA: 10,
	MINUTO: 11,
	SEGUNDO: 12,
	CEP: 13,
	INTERVAL_TIME: 14,
	CRM: 15,
	fn: null,
	obj: null,
	mascara: function(o, f, p) {

		obj = o;

		switch (f) {
			case this.NUMERICO:
				fn = this.Numerico;
				break;
			case this.CPF:
				fn = this.Cpf;
				break;
			case this.CNPJ:
				fn = this.Cnpj;
				break;
			case this.CPF_CNPJ:
				fn = this.Cpf_cnpj;
				break;
			case this.TELEFONE:
				fn = this.Telefone;
				break;
			case this.CELULAR:
				fn = this.Celular;
				break;
			case this.DECIMAL:
				fn = this.Decimal;
				break;
			case this.DATA:
				fn = this.Data;
				break;
			case this.TIME:
				fn = this.Time;
				break;
			case this.HORA:
				fn = this.Hora;
				break;
			case this.MINUTO:
				fn = this.Minuto;
				break;
			case this.SEGUNDO:
				fn = this.Segundo;
				break;
			case this.CEP:
				fn = this.Cep;
				break;
			case this.INTERVAL_TIME:
				fn = this.IntervalTime;
				break;
			case this.CRM:
				fn = this.Crm;
				break;
		}
		setTimeout('MascaraUtils.exec()', 1);
	},
	exec: function() {
		obj.value = fn(obj.value, obj.pattern || null);
	},
	Numerico: function(v) {
		return v.replace(/\D/g, '');
	},

	Telefone: function(v) {
		v = v.replace(/\D/g, '');
		if (v.length < 11) {
			v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
			v = v.replace(/(\d{3,4})(\d)/, '$1.$2');
		} else {
			v = v.replace(/^(\d{4})(\d{3})(\d{4})/g, '$1 $2 $3');
		}
		return v;
	},
	Cpf: function(v) {
		v = v.replace(/\D/g, '');
		v = v.replace(/(\d{3})(\d)/, '$1.$2');
		v = v.replace(/(\d{3})(\d)/, '$1.$2');
		v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
		return v;
	},
	Cpf_cnpj: function(v) {
		if (v.length <= 14) {
			v = v.replace(/\D/g, '');
			v = v.replace(/(\d{3})(\d)/, '$1.$2');
			v = v.replace(/(\d{3})(\d)/, '$1.$2');
			v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
		} else if (v.length > 14 && v.length < 19) {
			v = v.replace(/\D/g, '');
			v = v.replace(/^(\d{2})(\d)/, '$1.$2');
			v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
			v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
			v = v.replace(/(\d{4})(\d)/, '$1-$2');
		}
		return v;
	},
	Crm: function(v) {
		var splitText = v.split('');
		var revertText = splitText.reverse();
		var v2 = revertText.join('');
		var v2 = v2.replace(/\D/g, '')

		if (v2.length <= 2) {
			v2 = v2.replace(/(\d)(\d)/, '$1$2-0');
		} else {
			v2 = v2.replace(/(\d{1})(\d)/, '$1-$2');
		}

		if (v2.length > 6) {

			for (var i = 0; i < v2.length; i++) {
				v2 = v2.replace(/(\d{1})(\d)/, '$1$2');
			}

		}

		v2 = v2.split('');
		revertText = v2.reverse();
		v2 = revertText.join('');

		return v2;
	},
	Decimal: function(v) {

		var splitText = v.split('');
		var revertText = splitText.reverse();
		var v2 = revertText.join('');
		var v2 = v2.replace(/\D/g, '')

		if (v2.length <= 2) {
			v2 = v2.replace(/(\d)(\d)/, '$1$2,0');
		} else {
			v2 = v2.replace(/(\d{2})(\d)/, '$1,$2');
		}

		if (v2.length > 6) {

			for (var i = 0; i < v2.length; i++) {
				v2 = v2.replace(/(\d{3})(\d)/, '$1.$2');
			}

		}

		v2 = v2.split('');
		revertText = v2.reverse();
		v2 = revertText.join('');

		return v2;

	},

	Data: function(v) {
		v = v.replace(/\D/g, '');
		v = v.replace(/(\d{2})(\d)/, '$1/$2');
		v = v.replace(/(\d{2})(\d)/, '$1/$2');
		return v;
	},

	// Time: function(v) {
	// 	v = v.replace(/\D/g, '');
	// 	v = v.replace(/(\d{2})(\d)/, '$1:$2');
	// 	v = v.replace(/(\d{2})(\d)/, '$1:$2');
	// 	return v;
	// },

	Time: function(v) {

		var splitText = v.split('');
		var revertText = splitText.reverse();
		var v2 = revertText.join('');
		var v2 = v2.replace(/\D/g, '');

		if (v2.length <= 3) {
			v2 = v2.replace(/(\d{2})(\d)/, '$1:$20');
		}

		for (var i = 0; i < v2.length; i++) {
			v2 = v2.replace(/(\d{2})(\d)/, '$1:$2');
		}

		v2 = v2.split('');
		revertText = v2.reverse();
		v2 = revertText.join('');

		return v2;


	},

	Hora: function(v) {
		var exp = /^([0-1][0-9])|([2][0-3])$/;
		var hora = true;
		if (v.length == 2) {
			if (!exp.test(v))
				return v = '00';
		}
		return ('00' + v).slice(-2);
	},

	Minuto: function(v) {
		var exp = /^([0-5][0-9])$/;
		var min = true;
		if (v.length == 2) {
			if (!exp.test(v))
				return v = '00';
		}
		return ('00' + v).slice(-2);

	},
	Segundo: function(v) {
		var exp = /^([0-5][0-9])$/;
		var sec = true;
		if (v.length == 2) {
			if (!exp.test(v))
				return v = '00';
		}
		return ('00' + v).slice(-2);
	},
	Cep: function(v) {
		v = v.replace(/\D/g, '');
		v = v.replace(/^(\d{5})(\d)/, '$1-$2');
		return v;
	},
	Cnpj: function(v) {
		v = v.replace(/\D/g, '');
		v = v.replace(/^(\d{2})(\d)/, '$1.$2');
		v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
		v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
		v = v.replace(/(\d{4})(\d)/, '$1-$2');
		return v;
	},
	Celular: function(v) {

		v = v.replace(/\D/g, '');
		v = v.replace(/^(\d{2})(\d)/, '($1) $2');

		if (v.length < 14) {
			v = v.replace(/(\d{4})(\d)/, '$1.$2');
		} else {
			v = v.replace(/(\d{5})(\d)/, '$1.$2');
			v = v.replace(/(\d{1})(\d{2})/, '$1 $2');
		}
		return v;
	},
	IntervalTime: function(v, p) {
		var pattern = p;
		v = v.replace(/\D/g, '');
		v = v.replace(/^(\d{2})(\d{2})/, p);
		console.log(v);
		return v;
		// console.log(v.attr('pattern'));
	},
};

var Events = {

	Evento: function(e) {

		$(document).keyup(function(e) {
			key_event.tecla(e.keyCode);
		});

	}

};

function checkLog() {

	$(this).removeClass('pause').addClass('play').find('i').html('play_arrow');

	Http.post(BASE_URL + 'api/log', {
		dataType: 'json'
	}, function(response) {

		if (response.log != null) {

			Storage.set('syncfiles', true);

			$('#log').css('display', 'block').find('#console').parent().animate({
				scrollTop: $('#console').height() * 100
			}, {
				duration: 200
			}).find('#console').append('' + response.log.replace(/\n/g, '<br>') + '');

			if ($('#shell_exec').find('i').hasClass('material-icons')) {

				var preloader_wrapper = $('<div>', {
						'class': 'preloader-wrapper small active'
					})
					.append(
						$('<div>', {
							'class': 'spinner-layer spinner-blue-only'
						})
						.append(
							$('<div>', {
								'class': 'circle-clipper left'
							})
							.append(
								$('<div>', {
									'class': 'circle'
								})
							)
						)
						.append(
							$('<div>', {
								'class': 'gap-patch'
							})
							.append(
								$('<div>', {
									'class': 'circle'
								})
							)
						)
						.append(
							$('<div>', {
								'class': 'circle-clipper right'
							})
							.append(
								$('<div>', {
									'class': 'circle'
								})
							)
						)
					)

				$('#shell_exec').attr('disabled', true).find('i').removeClass('material-icons').html(preloader_wrapper);

			}

		} else {

			clearInterval(checkLogs);

			$('form#import-files *').attr('disabled', false);
			$('form#import-files').find('button[type="submit"]').find('i').addClass('material-icons').text('send');
			$('#log').hide();

			if (Storage.has('syncfiles')) {
				Form.showMessage(response.message);
				Storage.del('syncfiles');
			}

		}

	});

}

function create_element(id) {

	$('.dropzone').each(function() {

		$(this).find('[type="file"]').on('change', function() {

			console.log($(this).val());
			var self = $(this);
			var $len = (self.parent().find('[type="file"]').length);

			if (typeof id === 'undefined')
				var id = $(this).attr('id');
			else
				var id = 'file' + id;

			if ($('#' + id).is(':visible')) {

				for (var i = 0; i < document.getElementById(id).files.length; i++) {

					console.log(id);
					src = window.URL.createObjectURL(document.querySelector('#' + id).files[i]);

					var div = $('<div/>', {
						'class': 'miniaturas',
					});

					var img = $('<img/>', {
						'src': src,
						'class': '',
					});

					$(this).parent().append(div.append(img));
					// $(img).materialbox();

				}

				$(this).parent().append($('<input/>', {
					'type': 'file',
					'name': 'file[]',
					'id': 'file' + ($len++),
					'multiple': 'multiple',
					'title': ''
				}));

				var new_file = 'file' + id;

				create_element(new_file);


			}

			self.hide();

		})

	});

}

function isJSON(str) {

	if (typeof str !== 'string') {
		return false;
	}

	try {
		return (JSON.parse(str) && !!str);
	} catch {
		return false;
	}

}

function alert(message, type = 'error') {

	var m = $('#alerts');
	$('#alerts').addClass(type).modal({
		dismissible: false,
		inDuration: 100,
		startingTop: '35%',
		endingTop: '35%',
		onCloseStart: () => {
			$(m).removeClass(type);
		}
	});

	if (typeof message === 'object') {
		title = message.title;
		message = message.message;
	} else {
		title = type;
	}
	$('#alerts').find('.modal-content').find('.title').html(title);
	$('#alerts').find('.modal-content').find('.info').html(message);
	m.modal('open');

}

function getData(autocomplete, url, query = null, limit = 10) {

	if (url !== null) {

		var autocomplete_instance = M.Autocomplete.getInstance(autocomplete);
		var $data = {};

		if (query != null) var $data = {
			data: {
				query: query
			}
		};

		Http.get(url, {
			datatype: 'json',
			$data
		}, (response) => {

			var data = {};

			Object.keys(response).forEach((i) => {
				var item = response[i];
				data[item.label] = {
					'label': item.label,
					'icon': item.icon,
					'value': item.value,
					'name': item.name
				};
			});

			autocomplete_instance.updateData(data);

		});

	}

}

function autocomplete() {

	// Create element Autocomplete
	$('body').find('input.autocomplete').each(function() {

		var autocomplete = $(this);
		var url = autocomplete.data('url') || null;
		var limit = autocomplete.data('limit') || 10;
		var input = null;

		if (autocomplete.length === 0) return;

		var complete = autocomplete.autocomplete({
			minLength: 0,
			limit: limit,
			onAutocomplete: (name, value) => {
				input = name;
				autocomplete.parent().find(':hidden[name="' + name + '"]').remove();
				autocomplete.parent().append($('<input>', {
					type: 'hidden',
					name: name,
					value: value
				}));
			}
		});

		getData(autocomplete, url);

		$(this).on('keyup', function(e) {

			var key = e.keyCode;
			var url = $(this).data('url') || null;

			if (key === 8 || key === 46) {
				console.log(url);
				getData(autocomplete, url);
			}

			getData(autocomplete, url, autocomplete.val());


		}).on('keydown', function(e) {

			var key = e.keyCode;
			var hidden = $(this).parent().find(':hidden[name="' + input + '"]');

			if (key === 8 || key === 46) {
				$(this).val('');
				if (hidden.length)
					hidden.val('');
				getData(autocomplete, url);
			}


		});

	});

	// console.log($element)
	// Ação para obter Empresas que possuem a especialidade selecionada.
	$('input[id="especialidade"]').on('change', function() {
		var comp;
		var localidade;

		localidade = $('input[name="localidade"]').autocomplete();
		comp = M.Autocomplete.getInstance(localidade);

		var especialidade = $(this).val().split(' - ').splice(0, 1).toString();
		var $input_destino = $('input[name="localidade"]');
		var url_empresas = $input_destino.data('url');
		var data = {};

		Http.get(url_empresas, {
			'datatype': 'json',
			'data': {
				'especialidade': especialidade
			}
		}, (response) => {

			Object.keys(response).forEach((i) => {
				var item = response[i];
				data[item.label] = {
					'label': item.label,
					'icon': item.icon,
					'value': item.value,
					'name': item.name
				};
			});

			comp.updateData(data);
			comp.open();

		});

	});

}

function fullcalendar_init() {

	// Para remover a classe caso não possua itens de calendário na página
	$('body').removeClass('main-full');

	// var calendarEl = document.getElementById('calendar');
	var calendarEl = document.querySelector('.calendar');

	if (calendarEl === null) return;

	var calendar = new FullCalendar.Calendar(calendarEl, {
		// height: $(calendarEl).closest('#main').outerHeight() - 60,
		headerToolbar: {
			left: 'dayGridMonth,timeGridWeek,timeGridDay',
			center: 'title',
			right: 'today prev,next',
		},
		titleFormat: {
			month: 'long',
			year: 'numeric',
			day: 'numeric',
			// weekday: 'long'
		},
		timeZone: 'America/Sao_Paulo',
		locale: 'pt-br',
		buttonText: {
			today: 'Hoje',
			month: 'Mês',
			week: 'Semana',
			day: 'Dia',
			list: 'Lista'
		},
		// initialDate: '2022-12-07',
		// navLinks: true, // can click day/week names to navigate views
		selectable: false,
		selectAllow: true,
		selectMirror: true,

		eventDragStop: function(e, a, i) {
			console.log(e);
		},

		// eventAdd: function(a, e, i, o, u) {
		// 	console.log(a, e, i, o, u);
		// },

		eventResize: function(a, b, c, d, e, f, g) {
			console.log(a, b, c, d, e, f, g);
		},

		eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {

			// alert(
			// 	event.title + " was moved " +
			// 	dayDelta + " days and " +
			// 	minuteDelta + " minutes."
			// );

			// if (allDay) {
			// 	alert("Event is now all-day");
			// } else {
			// 	alert("Event has a time-of-day");
			// }

			// if (!confirm("Are you sure about this change?")) {
			// 	revertFunc();
			// }
			console.log(event, dayDelta, minuteDelta, allDay, revertFunc);

		},

		dateClick: function(arg) {

			var timestamp = arg.dateStr.split('T');
			var date = timestamp.slice(0, 1).toString();
			var hour = timestamp.length == 2 ? timestamp.splice(-1).toString().split(':') : null;

			date = date.split('-');
			var d = date.splice(-1);
			var m = date.splice(1);
			var a = date.splice(0);

			var h = hour !== null ? hour.splice(0, 1) : '00';
			var i = hour !== null ? hour.splice(1) : '00';
			var s = hour !== null ? hour.splice(-1) : '00';

			var dateFormat = d + '/' + m + '/' + a;
			var hourFormat = h + ':' + i;

			var form = $('.form-sidenav-trigger');

			form.click()

			setTimeout(function() {

				$('#agendamento').find('form').find('input[name="data"]').val(dateFormat);
				$('#agendamento').find('form').find('input[name="hora"]').val(hourFormat);

				Form.submit($('#agendamento').find('form'), function(e) {

					calendar.addEvent({
						title: 'Teste',
						start: arg.dateStr,
						end: arg.dateStr,
						allDay: false
					});

					calendar.unselect();

					console.log(e);

				});

			}, 300);


			// var modal_add_event = $('#modal_add_event_calendar');
			// $(modal_add_event).modal({
			// 	dismissible: true,
			// 	inDuration: 100,
			// 	startingTop: '35%',
			// 	endingTop: '35%',
			// 	onCloseStart: () => {
			// 	}
			// });
			// modal_add_event.modal('open');
			// $('#alerts').addClass(type).modal({
			// 	dismissible: false,
			// 	inDuration: 100,
			// 	startingTop: '35%',
			// 	endingTop: '35%',
			// 	onCloseStart: () => {
			// 		$(m).removeClass(type);
			// 	}
			// });

			// if (typeof message === 'object') {
			// 	title = message.title;
			// 	message = message.message;
			// } else {
			// 	title = type;
			// }
			// $('#alerts').find('.modal-content').find('.title').html(title);
			// $('#alerts').find('.modal-content').find('.info').html(message);
			// m.modal('open');

			// var title = prompt('Event Title:');
			// if (title) {
			// 	calendar.addEvent({
			// 		title: title,
			// 		start: arg.start,
			// 		end: arg.end,
			// 		allDay: arg.allDay
			// 	})
			// }
			// calendar.unselect()
		},
		eventClick: function(arg) {
			if (confirm('Are you sure you want to delete this event?')) {
				arg.event.remove()
			}
		},
		editable: true,
		dayMaxEvents: true, // allow "more" link when too many events
		events: '/teste.php',
	});

	$('body').addClass('main-full').removeClass('active').find('.sidenav-main').find('.active').removeClass('active');
	$('.sidenav-main').removeClass('nav-expanded nav-lock').addClass('nav-collapsed').find('.collapsible-body').hide();
	$('#main').addClass('main-full')

	setTimeout(function() {
		calendar.render();
		$('#calendar').find('.calendar-loading').remove();
		$('.fc-button.fc-prev-button,.fc-button.fc-next-button,.fc-button.fc-today-button').each(function() {
			$(this).addClass('waves-effect waves-light');
		});
	}, 500)

}
