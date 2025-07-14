@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Carteira',
        'items' => [
            'Carteiras' => ['carteira.index'],
            'Carteira' => null,
        ],
    ])
@stop

@section('content')
    <div class="card mb-3">
        <div class="card-header border-bottom-0">
            <div class="btn-list">
                @if ($carteira->ativada)
                    <button
                        class="btn btn-sm {{ session('layout_theme') === 'light-style' ? 'btn-outline-primary' : 'btn-primary' }}"
                        type="button" onclick="document.getElementById('desativar-carteria').submit()">
                        Desativar Carteira
                    </button>
                    <form id="desativar-carteria" method="POST" action="{{ route('carteira.desativar') }}">
                        @csrf
                        @method('PUT')
                    </form>
                @endif
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
