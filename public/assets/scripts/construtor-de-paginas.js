// requirejs([BASE_URL + "/../../assets/tacticweb/scripts/core.js"], () => {
// 	init();
// });

// requirejs([BASE_URL + "/../../assets/scripts/banner.js"], () => {
// 	Banner.init();
// });

/**
 * Manipulação de seções na página do admin "Páginas > Seções"
 */
toggle();

$('#paginas').find('#sections').find('#section > .card').each(function(index) {

	$(this).find('input[name="section[' + index + '][title]"]').on('keyup', function() {
		$(this).parents('.card-content').find('.card-title').find('span').text(
			$(this).val() != '' ? $(this).val() : 'Sem título'
		);
	});

});

$('#paginas').find('.add-section').on('click', function(e) {

	e.preventDefault();

	var id = $(this).parents('#paginas').find('#sections').find('#section > .card').length;
	var id_section = 'section_' + id;

	var section = ' \
		<!--card --> \
		<div id="' + id_section + '" class="card"> \
			<!-- card-content --> \
			<div class="card-content"> \
				<div class="card-title"> \
						<h4 class="left">Seção - <span>Sem título</span> </h4> \
					<a href="#" class="btn btn-floating btn-flat transparent float-right waves-effect waves-light toggle" data-toggle="card-body"> \
						<i class="material-icons grey-text">keyboard_arrow_up</i> \
					</a> \
					<a href="#" class="btn btn-floating btn-flat transparent float-right waves-effect waves-light" data-delete="3" data-tooltip="Remover Seção"> \
						<i class="material-icons red-text">delete</i> \
					</a> \
				</div> \
				<!-- BEGIN card-body --> \
				<div class="card-body mt-3"> \
					<!-- section --> \
					<section id=""> \
						<!-- BEGIN título --> \
						<div class="row"> \
							<div class="col s12 mb-1"> \
								<div class="input-field"> \
									<label>Título da seção</label> \
									<input type="text" name="section[' + id + '][title]" class="section_title"> \
								</div> \
							</div> \
						</div> \
						<!-- END título --> \
						<!-- BEGIN subtítulo --> \
						<div class="row"> \
							<div class="col s12 mb-1"> \
								<div class="input-field"> \
									<label>Subtítulo da seção</label> \
									<input type="text" name="section[' + id + '][subtitle]"> \
								</div> \
							</div> \
						</div> \
						<!-- END subtítulo --> \
						<!-- BEGIN link --> \
						<div class="row"> \
							<div class="col s12 mb-1"> \
								<div class="input-field"> \
									<label>Link</label> \
									<input type="text" name="section[' + id + '][link]"> \
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
										<input type="file" name="section[' + id + '][imagem]"> \
										<input type="hidden" name="section[' + id + '][imagem]"> \
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
										<input type="file" name="section[' + id + '][icone]"> \
										<input type="hidden" name="section[' + id + '][icone]"> \
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
									<label>Texto da seção</label> \
									<textarea type="text" name="section[' + id + '][text]" class="editor full--editor"></textarea> \
								</div> \
							</div> \
						</div> \
						<!-- END Texto --> \
						<!-- BEGIN sub-sections --> \
						<div class="sub-sections row"> \
							<section class="sub-section"> \
							</section> \
							<div class="col s4"> \
								<div class="card card-add"> \
									<div class="card-content no-padding"> \
										<div class="card-title"></div> \
										<div class="card-body"> \
											<button type="button" class="add-card waves-effect"> \
												<i class="material-icons">add</i> \
											</button> \
										</div> \
									</div> \
								</div> \
							</div> \
						</div> \
						<!-- END sub-sections --> \
					</section> \
					<!-- END section --> \
				</div> \
				<!-- END card-body --> \
			</div> \
			<!-- END card-content --> \
		</div> \
		<!-- END card -->';

	$(this).parents('#sections').find('#section').append(section).find('input[name="section[' + id + '][title]"]').on('keyup', function() {
		$(this).parents('.card-content').find('.card-title').find('span').text(
			$(this).val() != '' ? $(this).val() : 'Sem título'
		);
	})

	toggle('#' + id_section);

});
