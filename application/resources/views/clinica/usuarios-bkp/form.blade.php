@extends('admin.layouts.form')

@php
$disabled = null;
$editavel = null;
$input_label_hidden = null;
@endphp

@if (session()->get('userdata')['id_grupo'] > 1)

    {? $disabled = isset($row) && $row->editavel === '0' ? 'disabled="disabled"' : false; ?}

    @if ($disabled)
        {? $input_label_hidden = $row -> label; ?}
        {? $editavel = $row->editavel; ?}
    @else
        {? $editavel = 1; ?}
    @endif

@endif

@section('title', (isset($row) ? 'Editar' : 'Novo') . ' usuário')

@section('buttons')
    @if (isset($row))
        <button class="btn btn-large excluir waves-effect" value="{{ isset($row) ? $row->id : null }}" data-tooltip="Excluir" data-link="{{ route('admin.usuarios.delete') }}" style="border: none">
            <i class="material-icons">delete_forever</i>
        </button>
    @endif
@endsection

@section('form')

    <!-- BEGIN form -->
    <form novalidate action="{{ route('admin.usuarios.insert') }}" method="post" autocomplete="off">

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
                        @foreach ($grupos as $grupo)
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

        <div class="row">

            <div class="col s12 mt-3">

                <button type="submit" class="btn inverse btn-small right waves-effect">
                    <i class="material-icons left">save</i> Salvar
                </button>
                <button type="reset" data-action="back" class="btn btn-small right mr-2 waves-effect">
                    <i class="material-icons left">arrow_back</i> Cancelar
                </button>

                <input type="hidden" name="acao" value="login">
                <input type="hidden" name="id" value="{{ isset($row) ? $row->id : null }}">
                <input type="hidden" name="_method" value="{{ isset($row) ? 'put' : 'post' }}">

                @if (!isset($row))
                    <input type="hidden" name="editavel" value="{{ $editavel }}">
                @endif

                <input type="hidden" name="dicionario" value="{{ isset($row) ? $row->id_dicionario : null }}">
                {{ $input_label_hidden }}

            </div>

        </div>

    </form>
    <!-- END form -->

@endsection
