@php
    $route = $route . '.create';
    $class = 'btn btn-sm ' . (session('layout_theme') === 'light-style' ? 'btn-outline-primary' : 'btn-primary');
@endphp

@include('utils.buttons.link', [
    'text' => $text ?? 'Cadastrar',
    'title' => 'Adicionar Novo Item',
])
