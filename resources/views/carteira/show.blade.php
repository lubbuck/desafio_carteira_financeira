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
                @include('utils.buttons.link', [
                    'route' => 'carteira.transferencias',
                    'params' => ['carteira' => $carteira->id],
                    'text' => 'Transferências',
                    'class' =>
                        'btn btn-sm ' .
                        (session('layout_theme') === 'light-style' ? 'btn-outline-info' : 'btn-info'),
                ])
                @include('utils.buttons.link', [
                    'route' => 'carteira.saques',
                    'params' => ['carteira' => $carteira->id],
                    'text' => 'Saques',
                    'class' =>
                        'btn btn-sm ' .
                        (session('layout_theme') === 'light-style' ? 'btn-outline-info' : 'btn-info'),
                ])
                @include('utils.buttons.link', [
                    'route' => 'carteira.depositos',
                    'params' => ['carteira' => $carteira->id],
                    'text' => 'Depósitos',
                    'class' =>
                        'btn btn-sm ' .
                        (session('layout_theme') === 'light-style' ? 'btn-outline-info' : 'btn-info'),
                ])
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
    <div class="row mb-3">
        <div class="col-lg-6">
            <h4>Entradas</h4>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 170px">Cadastrado em</th>
                                    <th style="width: 120px">Valor R$</th>
                                    <th>Operação</th>
                                    <th style="width: 100px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradas as $entrada)
                                    <tr>
                                        <td style="width: 170px">{{ $entrada->createdAt() }} </td>
                                        <td style="width: 120px">
                                            {{ $entrada->valor() }}
                                        </td>
                                        <td>
                                            {{ $entrada->tipoOperacao() }}
                                        </td>
                                        <td style="width: 100px">
                                            {{ $entrada->status() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('utils.layout.pagination', ['items' => $entradas])
        </div>
        <div class="col-lg-6">
            <h4>Saídas</h4>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 170px">Cadastrado em</th>
                                    <th style="width: 120px">Valor R$</th>
                                    <th>Operação</th>
                                    <th style="width: 100px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($saidas as $saida)
                                    <tr>
                                        <td style="width: 170px">{{ $saida->createdAt() }} </td>
                                        <td style="width: 120px">
                                            {{ $saida->valor() }}
                                        </td>
                                        <td>
                                            {{ $saida->tipoOperacao() }}
                                        </td>
                                        <td style="width: 100px">
                                            {{ $saida->status() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('utils.layout.pagination', ['items' => $saidas])
        </div>
    </div>
@stop
