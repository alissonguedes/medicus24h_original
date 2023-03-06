@section('left-sidebar')
<div class="row">
	<div id="agendamento" class="form-sidenav col s6" data-dismissible="false" data-edge="right" data-backdrop="false">
		<div class="row">
			<div class="col s5">
				<div class="container no-padding scroller" style="overflow: auto; height:calc(100vh - 64px);">
					<br> local do atendimento
					<br> - local da clínica
					<br> Nome do médico
					<br> - nome do médico
					<br> Horário do agendamento
					<br> - Horário.
					<br> Repetição do evento
					<br> dias da semana
					<br> frequência:
					<br> - diariamente;
					<br> - semanalmente;
					<br> - quinzenalmente;
					<br> - mensalmente.
					<br> Até uma data específica
					<br> Quantidade de atendimentos.
				</div>
			</div>
			<div class="col s7">
				<div class="container no-padding scroller" style="overflow: auto; height:calc(100vh - 64px);">
					<div class="row">
						<div class="col s12">
							<div class="input-field">
								<label for="paciente">Paciente</label>
								<input type="text" name="paciente" id="paciente" value="{{ $row->nome ?? null }}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
