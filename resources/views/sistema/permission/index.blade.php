@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Permissões',
        'items' => [
            'Sistema' => ['sistema.home'],
            'Permissões' => null,
        ],
    ])
@stop

@section('content')
    <div class="btn-list mb-3">
        @include('utils.buttons.create', ['route' => 'sistema.permission'])
        @include('sistema.permission.search')
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        @include('utils.table.th', [
                            'title' => 'Nome',
                            'field' => 'nome',
                            'active' => true,
                        ])
                        @include('utils.table.th', [
                            'title' => 'Grupo: Subgrupo',
                            'field' => 'group',
                        ])
                        <th style="width: 100px">Rotas</th>
                        <th style="width: 80px"></th>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->nome }}</td>
                                <td>
                                    <b>{{ $permission->group }}: </b>
                                    {{ $permission->subGroup() }}
                                </td>
                                <td style="width: 100px">
                                    @include('sistema.permission.routes', [
                                        'routes' => collect(explode(', ', $permission->routes))->map(function ($route) {
                                                return ['name' => $route];
                                            })->toArray(),
                                        'id' => $permission->id,
                                    ])
                                </td>
                                <td style="width: 80px">
                                    <div class="btn-list">
                                        @include('utils.buttons.show', [
                                            'route' => 'sistema.permission',
                                            'params' => ['permission' => $permission->id],
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
    @include('utils.layout.pagination', ['items' => $permissions])
@stop
