<div class="card mb-3">
    <div class="card-header border-bottom-0 d-sm-flex justify-content-between align-items-center">
        <h5 class="card-title">
            Carteira {{ $carteira->ativada()}}
        </h5>
        @include('utils.buttons.show', [
            'route' => 'carteira',
            'params' => ['carteira' => $carteira->id],
        ])
    </div>
    <div class="card-body pt-0">
        <span class="text-primary">
            Situação
        </span>
        <h4 class="text-uppercase">
            {{ $carteira->saldo() }}
        </h4>
        <div>
            <b class="text-primary">Código:</b>
            <div class="text-justify">
                {{ $carteira->codigo }}
            </div>
        </div>
    </div>
</div>
