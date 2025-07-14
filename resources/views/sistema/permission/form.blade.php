<div class="card mb-3">
    <div class="card-body">
        @include('utils.form.descricao')
        <div class="row">
            <div class="form-group col-lg-6">
                <label class="form-label">Nome *</label>
                <input type="text" class="form-control @if ($errors->has('nome')) is-invalid @endif"
                    value="{{ old('nome') ? old('nome') : $permission->nome ?? '' }}" name="nome" id="nome"
                    placeholder="Nome" aria-label="Nome" required>
                @include('utils.form.error', ['param' => 'nome'])
            </div>
            <div class="form-group col-lg-3">
                <label class="form-label">Grupo *</label>
                <input type="text" class="form-control @if ($errors->has('group')) is-invalid @endif"
                    value="{{ old('group') ? old('group') : $permission->group ?? '' }}" name="group" id="group"
                    placeholder="Grupo" aria-label="Grupo" required>
                @include('utils.form.error', ['param' => 'group'])
            </div>
            <div class="form-group col-lg-3">
                <label class="form-label">Subgrupo</label>
                <input type="text" class="form-control @if ($errors->has('sub_group')) is-invalid @endif"
                    value="{{ old('sub_group') ? old('sub_group') : $permission->sub_group ?? '' }}" name="sub_group"
                    id="sub_group" placeholder="Subgrupo" aria-label="Subgrupo">
                @include('utils.form.error', ['param' => 'sub_group'])
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Descrição</label>
            <input type="text" class="form-control @if ($errors->has('descricao')) is-invalid @endif"
                placeholder="Descrição" value="{{ old('descricao') ? old('descricao') : $permission->descricao ?? '' }}"
                aria-label="descricao" name="descricao">
            @include('utils.form.error', ['param' => 'descricao'])
        </div>
    </div>
</div>

<h5>Selecione as Rotas da Permissão</h5>
<small>Rotas riscadas estão utilizadas em outra Permissão</small>

@include('utils.form.error', ['param' => 'routes'])

@php
    $permission = $permission ?? null;
    $permitedRoutes = collect($permitedRoutes)->map(function ($sub_groups, $group) use ($registereds, $permission) {
        $sub_groups = collect($sub_groups)->map(function ($routes, $sub_group) use ($registereds, $permission, $group) {
            $routes = collect($routes)->map(function ($route) use ($registereds, $permission, $group, $sub_group) {
                $register = $registereds->first(function ($value, $key) use ($route) {
                    return $value->route_name == $route['name'];
                });

                $disable = $register && (is_null($permission) || $permission->id != $register->permission_id);
                $check = $register && !is_null($permission) && $permission->id == $register->permission_id;
                $class_check = !$disable
                    ? 'check_route group-' . $group . '-sub_group-' . $sub_group . ' group-' . $group
                    : '';
                $title_check =
                    'Rota: ' .
                    $route['name'] .
                    (!is_null($register) ? ' na Permissão: ' . $register->permission->nome : '');

                return [
                    'disable' => $disable,
                    'check' => $check,
                    'class_check' => $class_check,
                    'title_check' => $title_check,
                    'text_check' => $route['method'] . ': /' . $route['uri'],
                    'value_check' => $route['name'],
                    'id_check' => 'route-' . $route['name'],
                ];
            });

            $disable = $routes->every(function ($route) {
                return $route['disable'];
            });
            $check =
                !$disable &&
                $routes->count() ==
                    $routes
                        ->filter(function ($route) {
                            return $route['disable'] || $route['check'];
                        })
                        ->count();
            $class_check = !$disable ? 'check_sub_group group-' . $group : '';

            return [
                'routes' => $routes->toArray(),
                'disable' => $disable,
                'check' => $check,
                'class_check' => $class_check,
                'text_check' => $sub_group,
                'id_check' => 'group-' . $group . '-sub_group-' . $sub_group,
            ];
        });

        $disable = $sub_groups->every(function ($sub_group) {
            return $sub_group['disable'];
        });
        $check =
            !$disable &&
            $sub_groups->count() ==
                $sub_groups
                    ->filter(function ($sub_group) {
                        return $sub_group['disable'] || $sub_group['check'];
                    })
                    ->count();
        $class_check = !$disable ? 'check_group' : '';

        return [
            'sub_groups' => $sub_groups->toArray(),
            'disable' => $disable,
            'check' => $check,
            'class_check' => !$disable ? 'check_group' : '',
            'text_check' => $group,
            'id_check' => 'group-' . $group,
        ];
    });
@endphp

@forelse ($permitedRoutes as $group)
    @php
        $disable = $group['disable'];
        $check = $group['check'];
        $class_check = $group['class_check'];
        $text_check = $group['text_check'];
        $id_check = $group['id_check'];
        $sub_groups = $group['sub_groups'];
    @endphp

    <div class="card mb-3 accordion">
        <div class="card-header accordion-header {{ $disable ? 'collapsed' : '' }} border-0" id="headingOne"
            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $id_check }}"
            aria-controls="collapse-{{ $id_check }}" aria-expanded="true" role="button">
            <span class="accordion-header-text">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="form-check-input {{ $class_check }}" id="{{ $id_check }}"
                        {{ $disable ? 'disabled' : ($check ? 'checked' : '') }}>
                    <label class="form-check-label" for="{{ $id_check }}">
                        @if ($disable)
                            <s><b>{{ $text_check }}</b></s>
                        @else
                            <b>{{ $text_check }}</b>
                        @endif
                    </label>
                </label>
            </span>
            <span class="accordion-header-indicator"></span>
        </div>
        <div class="card-body collapse accordion__body {{ $disable ? '' : 'show' }}" id="collapse-{{ $id_check }}"
            aria-labelledby="headingOne" data-bs-parent="#accordion-one">
            @foreach ($sub_groups as $sub_group)
                @php
                    $disable = $sub_group['disable'];
                    $check = $sub_group['check'];
                    $class_check = $sub_group['class_check'];
                    $text_check = $sub_group['text_check'];
                    $id_check = $sub_group['id_check'];
                    $routes = $sub_group['routes'];
                @endphp
                <div class="form-group mb-2">
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-check-input {{ $class_check }}"
                                id="{{ $id_check }}" {{ $disable ? 'disabled' : ($check ? 'checked' : '') }}>
                            <label class="form-check-label" for="{{ $id_check }}">
                                @if ($disable)
                                    <s><b>{{ $text_check }}</b></s>
                                @else
                                    <b>{{ $text_check }}</b>
                                @endif
                            </label>
                        </label>
                    </div>
                </div>
                <div class="row">
                    @foreach ($routes as $route)
                        @php
                            $disable = $route['disable'];
                            $check = $route['check'];
                            $class_check = $route['class_check'];
                            $text_check = $route['text_check'];
                            $title_check = $route['title_check'];
                            $value_check = $route['value_check'];
                            $id_check = $route['id_check'];
                        @endphp
                        <div class="col-lg-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input {{ $class_check }}"
                                    id="{{ $id_check }}" value="{{ $value_check }}" name="routes[]"
                                    {{ $disable ? 'disabled' : ($check ? 'checked' : '') }}>
                                <label class="form-check-label" title="{{ $title_check }}" for="{{ $id_check }}">
                                    @if ($disable)
                                        <s>{{ $text_check }}</s>
                                    @else
                                        {{ $text_check }}
                                    @endif
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
    <div class="alert alert-outline-dark mt-3" role="alert">
        <b>Nenhuma Permissão Encontrada.</b>
    </div>
@endforelse

@include('utils.buttons.submit')

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('.check_group').change(function() {
                var group = this.id.substr(6)
                $('.group-' + group).prop('checked', this.checked)
            })
        });

        $(".check_route").click(function() {
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
