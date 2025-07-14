@extends('layout.page', ['sidebar' => auth()->check() ? 'app' : null])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Início',
        'items' => [],
    ])
@stop

@section('content')
    @if ($carteira)
        @include('carteira.card')
    @else
        @include('utils.layout.alert', [
            'text' => 'Cadastre uma cartera na aba ao lado',
            'color' => 'primary',
        ])
    @endif
@endsection
