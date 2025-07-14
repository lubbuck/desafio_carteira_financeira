@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Minha Conta',
        'items' => [
            'Minha Conta' => null,
        ],
    ])
@stop

@section('content')
    <div class="card">
        <div class="card-header border-bottom-0">
            @include('sistema.permission.user')
        </div>
        <div class="card-body pt-0">
            <h4 class="text-uppercase">
                {{ $user->name }}
            </h4>
            <h6>Dados Pessoais:</h6>
            <div class="row mb-3">
                <div class="col-lg-4" title="Email">
                    <i class="bx bx-envelope mr-2 text-primary"></i>
                    <span>{{ $user->email }}</span>
                </div>
            </div>
            <div>
                <h4 class="text-primary">Carteira:</h4>
                @if ($carteira)
                    <div>
                        <b class="text-primary">Código:</b>
                        <span>{{ $carteira->codigo }}</span>
                    </div>
                    <div>
                        <b class="text-primary">Saldo:</b>
                        <span>{{ $carteira->saldo() }}</span>
                    </div>
                @else
                    <div>
                        <span>Nenhuma Carteira Ativa</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
