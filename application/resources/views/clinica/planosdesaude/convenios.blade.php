@for($i = 1; $i <= 10; $i++)
	<tr>
		<td class="center-align">
			<label>
				<input type="radio" name="plano_padrao" value="1">
				<i class="material-icons mt-1 pointer {{ $i === 2 ? 'amber-text' : null }}" data-tooltip="Convênio ativo">verified</i>
				<span class="hide"></span>
			</label>
		</td>
		<td>Bradesco Saúde</td>
		<td>Saúde Top</td>
		<td>Quarto</td>
		<td> {{ gera_cartao(null, true) }} </td>
		<td>09/27</td>
		<td>

			<button type="button" data-url="{{ go('clinica.pacientes.editplano', $i) }}" id="{{ $i }}" class="btn btn-floating btn-small teal lighten-2 waves-effect mr-6" data-trigger="edit_plano">
				<i class="material-symbols-outlined">edit</i>
			</button>
			<button type="button" class="btn btn-floating btn-small red lighten-2 waves-effect">
				<i class="material-symbols-outlined">delete</i>
			</button>

			<input type="hidden" name="plano_convenio" value="">
			<input type="hidden" name="tipo_convenio" value="">
			<input type="hidden" name="acomodacao_convenio" value="">
			<input type="hidden" name="matricula_convenio" value="">
			<input type="hidden" name="validade_convenio" value="">

		</td>

	</tr>
@endfor
