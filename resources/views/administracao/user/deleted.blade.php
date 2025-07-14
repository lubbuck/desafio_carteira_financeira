@extends('layout.page', ['sidebar' => 'administracao'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Usuários Apagados',
        'items' => [
            'Usuários' => ['administracao.user.index'],
            'Apagados' => null,
        ],
    ])
@stop

@section('content')
    <div class="btn-list mb-3">
        @include('utils.buttons.index', [
            'route' => 'administracao.user',
            'text' => 'Usuários',
        ])
        @include('administracao.user.search-nome_email')
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        @include('utils.table.th', [
                            'title' => 'Nome (CPF)',
                            'field' => 'user',
                            'active' => true,
                        ])
                        @include('utils.table.th', [
                            'title' => 'Email',
                            'field' => 'email',
                        ])
                        <th style="width: 80px"></th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td style="width: 80px">
                                    <div class="btn-list">
                                        @include('utils.buttons.restore', [
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
