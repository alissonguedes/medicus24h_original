<table>
	<tbody>
		<tr id="<?php echo e($convenio->id); ?>">

			<td class="center-align">
				
			</td>
			<td><?php echo e($convenio->descricao); ?></td>
			<td><?php echo e($tipo->descricao); ?></td>
			<td><?php echo e($acomodacao->descricao); ?></td>
			<td><?php echo e($matricula); ?></td>
			<td><?php echo e($validade['mes'] . '/' . $validade['ano']); ?></td>
			<td>

				<button type="button" id="<?php echo e($convenio->id); ?>" data-url="<?php echo e(go('clinica.pacientes.editplano', $convenio->id)); ?>" class="btn btn-floating btn-small teal lighten-2 waves-effect mr-6" data-trigger="edit_plano">
					<i class="material-symbols-outlined">edit</i>
				</button>
				<button type="button" class="btn btn-floating btn-small red lighten-2 waves-effect">
					<i class="material-symbols-outlined">delete</i>
				</button>

				<?php  $planos_de_saude = json_encode(['id_convenio'=> $convenio->id, 'id_tipo'=> $tipo->id, 'id_acomodacao'=> $acomodacao->id, 'matricula'=> $matricula, 'validade_ano'=> $validade['ano'], 'validade_mes' => $validade['mes']])  ?>

				<input type="hidden" name="convenios[]" value="<?php echo e($planos_de_saude); ?>">

			</td>

		</tr>
	</tbody>
</table>
<?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/pacientes/planos.blade.php ENDPATH**/ ?>