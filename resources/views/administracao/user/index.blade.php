@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Usuários',
        'items' => [
            'Usuários' => null,
        ],
    ])
@stop

@section('content')
    <div class="btn-list mb-3">
        @include('utils.buttons.create', ['route' => 'administracao.user'])
        @include('administracao.user.search')
        {{-- @include('utils.buttons.excel', ['route' => 'administracao.user'])
        @include('utils.buttons.deleted', ['route' => 'administracao.user']) --}}
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            @include('utils.table.th', [
                                'title' => 'Nome (CPF)',
                                'field' => 'user',
                                'active' => true,
                            ])
                            @include('utils.table.th', [
                                'title' => 'Email',
                                'field' => 'email',
                            ])
                            @include('utils.table.th', [
                                'title' => 'Cadastrado em',
                                'field' => 'created',
                                'start' => 'desc',
                                'style' => 'width: 170px',
                            ])
                            <th style="width: 80px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }} </td>
                                <td style="width: 170px">{{ $user->createdAt() }} </td>
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
