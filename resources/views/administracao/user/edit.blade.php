@extends('layout.page', ['sidebar' => 'administracao'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Editar Conta do Usuário',
        'items' => [
            'Usuários' => ['administracao.user.index'],
            'Usuário' => ['administracao.user.show', ['user' => $user->id]],
            'Editar' => null,
        ],
    ])
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('administracao.user.update', ['user' => $user->id]) }}" method="post">
                @method('PUT')
                @include('administracao.user.form')
            </form>
        </div>
    </div>
@stop
