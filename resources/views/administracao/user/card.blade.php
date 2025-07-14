<div class="card mb-3">
    <div class="card-header border-bottom-0 d-sm-flex justify-content-between align-items-center">
        <h5 class="card-title">
            Usuário
        </h5>
        @include('utils.buttons.show', [
            'route' => 'administracao.user',
            'params' => ['user' => $user->id],
        ])
    </div>
    <div class="card-body pt-0">
        <h4>
            {{ $user->name }}
        </h4>
        <div title="Email">
            <i class="fa fa-envelope mr-2 text-primary"></i>
            <span>{{ $user->email }}</span>
        </div>
    </div>
</div>
