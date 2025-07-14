@php
    $route = $route . '.show';
    $class = 'btn btn-sm ' . (session('layout_theme') === 'light-style' ? 'btn-outline-info' : 'btn-info');
@endphp

@include('utils.buttons.link', [
    'title' => 'Ver este Registro',
    'icon' => 'bx bx-search',
])
