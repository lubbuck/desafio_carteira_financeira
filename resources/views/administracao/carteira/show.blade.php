@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Carteira',
        'items' => [
            'Usuário' => ['administracao.user.show', ['user' => $carteira->user_id]],
            'Carteira' => null,
        ],
    ])
@stop

@section('content')
    <div class="card">
        <div class="card-header border-bottom-0">
            <div class="btn-list">
                @include('utils.buttons.model', [
                    'model' => $carteira,
                    'route' => 'administracao.carteira',
                    'param' => 'carteira',
                ])
            </div>
        </div>
        <div class="card-body">
            <span class="text-primary">
                Situação
            </span>
            <h4 class="text-uppercase">
                {{ $carteira->situacao() }}
            </h4>
            <div>
                <b class="text-primary">Código:</b>
                <div class="text-justify">
                    {{ $carteira->codigo }}
                </div>
            </div>
        </div>
        @include('utils.layout.footerInfo', ['model' => $carteira])
    </div>
@stop
