@php
    $route = $route . '.index';
    $class = 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-primary' : 'btn-primary');
@endphp

@include('utils.buttons.link', [
    'title' => 'Ver Lista',
])
