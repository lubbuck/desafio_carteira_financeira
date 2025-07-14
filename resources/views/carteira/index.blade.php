@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Carteiras',
        'items' => [
            'Carteiras' => null,
        ],
    ])
@stop

@section('content')
    <div class="btn-list mb-3">
        <button class="btn btn-sm {{ session('layout_theme') === 'light-style' ? 'btn-outline-primary' : 'btn-primary' }}"
            type="button" onclick="document.getElementById('cadastrar-carteria').submit()">
            Cadastrar Carteira
        </button>
        <form id="cadastrar-carteria" method="POST" action="{{ route('carteira.store') }}">
            @csrf
        </form>
    </div>
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
                                        'route' => 'carteira',
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
@stop
