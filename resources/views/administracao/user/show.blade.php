@extends('layout.page', ['sidebar' => 'administracao'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Usuário',
        'items' => [
            'Usuários' => ['administracao.user.index'],
            'Usuário' => null,
        ],
    ])
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="btn-list">
                        @include('sistema.permission.user')
                        @include('utils.buttons.auth', [
                            'model' => $user,
                            'route' => 'administracao.user',
                            'param' => 'user',
                        ])
                    </div>
                </div>
                <div class="card-body pt-0">
                    <h4 class="text-uppercase">
                        {{ $user->name }}
                    </h4>
                    <h6>Dados Pessoais:</h6>
                    <div class="mb-3" title="Email">
                        <i class="fa fa-envelope mr-2 text-primary"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                </div>
                @include('utils.layout.footerInfo', ['model' => $user])
            </div>
        </div>
        <div class="col-lg-9 mb-3">
            <h4>Carteiras</h4>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    @include('utils.table.th', [
                                        'title' => 'Cadastrado em',
                                        'field' => 'created',
                                        'start' => 'desc',
                                        'active' => true,
                                        'style' => 'width: 180px',
                                    ])
                                    @include('utils.table.th', [
                                        'title' => 'Código',
                                        'field' => 'codigo',
                                    ])
                                    @include('utils.table.th', [
                                        'title' => 'Situação',
                                        'style' => 'width: 180px',
                                    ])
                                    <th style="width: 80px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carteiras as $carteira)
                                    <tr>
                                        <td style="width: 180px">{{ $carteira->createdAt() }} </td>
                                        <td>
                                            {{ $carteira->codigo }}
                                        </td>
                                        <td>
                                            {{ $carteira->situacao() }}
                                        </td>
                                        <td style="width: 80px">
                                            @include('utils.buttons.show', [
                                                'route' => 'administracao.carteira',
                                                'params' => ['carteira' => $carteira->id],
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('utils.layout.pagination', ['items' => $carteiras])
        </div>
    </div>
@stop
