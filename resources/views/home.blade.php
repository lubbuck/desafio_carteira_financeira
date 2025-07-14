@extends('layout.page', ['sidebar' => auth()->check() ? 'app' : null])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Início',
        'items' => [],
    ])
@stop

@section('content')
@endsection
