@php
    $route = $route . '.download';
    $class = $class ?? 'btn btn-sm ' . (session('layout_theme') === 'light-style' ? 'btn-outline-info' : 'btn-info');
@endphp

@include('utils.buttons.link', [
    'title' => 'Baixar',
    'icon' => 'bx bx-download',
])
