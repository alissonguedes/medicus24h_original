<div class="row">
	<div id="modal_especialidade" class="modal modal-fixed-footer col s12 m4 l4 offset-m1 offset-l2" data-dismissible="false">
		<form action="{{ go('clinica.especialidades.post') }}" method="post" enctype="multipart/form-data" autocomplete="off" novalidade style="min-height: 400px;">

			@if(isset($row))
				<input type="hidden" name="_method" value="put">
				<input type="hidden" name="id" value="{{ $row->id }}">
			@endif
			<div class="modal-content">
				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<label for="especialidade" class="{{ isset($row) && $row->especialidade ? 'active' : null }}">Especialidade</label>
							<input type="text" name="especialidade" id="especialidade" value="{{ $row->especialidade ?? null }}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-field">
							<label for="descricao" class="{{ isset($row) && $row->descricao ? 'active' : null }}">Descrição</label>
							<textarea name="descricao" id="descricao" class="materialize-textarea" style="min-height: 100px;">{{ $row->descricao ?? null }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn modal-close white waves-effect mr-2" data-toggle="Voltar">
					<i class="material-icons-outlined black-text">arrow_back</i>
				</button>
				<button type="submit" class="btn green waves-effect" data-toggle="Salvar">
					<i class="material-icons-outlined">save</i>
				</button>
			</div>
		</form>
	</div>
</div>
