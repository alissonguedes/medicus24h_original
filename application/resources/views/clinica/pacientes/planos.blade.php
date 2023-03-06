<table>
	<tbody>
		<tr id="{{ $convenio->id }}">

			<td class="center-align">
				{{-- <label>
					<input type="radio" name="plano_padrao" value="1">
					<i class="material-icons mt-1 pointer {{ null }}" data-tooltip="Convênio ativo">verified</i>
				<span class="hide"></span>
				</label> --}}
			</td>
			<td>{{ $convenio->descricao }}</td>
			<td>{{ $tipo->descricao }}</td>
			<td>{{ $acomodacao->descricao }}</td>
			<td>{{ $matricula }}</td>
			<td>{{ $validade['mes'] . '/' . $validade['ano'] }}</td>
			<td>

				<button type="button" id="{{ $convenio->id }}" data-url="{{ go('clinica.pacientes.editplano', $convenio->id) }}" class="btn btn-floating btn-small teal lighten-2 waves-effect mr-6" data-trigger="edit_plano">
					<i class="material-symbols-outlined">edit</i>
				</button>
				<button type="button" class="btn btn-floating btn-small red lighten-2 waves-effect">
					<i class="material-symbols-outlined">delete</i>
				</button>

				{? $planos_de_saude = json_encode(['id_convenio'=> $convenio->id, 'id_tipo'=> $tipo->id, 'id_acomodacao'=> $acomodacao->id, 'matricula'=> $matricula, 'validade_ano'=> $validade['ano'], 'validade_mes' => $validade['mes']]) ?}

				<input type="hidden" name="convenios[]" value="{{ $planos_de_saude }}">

			</td>

		</tr>
	</tbody>
</table>
