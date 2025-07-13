@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Minha Conta',
        'items' => [
            'Minha Conta' => null,
        ],
    ])
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="text-uppercase">
                {{ $user->name }}
            </h4>
            <h6>Dados Pessoais:</h6>
            <div class="row">
                <div class="col-lg-4" title="Email">
                    <i class="fa fa-envelope mr-2 text-primary"></i>
                    <span>{{ $user->email }}</span>
                </div>
            </div>
        </div>
    </div>
@stop
