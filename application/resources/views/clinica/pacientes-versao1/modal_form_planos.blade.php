<div id="form_plano_saude" class="modal" style="overflow-y: auto;">
	<form action="{{ go('clinica.pacientes.addplano') }}" method="post" data-autoinitialize="false">
		<div class="modal-content">

			@if(isset($row))
				<input type="hidden" name="_method" value="put">
				<input type="hidden" name="id" value="{{ $row->id }}">
			@endif

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="id_convênio">Convênio</label>
						<select name="id_convenio" id="id_convenio">
							<option value="" disabled selected>Informe o convênio</option>
							@foreach($convenios as $convenio)
								<option value="{{ $convenio->id }}" {{ isset($row) && $convenio->id==$row->id_convenio ? 'selected=selected' : null }}>{{ $convenio->descricao }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col s12">
					<div class="input-field">
						<label for="id_tipo">Tipo do Convênio</label>
						<select name="id_tipo" id="id_tipo">
							<option value="" disabled selected>Informe o convênio</option>
							@foreach($convenios as $convenio)
								<option value="{{ $convenio->id }}" {{ isset($row) && $convenio->id==$row->id_tipo ? 'selected=selected' : null }}>{{ $convenio->descricao }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col s12">
					<div class="input-field">
						<label for="id_acomodacao">Tipo de acomodação</label>
						<select name="id_acomodacao" id="id_acomodacao">
							<option value="" disabled selected>Informe o tipo de acomodação</option>
							@foreach($acomodacoes as $acomodacao)
								<option value="{{ $acomodacao->id }}" {{ isset($row) && $acomodacao->id==$row->id_acomodacao ? 'selected=selected' : null }}>{{ $acomodacao->descricao }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col s12 m6 l6">
					<div class="input-field">
						<label for="matricula">Matrícula</label>
						<input type="text" name="matricula" id="matricula" value="{{ $row->matricula ?? null }}">
					</div>
				</div>
				<div class="col s12 m6 l6">
					<div class="input-field">
						<label class="active" for="carteira">Validade</label>
						@php
							$mes = null;
							$ano = null;
							if(isset($row) && $row->validade_ano && $row->validade_mes) {
							$mes = $row->validade_mes;
							$ano = $row->validade_ano;
							}
							$meses = ['01'=>'Jan', '02'=>'Fev', '03'=>'Mar', '04'=>'Abr', '05'=>'Mai', '06'=>'Jun', '07'=>'Jul', '08'=>'Ago', '09'=>'Set', '10'=>'Out', '11'=>'Nov', '12'=>'Dez',];
						@endphp
						<div class="row">
							<div class="col s6">
								<select name="validade_mes">
									<option value="" selected="selected" disabled="disabled">Mês</option>
									@foreach($meses as $i => $m)
										<option value="{{ $i }}" @if($i==$mes) selected="selected" @endif>{{ $m }}</option>
									@endforeach
								</select>
							</div>
							<div class="col s6">
								<select name="validade_ano">
									<option value="" selected="selected" disabled="disabled">Ano</option>
									@for($i = date('Y'); $i <= date('Y') + 20; $i ++)
										<option value="{{ $i }}" @if($i==$ano) selected="selected" @endif>{{ $i }}</option>
									@endfor
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer bordered">
			<button type="reset" class="btn white black-text lighten-1 modal-close">Fechar</button>
			<button type="submit" class="btn blue lighten-1">Adicionar</button>
		</div>
	</form>
</div>
