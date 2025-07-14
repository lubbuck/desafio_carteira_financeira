@extends('layout.page', ['sidebar' => 'administracao'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Editar Senha do Usuário',
        'items' => [
            'Usuários' => ['administracao.user.index'],
            'Usuário' => ['administracao.user.show', ['user' => $user->id]],
            'Editar Senha' => null,
        ],
    ])
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include('administracao.user.card')
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('administracao.user.password.update', ['user' => $user->id]) }}" method="post">
                        @method('PUT')
                        @include('utils.form.descricao')
                        <div class="row mb-3">
                            <div class="form-group col-lg-4 @if ($errors->has('senha')) has-error @endif">
                                <Label class="form-label">
                                    Digite sua Senha *
                                    @include('utils.form.infoIcon', [
                                        'msg' => 'Informe a SUA SENHA',
                                    ])
                                </Label>
                                <input type="password" name="senha" class="form-control" required>
                                @include('utils.form.error', ['param' => 'senha'])
                            </div>
                            <div class="form-group col-lg-4 @if ($errors->has('password')) has-error @endif">
                                <Label class="form-label">
                                    Nova Senha *
                                    @include('utils.form.infoIcon', [
                                        'msg' => 'Informe uma nova senha para este usuário',
                                    ])
                                </Label>
                                <input type="password" name="password" class="form-control" required>
                                @include('utils.form.error', ['param' => 'password'])
                            </div>
                        </div>
                        @include('utils.buttons.submit')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
