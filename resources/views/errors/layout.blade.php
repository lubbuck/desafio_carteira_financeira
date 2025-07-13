@extends('layout.blank')

@section('content')
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h1 class="display-1 mb-2 mx-2">Erro @yield('code')</h1>
            <h4 class="mb-4 mx-2 text-muted">@yield('message')</h4>
            <a href="{{ route('home') }}" class="btn btn-primary">Voltar ao Início</a>
        </div>
    </div>
@stop
