@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Transferências da Carteira',
        'items' => [
            'Carteira' => ['carteira.show', ['carteira' => $carteira->id]],
            'Transferências' => null,
        ],
    ])
@stop

@section('content')
    @include('carteira.card')
    <h4>Transferências</h4>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-responsive-lg table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 170px">Cadastrado em</th>
                            <th style="width: 110px">Valor R$</th>
                            <th>Situação</th>
                            <th style="width: 150px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transferencias as $transferencia)
                            <tr>
                                <td style="width: 170px">{{ $transferencia->createdAt() }} </td>
                                <td style="width: 110px">
                                    {{ $transferencia->valor() }}
                                </td>
                                <td>
                                    {{ $transferencia->isOrigem($carteira->id)
                                        ? 'Enviado para ' . substr($transferencia->destino->codigo, 0, 10) . ' ...'
                                        : 'Recebido de para ' . substr($transferencia->origem->codigo, 0, 10) . ' ...' }}
                                    @if ($transferencia->solicitacaoReversao)
                                        <div class="modal fade" id="modal-solicitacao-reverter-{{ $transferencia->id }}"
                                            tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Solicitação de Reversão
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <b class="text-primary">Solicitação de Reversão de
                                                            Transferência</b>
                                                        <div class="text-justify">
                                                            {{ $transferencia->solicitacaoReversao->motivo }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-info"
                                            id="modal-button-solicitacao-reverter-{{ $transferencia->id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-solicitacao-reverter-{{ $transferencia->id }}">
                                            Solicitação de Reversão
                                        </button>
                                    @endif
                                    @if (is_null($transferencia->reversao))
                                        @if ($carteira->ativada)
                                            @if ($transferencia->isOrigem($carteira->id) && is_null($transferencia->solicitacaoReversao))
                                                @include('utils.buttons.create', [
                                                    'route' => 'solicitacao_transferencia_reversao',
                                                    'params' => ['transferencia' => $transferencia->id],
                                                    'text' => 'Solicitar Reversão',
                                                ])
                                            @endif
                                            @if ($transferencia->isDestino($carteira->id))
                                                <button
                                                    class="btn btn-sm {{ session('layout_theme') === 'light-style' ? 'btn-outline-primary' : 'btn-primary' }}"
                                                    type="button"
                                                    onclick="document.getElementById('{{ 'reverter-transferencia-' . $transferencia->id }}').submit()">
                                                    Reverter
                                                </button>
                                                <form id="{{ 'reverter-transferencia-' . $transferencia->id }}"
                                                    method="POST"
                                                    action="{{ route('transferencia_reversao.store', ['transferencia' => $transferencia->id]) }}">
                                                    @csrf
                                                </form>
                                            @endif
                                        @endif
                                    @else
                                        <span class="badge bg-warning">Revertido</span>
                                    @endif
                                </td>
                                <td style="width: 180px">
                                    {{ $transferencia->status() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('utils.layout.pagination', ['items' => $transferencias])
@stop
