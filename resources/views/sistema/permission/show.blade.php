@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Permissão',
        'items' => [
            'Sistema' => ['sistema.home'],
            'Permissões' => ['sistema.permission.index'],
            'Permissão' => null,
        ],
    ])
@stop

@section('content')
    <div class="card mb-3">
        <div class="card-header border-bottom-0">
            <div class="btn-list">
                @include('sistema.permission.routes')
                @include('utils.buttons.link', [
                    'route' => 'sistema.permission.mass',
                    'params' => ['permission' => $permission->id],
                    'text' => 'Atribuir aos Usuários',
                    'class' =>
                        'btn btn-sm ' .
                        (session('layout_theme') === 'light-style' ? 'btn-outline-primary' : 'btn-primary'),
                ])
                @include('utils.buttons.model', [
                    'model' => $permission,
                    'route' => 'sistema.permission',
                    'param' => 'permission',
                ])
            </div>
        </div>
        <div class="card-body pt-0">
            <span class="text-muted"><b>{{ $permission->group }}</b>: {{ $permission->subGroup() }}</span>
            <h4>
                {{ $permission->nome }}
            </h4>
            <div>
                <b class="text-primary">Descrição</b>
                <div class="text-justify">
                    {{ $permission->descricao ?? 'Sem Descrição' }}
                </div>
            </div>
        </div>
        @include('utils.layout.footerInfo', ['model' => $permission])
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h4>Usuários</h4>
        @include('administracao.user.search-nome_email')
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        @include('utils.table.th', [
                            'title' => 'Nome',
                            'field' => 'name',
                            'active' => 'true',
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
                                <td>{{ $user->name }} </td>
                                <td>{{ $user->email }} </td>
                                <td style="width: 80px">
                                    @include('utils.buttons.show', [
                                        'route' => 'administracao.user',
                                        'params' => ['user' => $user->id],
                                    ])
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
