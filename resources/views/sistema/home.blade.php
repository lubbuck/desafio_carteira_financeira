@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Informações do Sistema',
        'items' => [
            'Sistema' => null,
        ],
    ])
@stop

@section('content')
    <h4 class="mb-3">
        Super Administradores do Sistema
    </h4>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        <th>Nome</th>
                        <th>Email</th>
                        <th style="width: 30px"></th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }} </td>
                                <td>{{ $user->email }} </td>
                                <td style="width: 30px">
                                    <div class="btn-list">
                                        @include('utils.buttons.show', [
                                            'route' => 'administracao.user',
                                            'params' => ['user' => $user->id],
                                        ])
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('utils.layout.pagination', ['items' => $users])
@stop
