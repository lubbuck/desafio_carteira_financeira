@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Cadastrar Permissão',
        'items' => [
            'Sistema' => ['sistema.home'],
            'Permissões' => ['sistema.permission.index'],
            'Cadastrar' => null,
        ],
    ])
@stop

@section('content')
    <form method="POST" action="{{ route('sistema.permission.store') }}">
        @include('sistema.permission.form')
    </form>
@stop
