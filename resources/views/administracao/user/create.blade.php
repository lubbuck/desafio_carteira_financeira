@extends('layout.page', ['sidebar' => 'administracao'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Cadastrar Usuário',
        'items' => [
            'Usuários' => ['administracao.user.index'],
            'Cadastrar' => null,
        ],
    ])
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('administracao.user.store') }}">
                @include('administracao.user.form')
            </form>
        </div>
    </div>
@stop
