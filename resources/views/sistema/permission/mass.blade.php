@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Atribuição em Massa da Permissão',
        'subtitle' => 'Todos os usuários encontrados serão atribuídos a permissão',
        'items' => [
            'Sistema' => ['sistema.home'],
            'Permissões' => ['sistema.permission.index'],
            'Permissão' => ['sistema.permission.show', ['permission' => $permission->id]],
            'Atribuição em Massa' => null,
        ],
    ])
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include('sistema.permission.card', ['permission' => $permission])
        </div>
        <div class="col-lg-9">
            <div class="btn-list mb-3">
                <a href="#" class="btn btn-sm btn-success"
                    onclick="event.preventDefault(); document.getElementById('form-mass-permission').submit();">
                    Atribuir Permissões
                </a>
                @include('sistema.permission.search-mass')
                <form id="form-mass-permission"
                    action="{{ route('sistema.permission.massUpdate', ['permission' => $permission->id] + $_GET) }}"
                    method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-hover mb-0">
                            <thead>
                                <th>Nome (CPF)</th>
                                <th>Permissões</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            {{ $user->name }} ({{ $user->email }})
                                        </td>
                                        <td>{{ $user->permissions }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('utils.layout.pagination', ['items' => $users])
        </div>
    </div>
@stop
