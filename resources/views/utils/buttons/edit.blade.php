@php
    $route = $route . '.edit';
    $class = 'btn btn-sm ' . (session('layout_theme') === 'light-style' ? 'btn-outline-warning' : 'btn-warning');
@endphp

@if (Route::has($route))
    @include('utils.buttons.link', [
        'title' => 'Editar este Registro',
        'icon' => 'bx bx-edit',
    ])
@endif
