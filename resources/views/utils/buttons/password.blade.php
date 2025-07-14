@php
    $route = $route . '.password.edit';
    $class = 'btn btn-sm ' . (session('layout_theme') === 'light-style' ? 'btn-outline-warning' : 'btn-warning');
@endphp

@include('utils.buttons.link', [
    'title' => 'Editar Senha',
    'icon' => 'bx bx-lock-open',
])
