<div class="card mb-3">
    <div class="card-header border-bottom-0 d-sm-flex justify-content-between align-items-center">
        <h5 class="card-title">
            Permissão
        </h5>
        @include('utils.buttons.show', [
            'route' => 'sistema.permission',
            'params' => ['permission' => $permission->id],
        ])
    </div>
    <div class="card-body pt-0">
        <span class="text-muted"><b>{{ $permission->group }}</b>: {{ $permission->subGroup() }}</span>
        <h4>
            {{ $permission->nome }}
        </h4>
    </div>
</div>
