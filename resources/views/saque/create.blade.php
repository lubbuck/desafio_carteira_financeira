@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Sacar',
        'items' => [
            'Carteira' => ['carteira.show', ['carteira' => $carteira->id]],
            'Sacar' => null,
        ],
    ])
@stop

@section('content')
    @include('carteira.card')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('saque.store') }}">
                @include('utils.form.descricao')
                <div class="row mb-3">
                    <div class="form-group col-sm-4">
                        <label class="form-label">Valor (R$)</label>
                        <input type="text" class="form-control preco @if ($errors->has('valor')) is-invalid @endif"
                            name="valor" id="valor" aria-label="Valor" value="{{ old('valor') }}" autofocus required>
                        @include('utils.form.error', ['param' => 'cpf'])
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
