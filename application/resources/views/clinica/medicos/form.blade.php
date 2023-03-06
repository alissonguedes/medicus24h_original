<div id="modal_medico" class="modal modal-fixed-footer" data-dismissible="false">
	<form action="{{ go('clinica.medicos.post') }}" method="post" enctype="multipart/form-data" autocomplete="off" novalidade style="min-height: 400px;">

		@if(isset($row))
			<input type="hidden" name="_method" value="put">
			<input type="hidden" name="id" value="{{ $row->id }}">
		@endif

		<div class="modal-content">

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="nome" class="{{ isset($row) && $row->nome ? 'active' : null }}">Médico</label>
						<input type="text" name="nome" id="nome" value="{{ $row->nome ?? null }}" readonly="readonly">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<div class="input-field">
						<label for="cpf" class="{{ isset($row) && $row->crm ? 'active' : null }}">CPF</label>
						<input type="tel" name="cpf" id="cpf" class="is_cpf" value="{{ $row->cpf ?? null }}" readonly="readonly">
					</div>
				</div>
				<div class="col s12 m4 l4">
					<div class="input-field">
						<label for="rg" class="{{ isset($row) && $row->crm ? 'active' : null }}">RG</label>
						<input type="tel" name="rg" id="rg" value="{{ $row->rg ?? null }}" readonly="readonly">
					</div>
				</div>
				<div class="col s12 m4 l4">
					<div class="input-field">
						<label for="crm" class="{{ isset($row) && $row->crm ? 'active' : null }}">CRM</label>
						<input type="text" name="crm" id="crm" value="{{ $row->crm ?? null }}">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<div class="input-field">
						<label for="especialidade" class="active">Especialidade</label>
						<select name="especialidade" id="especialidade">
							<option value="" disabled selected>Informe a especialidade</option>
							@isset($especialidades)
								@foreach($especialidades as $especialidade)
									<option value="{{ $especialidade->id }}" {{ isset($row) && $especialidade->id==$row->id_especialidade ? 'selected=selected' : null }}>{{ $especialidade->especialidade }}</option>
								@endforeach
							@endisset
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<label for="status" class="active blue-text text-accent-1">Médico ativo</label>
					<div class="switch mt-3" id="status">
						<label>
							Off
							<input type="checkbox" name="status" id="status" value="1" {{ !isset($row) || ($row && $row->status == '1') ? 'checked=checked' : null }}>
							<span class="lever"></span>
							On
						</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 mt-4 mb-4">
					<h5>Clínicas de atendimento</h5>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m12 l12">
					<div class="input-field">

						@if(isset($empresas) )
							<table class="table dataTable" data-ajax="false">
								<thead>
									<tr data-disabled="true">
										<th class="sorting_disabled">
											<label class="grey-text text-darken-2 font-14 left">
												<input type="checkbox" name="check-all" id="check-all" class="filled-in">
												<span></span>
											</label>
										</th>
										<th class="sorting_disabled">Nome</th>
										<th class="sorting_disabled">CNPJ</th>
									</tr>
								</thead>
								<tbody>

									@foreach($empresas as $empresa)
										@if(isset($row))
											@php
												$checked = isset($row) && $empresa->id === $row->id_empresa ? 'checked=checked' : null;
											@endphp
										@endif
										<tr class="sorting_disabled" style="{{ $checked != null ? 'color: rgba(0, 0, 0, 0.4);' : null }}">
											<td class="sorting_disabled">
												<label>
													@php
														$getMedicoClinica = $issetMedicoClinica->getMedicoClinica($row->id, $empresa->id) ?? null;
														$getMedicoClinica = !is_null($getMedicoClinica) ? $empresa->id === $getMedicoClinica->id_empresa : null;
													@endphp
													<input type="checkbox" name="empresa[]" class="filled-in" value="{{ $empresa->id }}" data-status="{{ $empresa->status }}" {{ $checked ?? (!is_null($getMedicoClinica) ? 'checked=checked' : null ) }} {{ $checked != null ? 'disabled' : null }}>
													<span></span>
													@if($checked) <input type="hidden" name="empresa[]" value="{{ $empresa->id }}"> @endif
												</label>
											</td>
											<td class="sorting_disabled">{{ $empresa->titulo }}</td>
											<td class="sorting_disabled">{{ $empresa->cnpj }}</td>
										</tr>
									@endforeach

								</tbody>
							</table>
						@endif

					</div>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<button type="reset" class="btn modal-close white waves-effect mr-2" data-toggle="Voltar">
				<i class="material-icons black-text">arrow_back</i>
			</button>
			<button type="submit" class="btn green waves-effect" data-toggle="Salvar">
				<i class="material-icons">save</i>
			</button>
		</div>
	</form>
</div>
