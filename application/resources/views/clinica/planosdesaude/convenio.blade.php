<div class="row">
	<div class="col s12 m6 l6 mt-3 mb-3 flex flex-center">
		<div class="switch mt-1 ml-0 mr-3">
			<label class="">
				<input type="checkbox" name="conveniado" id="conveniado" value="1">
				<span class="lever m-0"></span>
			</label>
		</div>
		<h6>
			<label for="conveniado" style="font-size: inherit; color: inherit;">Médicus24h</label>
		</h6>
	</div>
</div>

<div id="conv_medicus24h" class="row hide">
	<div class="col s12 m3 l3">
		<div class="input-field">
			<label for="tipo_convenio">Tipo do plano</label>
			<select name="tipo_convenio" id="tipo_convenio">
				<option value="" disabled selected>Informe o convênio</option>
				{{-- @foreach($convenios as $convenio)
					<option value="{{ $convenio->id }}" {{ $row && $convenio->id==$row->id_convenio ? 'selected=selected' : null }}>{{ $convenio->descricao }}</option>
				@endforeach--}}
			</select>
		</div>
	</div>
	<div class="col s12 m3 l3">
		<div class="input-field">
			<label for="carteira">Número da carteira</label>
			<input type="text" name="numero_carteira" value="{{ $row->numero_carteira ?? gera_cartao() }}">
		</div>
	</div>
	<div class="col s12 m3 l3">
		<div class="input-field">
			<label for="carteira">Validade</label>
			<input type="text" name="validade" value="{{ $row->validade ?? null }}" data-mask="date" data-format="mm/yyyy" readonly="readonly" style="background-image: linear-gradient(#d9d9d9, #d9d9d9), linear-gradient(#d9d9d9, #d9d9d9);">
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12 m6 l6 mt-3 mb-3 flex flex-center">
		<div class="switch mt-1 ml-0 mr-3">
			<label class="">
				<input type="checkbox" name="outro_convenio" id="outro_convenio" value="1">
				<span class="lever m-0"></span>
			</label>
		</div>
		<h6>
			<label for="outro_convenio" style="font-size: inherit; color: inherit;">Outro Convênio</label>
		</h6>
	</div>
</div>
<div id="conv_outro" class="row hide">
	<div class="col s12 m4 l4">
		<div class="input-field">
			<label for="convenio">Convênio</label>
			<select name="convenio" id="convenio">
				<option value="" disabled selected>Informe o convênio</option>
				@foreach($convenios as $convenio)
					<option value="{{ $convenio->id }}" {{ $row && $convenio->id==$row->id_convenio ? 'selected=selected' : null }}>{{ $convenio->descricao }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col s12 m4 l4">
		<div class="input-field">
			<label for="acomodacao">Acomodação</label>
			<select name="acomodacao" id="acomodacao">
				<option value="" disabled selected>Informe o tipo de acomodação</option>
				@foreach($acomodacoes as $acomodacao)
					<option value="{{ $acomodacao->id }}" {{ $row && $acomodacao->id==$row->id_acomodacao ? 'selected=selected' : null }}>{{ $acomodacao->descricao }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col s12 m3 l4">
		<div class="input-field">
			<label for="matricula">Matrícula</label>
			<input type="text" name="matricula" id="matricula" value="{{ $row->matricula_convenio ?? null }}">
		</div>
	</div>
	<div class="col s12 m3 l4">
		<div class="input-field">
			<label for="validade_convenio">Validade</label>
			<input type="text" name="validade_convenio" id="validade_convenio" value="{{ $row->validade_convenio ?? null }}" data-mask="date" data-min-date="{{ date('d/m/Y') }}">
		</div>
	</div>
</div>
