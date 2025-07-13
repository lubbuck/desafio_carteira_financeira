@php
    $route = $route . '.excel';
    $class =
        $class ??
        'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-success' : 'btn-success');
    $text = $text ?? 'Excel';
    $title = 'Baixar dados em Excel';
    $params = isset($params) ? array_merge($_GET, $params) : $_GET;
@endphp

@include('utils.buttons.link')
