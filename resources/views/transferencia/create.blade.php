@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Transferir',
        'items' => [
            'Carteira' => ['carteira.show', ['carteira' => $carteira->id]],
            'Transferir' => null,
        ],
    ])
@stop

@section('content')
    @include('carteira.card')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('transferencia.store') }}">
                @include('utils.form.descricao')
                <div class="row mb-3">
                    <div class="form-group col-sm-4">
                        <label class="form-label">Valor (R$)</label>
                        <input type="text" class="form-control preco @if ($errors->has('valor')) is-invalid @endif"
                            name="valor" id="valor" aria-label="Valor" value="{{ old('valor') }}" required>
                        @include('utils.form.error', ['param' => 'valor'])
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="form-label" for="codigo">Código da Carteria de Destino *</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo"
                                id="codigo" value="{{ old('codigo') }}" placeholder="Digite o Código"
                                autocomplete="Código" autofocus required>
                            <div class="input-group-text">
                                <span class="bx bx-code"></span>
                            </div>
                        </div>
                        @include('utils.form.error', ['param' => 'codigo'])
                    </div>
                </div>
                @include('utils.buttons.submit')
            </form>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $(".preco").maskMoney({
                prefix: 'R$ ',
                defaultZero: true,
                affixesStay: false,
                thousands: '.',
                decimal: ','
            });
        });
    </script>
@stop
