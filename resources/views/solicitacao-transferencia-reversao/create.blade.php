@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Solicitar Reversão de Transferência',
        'items' => [
            'Carteira' => ['carteira.show', ['carteira' => $carteira->id]],
            'Solicitar Reversão de Transferência' => null,
        ],
    ])
@stop

@section('content')
    @include('carteira.card')
    <div class="card">
        <div class="card-body">
            @include('utils.form.descricao')
            <div class="row">
                <div class="col-lg-6">
                    <b class="text-primary">Valor Transferido:</b>
                    <div class="text-justify">
                        {{ $transferencia->valor() }}
                    </div>
                </div>
                <div class="col-lg-6">
                    <b class="text-primary">Transferido para:</b>
                    <div class="text-justify">
                        {{ $transferencia->destino->codigo }}
                    </div>
                </div>
            </div>
            <form method="POST"
                action="{{ route('solicitacao_transferencia_reversao.store', ['transferencia' => $transferencia->id]) }}">
                <div class="form-group mb-3">
                    <label class="form-label" for="motivo">Explique o motivo da Solicitação de Reversão *</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('motivo') is-invalid @enderror" name="motivo"
                            id="motivo" value="{{ old('motivo') }}" placeholder="Digite o Motivo" autocomplete="Motivo"
                            autofocus required>
                        <div class="input-group-text">
                            <span class="bx bx-code"></span>
                        </div>
                    </div>
                    @include('utils.form.error', ['param' => 'motivo'])
                </div>
                @include('utils.buttons.submit')
            </form>
        </div>
    </div>
@stop
