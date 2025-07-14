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
            <div class="row mb-3">
                <div class="col-lg-3" title="Email">
                    <i class="fa fa-envelope mr-2 text-primary"></i>
                    <span>{{ $user->email }}</span>
                </div>
            </div>
        </div>
        @include('utils.layout.footerInfo', ['model' => $user])
    </div>
@stop
