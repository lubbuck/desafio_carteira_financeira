@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Editar Permissão',
        'items' => [
            'Sistema' => ['sistema.home'],
            'Permissões' => ['sistema.permission.index'],
            'Permissão' => ['sistema.permission.show', ['permission' => $permission->id]],
            'Editar' => null,
        ],
    ])
@stop

@section('content')

    <form method="POST" action="{{ route('sistema.permission.update', ['permission' => $permission->id]) }}">
        @method('PUT')
        @include('sistema.permission.form')
    </form>

@stop
