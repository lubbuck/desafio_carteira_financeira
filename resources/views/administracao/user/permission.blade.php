@extends('layout.page', ['sidebar' => 'administracao'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Selecionar Permissões do Usuário',
        'items' => [
            'Usuários' => ['administracao.user.index'],
            'Usuário' => ['administracao.user.show', ['user' => $user->id]],
            'Permissões' => null,
        ],
    ])
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include('administracao.user.card')
        </div>
        <div class="col-lg-9">
            <form action="{{ route('administracao.user.permission.update', ['user' => $user->id]) }}" method="post">
                @method('PUT')
                @if (auth()->user()->isSuperAdmin())
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="text-danger">
                                Atribuir Perfil de Super Administrador
                                @include('utils.form.infoIcon', [
                                    'msg' => 'Opção exibida apenas a outros Super Administradores',
                                ])
                            </h6>
                            @include('utils.form.error', ['param' => 'is_super_admin'])
                            <div class="form-group">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="is_super_admin"
                                            id="super-admin" value="true" {{ $user->isSuperAdmin() ? 'checked' : '' }}>
                                        <label class="form-check-label" for="super-admin">
                                            Permite o acesso a toda funcionalidade do sistema sem a necessidade de
                                            permissões
                                            especiais!
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->isAdmin())
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="text-warning">
                                Atribuir Perfil Administrativo ao Usuário
                                @include('utils.form.infoIcon', [
                                    'msg' => 'Opção exibida apenas a usuários com perfil administrativo',
                                ])
                            </h6>
                            @include('utils.form.error', ['param' => 'is_admin'])
                            <div class="form-group">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="is_admin" id="admin"
                                            value="true" {{ $user->isAdmin() ? 'checked' : '' }}>
                                        <label class="form-check-label" for="admin">
                                            <b>
                                                Permite o acesso às informações de forma completa mesmo quando há alguma
                                                restrição.
                                            </b>
                                        </label>
                                    </label>
                                    <div class="text-justify">
                                        (Exemplo: quando uma lista exibe apenas os dados cadastrados relacionados ao
                                        usuário logado. Neste caso, com o perfil administrativo ele pode
                                        ver tanto os dados relacionados a ele, quanto aos outros.)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <h6>
                    Permissões
                    @include('utils.form.infoIcon', [
                        'msg' => 'As permissões selecionadas determinam quais acessos o usuário terá no sistema',
                    ])
                </h6>
                @include('utils.form.error', ['param' => 'permissions'])
                @php
                    $groups = $permissions->groupBy('group')->sortKeys();
                    $oldPermissions =
                        !is_null(old('permissions')) && is_array(old('permissions')) ? old('permissions') : null;
                @endphp
                @forelse ($groups as $group => $sub_groups)
                    @php
                        $slug_group = Str::slug($group, '-');
                        $sub_groups = $sub_groups->groupBy('sub_group')->sortKeys();
                        $check_group = $sub_groups
                            ->flatten()
                            ->every(function ($permission, $key) use ($oldPermissions, $userPermissions) {
                                return !is_null($oldPermissions)
                                    ? in_array($permission->id, $oldPermissions)
                                    : $userPermissions->contains($permission);
                            });
                    @endphp
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="form-group">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" id="group-{{ $slug_group }}"
                                            class="form-check-input check_group" {{ $check_group ? 'checked' : '' }}>
                                        <label class="form-check-label" for="group-{{ $slug_group }}">
                                            <b>{{ $group }}</b>
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($sub_groups as $sub_group => $permissions)
                                @php
                                    $slug_sub_group = Str::slug($sub_group, '-');
                                    $check_sub_group = !is_null($oldPermissions)
                                        ? $permissions->count() ==
                                            $permissions->pluck('id')->intersect($oldPermissions)->count()
                                        : $permissions->count() == $permissions->intersect($userPermissions)->count();
                                @endphp
                                <div class="form-group mb-2">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                id="group-{{ $slug_group }}-sub_group-{{ $slug_sub_group }}"
                                                class="form-check-input check_sub_group group-{{ $slug_group }}"
                                                {{ $check_sub_group ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sub_group-{{ $slug_sub_group }}">
                                                <b>{{ $sub_group }}</b>
                                            </label>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-lg-4 mb-2">
                                            <div class="form-check"
                                                title="{{ $permission->descricao ?? 'Sem Descrição' }}">
                                                <input type="checkbox" id="permission-{{ $permission->id }}"
                                                    class="form-check-input check_permission group-{{ $slug_group }}-sub_group-{{ $slug_sub_group }} group-{{ $slug_group }}"
                                                    name="permissions[]" value="{{ $permission->id }}"
                                                    {{ !is_null($oldPermissions) ? (in_array($permission->id, $oldPermissions) ? 'checked' : '') : ($userPermissions->contains($permission) ? 'checked' : '') }}>
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->nome }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if (!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Nenhuma Permissão Cadastrada
                    </div>
                @endforelse
                @include('utils.buttons.submit')
            </form>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('.check_group').change(function() {
                var group = this.id.substr(6)
                $('.group-' + group).prop('checked', this.checked)
            })
        });

        $(".check_permission").click(function() {
            var index_group = this.className.lastIndexOf('group-') + 6
            var index_sub_group = this.className.indexOf('sub_group-') + 10
            var group = this.className.substr(index_group)
            var sub_group = this.className.substr(index_sub_group, index_group - index_sub_group - 7)

            $("#group-" + group + "-sub_group-" + sub_group).prop("checked", function() {
                return $(".group-" + group + "-sub_group-" + sub_group).length == $(
                        ".group-" + group + "-sub_group-" + sub_group +
                        ':checked')
                    .length;
            });

            $("#group-" + group).prop("checked", function() {
                return $(".group-" + group).length == $(
                        ".group-" + group +
                        ':checked')
                    .length;
            });
        });

        $('.check_sub_group').change(function() {
            var index_group = this.id.indexOf('group-') + 6
            var index_sub_group = this.id.indexOf('sub_group-') + 10
            var group = this.id.substr(index_group, index_sub_group - index_group - 11)
            var sub_group = this.id.substr(index_sub_group)

            $(".group-" + group + "-sub_group-" + sub_group).prop('checked', this.checked)

            $("#group-" + group).prop("checked", function() {
                return $(".group-" + group).length == $(
                        ".group-" + group +
                        ':checked')
                    .length;
            });
        })
    </script>
@endsection
