@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Saques da Carteira',
        'items' => [
            'Carteira' => ['carteira.show', ['carteira' => $carteira->id]],
            'Saques' => null,
        ],
    ])
@stop

@section('content')
    @include('carteira.card')
    <h4>Saques</h4>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 170px">Cadastrado em</th>
                            <th>Valor R$</th>
                            <th style="width: 150px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saques as $saque)
                            <tr>
                                <td style="width: 170px">{{ $saque->createdAt() }} </td>
                                <td>
                                    {{ $saque->valor() }}
                                </td>
                                <td style="width: 180px">
                                    {{ $saque->status() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('utils.layout.pagination', ['items' => $saques])
@stop
