@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Depositos da Carteira',
        'items' => [
            'Carteiras' => ['carteira.index'],
            'Depositos' => null,
        ],
    ])
@stop

@section('content')
    @include('carteira.card')
    <h4>Depóstios</h4>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 170px">Cadastrado em</th>
                            <th>Valor R$</th>
                            <th style="width: 150px">Status</th>
                            <th style="width: 80px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($depositos as $deposito)
                            <tr>
                                <td style="width: 170px">{{ $deposito->createdAt() }} </td>
                                <td>
                                    {{ $deposito->valor() }}
                                </td>
                                <td style="width: 180px">
                                    {{ $deposito->status() }}
                                </td>
                                <td style="width: 80px">
                                    @if (is_null($deposito->reversao))
                                        <button
                                            class="btn btn-sm {{ session('layout_theme') === 'light-style' ? 'btn-outline-primary' : 'btn-primary' }}"
                                            type="button"
                                            onclick="document.getElementById('{{ 'reverter-deposito-' . $deposito->id }}').submit()">
                                            Reverter
                                        </button>
                                        <form id="{{ 'reverter-deposito-' . $deposito->id }}" method="POST"
                                            action="{{ route('deposito.reverter', ['deposito' => $deposito->id]) }}">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    @else
                                        <span class="badge bg-warning">Revertido</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('utils.layout.pagination', ['items' => $depositos])
@stop
