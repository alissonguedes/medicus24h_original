@extends('admin.layouts.app')

@section('title', 'Usuários')

@section('content')

    <div class="responsive-table">

        <div class="top flex mb-1">

            <div class="actions action-btns flex flex-col align-itens-center">

                <div class="show-buttons">
                    <button type="button" class="btn btn-large waves-effect" data-href="{{ route('admin.usuarios.add') }}" data-tooltip="Adicionar">
                        <i class="material-icons">
                            add
                        </i>
                    </button>
                </div>

                <div class="hide-buttons">

                    {{-- <button class="btn btn-large waves-effect translator" data-link="{{ route('admin.dicionario') }}" data-tooltip="Traduzir" style="border: none">
                        <i class="material-icons">translate</i>
                    </button> --}}

                    <button class="btn btn-large update waves-effect" name="status" value="0" data-tooltip="" data-on="Bloquear" data-off="Desbloquear" data-link="{{ route('admin.usuarios.patch', 'status') }}" data-method="patch">
                        <i class="material-icons" data-on="lock" data-off="lock_open"></i>
                    </button>

                    <button class="btn btn-large excluir waves-effect" disabled="disabled" data-link="{{ route('admin.usuarios.delete') }}" style="border: none" data-tooltip="Excluir">
                        <i class="material-icons">delete_forever</i>
                    </button>

                    <div class="buttons selecteds-label white-text">
                    </div>

                </div>

            </div>

            <div class="clear">
            </div>

        </div>

        <div class="content">

            <table class="table dataTable no-footer" data-link="{{ route('admin.usuarios') }}">
                <thead>
                    <tr>
                        <th class="disabled sortable white-text" width="1%" data-orderable="false">
                            <label>
                                <input type="checkbox" class="amber" id="check-all">
                                <span> </span>
                            </label>
                        </th>
                        <th class="center-align white-text">Name</th>
                        <th class="center-align white-text">Grupo</th>
                        <th class="center-align white-text">Email</th>
                        <th class="center-align white-text">Ultimo Login</th>
                        <th class="center-align white-text center-align">Status</th>
                        <th class="disabled white-text center-align" data-orderable="false">Ação</th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>

@endsection
