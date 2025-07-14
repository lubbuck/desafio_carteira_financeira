<div class="modal fade" id="permissions" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Permissões
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <b class="text-primary">Perfil</b>
                <div class="ps-3">
                    <div>{{ $user->isAdmin() ? '' : 'Não ' }} Possui Perfil Administrativo</div>
                    @if (auth()->user()->isSuperAdmin() && $user->isSuperAdmin())
                        <div class="text-danger">Este usuário é Super Administrador</div>
                    @endif
                </div>
                <div>
                    <b class="text-primary">Permissões:</b>
                    @php
                        $groups = $permissions->groupBy('group')->sortKeys();
                    @endphp
                    <div class="ps-3">
                        @forelse ($groups as $group => $sub_groups)
                            @php
                                $sub_groups = $sub_groups->groupBy('sub_group')->sortKeys();
                            @endphp
                            <b class="text-primary">{{ $group }}</b>
                            <div class="ps-3">
                                @foreach ($sub_groups as $sub_group => $permissions)
                                    <b>{{ $sub_group }}</b>
                                    <div class="ps-3">
                                        @foreach ($permissions as $permission)
                                            <div>
                                                <i class="fa fa-check text-primary"></i>
                                                <span>{{ $permission->nome }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            Nenhuma Permissão Adicional Atribuída
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button class="btn btn-sm btn-outline-dark" id="button-permissions" data-bs-toggle="modal"
    data-bs-target="#permissions">
    Permissões
</button>
