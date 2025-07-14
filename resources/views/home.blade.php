@extends('layout.page', ['sidebar' => auth()->check() ? 'app' : null])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Início',
        'items' => [],
    ])
@stop

@section('content')
    @if ($carteira)
        <div class="card">
            <div class="card-header border-bottom-0 d-sm-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Carteira Ativa
                </h5>
                @include('utils.buttons.show', [
                    'route' => 'carteira',
                    'params' => ['carteira' => $carteira->id],
                ])
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
        </div>
    @else
        @include('utils.layout.alert', [
            'text' => 'Cadastre uma cartera na aba ao lado',
            'color' => 'primary',
        ])
    @endif
@endsection
