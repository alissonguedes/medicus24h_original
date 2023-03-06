<div id="form_plano_saude" class="modal modal-fixed-footer">

	<form action="{{ go('clinica.pacientes.addplano') }}" method="post" data-autoinitialize="false">

		<div class="modal-content">

			@if(isset($plano))
				<input type="hidden" name="id" value="{{ $plano->id }}">
				<input type="hidden" name="_method" value="put">
			@endif

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="id_plano">Convênio</label>
						<select name="id_plano" id="id_plano">
							<option value="" disabled="disabled" selected="selected">Informe o convênio</option>
							@if(isset($convenios))
								@foreach($convenios as $convenio)
									<option value="{{ $convenio->id }}" @if(isset($plano) && $convenio->id === $plano->id) selected="selected" @endif>{{ $convenio->descricao }}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="id_tipo_plano">Tipo do convênio</label>
						<select name="id_tipo_plano" id="id_tipo_plano" disabled="disabled" data-url="{{ go('clinica.convenios.autocomplete') }}">
							<option value="" disabled="disabled" selected="selected">Informe o tipo de convênio</option>
							{{-- @if(isset($tipo) )
								@foreach($tipo as $t)
									@if( isset($t->id))
										<option value="{{ $t->id }}" @if(isset($plano) && $t->id === $plano->id) selected="selected" @endif>{{ $t->descricao }} </option>
									@endif
								@endforeach
							@endif --}}
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="id_acomodacao">Tipo de acomodação</label>
						<select name="id_acomodacao" id="id_acomodacao">
							<option value="" disabled selected>Informe o tipo de acomodação</option>
							@if(isset($acomodacoes))
								@foreach($acomodacoes as $acomodacao)
									<option value="{{ $acomodacao->id }}" {{ isset($plano) && $acomodacao->id==$plano->id_acomodacao ? 'selected=selected' : null }}>{{ $acomodacao->descricao }}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m6 l6">
					<div class="input-field">
						<label for="matricula">Matrícula</label>
						<input type="text" name="matricula" id="matricula" value="{{ $row->matricula ?? null }}">
					</div>
				</div>
				{{--
			</div>

			<div class="row"> --}}
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
