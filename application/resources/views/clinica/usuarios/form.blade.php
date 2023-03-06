@extends('clinica.layouts.forms')

@section('prev-url', route('clinica.pacientes.index'))

@if( !isset($paciente))
	{? $disabled = 'disabled="disabled"'; ?}
@endif

@section('topbar', '')

@php
	$disabled = null;
	$editavel = null;
	$input_label_hidden = null;
@endphp

@if(session()->get('userdata')[session()->get('app_session')]['id_grupo'] > 1)

	{? $disabled = isset($row) && $row->editavel === '0' ? 'disabled="disabled"' : false; ?}

	@if($disabled)
		{? $input_label_hidden = $row -> label; ?}
		{? $editavel = $row->editavel; ?}
	@else
		{? $editavel = 1; ?}
	@endif

@endif

@section('title', (isset($row) ? 'Editar' : 'Novo') . ' usuário')

@section('buttons')
@if(isset($row))
	<button class="btn btn-large excluir waves-effect" value="{{ isset($row) ? $row->id : null }}" data-tooltip="Excluir" data-link="{{ route('clinica.usuarios.delete') }}" style="border: none">
		<i class="material-icons">delete_forever</i>
	</button>
@endif
@endsection


@section('container')

<div class="container">

	<div class="row">

		<div class="col s12">

			<!-- BEGIN form -->
			<form novalidate action="{{ route('clinica.usuarios.post') }}" method="post" autocomplete="off">

				<div class="card">

					<div class="card-content no-padding">

						<div class="card-title pl-2 pt-2 pb-1">
							@yield('title'){{-- @if(isset($paciente))
							Editar: {{ $paciente->nome }}
						@else
							Cadastrar Usuário
							@endif
							<div id="tarefas" class="activator"></div> --}}
						</div>

						<div class="card-body fixed-height border-top scroller pt-3 pb-4" data-hide-x="true" style="height: calc(100vh - 250px);">

							<div class="row">

								<div class="col s12 m10 l10 offset-m2 offset-l1">

									<!-- BEGIN Input[Nome] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">person</i>
												<input type="text" name="nome" id="nome" value="{{ isset($row) ? $row->nome : null }}" autofocus="autofocus">
												<label class="grey-text" for="nome"> Nome </label>
											</div>
										</div>
									</div>
									<!-- END Input[Nome] -->

									<!-- BEGIN Input[Login] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">account_circle</i>
												<input type="text" name="login" id="login" value="{{ isset($row) ? $row->login : null }}">
												<label class="grey-text" for="login"> Login </label>
											</div>
										</div>
									</div>
									<!-- END Input[Login] -->

									<!-- BEGIN Select[Grupo] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">group</i>
												<select name="grupo">
													<option value="" disabled="disabled" {{ !isset($row) ? 'selected="selected"' : null }}> Selecione um grupo</option>
													@foreach($grupos as $grupo)
														<option value="{{ $grupo->id }}" {{ isset($row) && $grupo->id == $row->id_grupo ? 'selected="selected"' : null }} data-icon=""> {{ $grupo->grupo }} </option>
													@endforeach
												</select>
												<label>Grupo</label>
											</div>
										</div>
									</div>
									<!-- END Select[Grupo]-->

									<!-- BEGIN Input[Email] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">email</i>
												<input type="email" name="email" value="{{ isset($row) ? $row->email : null }}" id="email">
												<label class="grey-text" for="email"> E-mails </label>
											</div>
										</div>
									</div>
									<!-- END Input[Email] -->

									<!-- BEGIN Input[Senha] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="input-field">
												<i class="material-icons prefix">vpn_key</i>
												<input type="password" name="senha" id="senha">
												<label class="grey-text" for="senha"> Senha </label>
											</div>
										</div>
									</div>
									<!-- END Input[Senha] -->

									<!-- BEGIN Input[Status] -->
									<div class="row">
										<div class="col s12 mb-1">
											<div class="label-buttons right">
												<label class="left" data-tooltip="Bloquear">
													<input type="checkbox" name="status" value="0" {{ isset($row) && $row->status === '0' ? 'checked="checked"' : null }}>
													<i class="material-icons" style="width: auto !important;">lock</i>
												</label>
											</div>
										</div>
									</div>
									<!-- END Input[Status] -->

								</div>

							</div>

						</div>

					</div>

					<div class="card-action right-align">

						<button type="reset" class="btn white black-text waves-effect mr-2" data-tooltip="Voltar" data-href="{{ go('clinica.usuarios.index') }}">
							<i class="material-icons-outlined">arrow_back</i>
						</button>

						<button type="submit" class="btn green waves-effect" data-tooltip="Salvar">
							<i class="material-icons-outlined">save</i>
						</button>

						<input type="hidden" name="acao" value="login">
						<input type="hidden" name="id" value="{{ isset($row) ? $row->id : null }}">
						<input type="hidden" name="_method" value="{{ isset($row) ? 'put' : 'post' }}">

						@if(!isset($row))
							<input type="hidden" name="editavel" value="{{ $editavel }}">
						@endif

						<input type="hidden" name="dicionario" value="{{ isset($row) ? $row->id_dicionario : null }}">
						{{ $input_label_hidden }}

					</div>

				</div>

			</form>
			<!-- END form -->

		</div>

	</div>

</div>

@endsection
