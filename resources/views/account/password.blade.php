@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Editar Minha Senha',
        'items' => [
            'Minha Conta' => ['account.show'],
            'Editar' => null,
        ],
    ])
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('account.passwordUpdate') }}">
                @method('PUT')
                @include('utils.form.descricao')
                <div class="row mb-3">
                    <div class="form-group col-lg-4 @if ($errors->has('senha')) has-error @endif">
                        <Label class="form-label">Digite sua Senha *</Label>
                        <input type="password" name="senha" class="form-control" required>
                        @include('utils.form.error', ['param' => 'senha'])
                    </div>
                    <div class="form-group col-lg-4 @if ($errors->has('password')) has-error @endif">
                        <Label class="form-label">Nova Senha *</Label>
                        <input type="password" name="password" class="form-control" required>
                        @include('utils.form.error', ['param' => 'password'])
                    </div>
                    <div class="form-group col-lg-4">
                        <Label class="form-label">Repetir Nova Senha *</Label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                @include('utils.buttons.submit')
            </form>
        </div>
    </div>
@stop
