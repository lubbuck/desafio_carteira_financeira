@extends('layout.page', ['sidebar' => 'app'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Editar Minha Conta',
        'items' => [
            'Minha Conta' => ['account.show'],
            'Editar' => null,
        ],
    ])
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('account.update') }}">
                @method('PUT')
                @include('utils.form.descricao')
                <div class="form-group mb-3">
                    <label class="form-label" for="name">Nome *</label>
                    <div class="input-group">
                        <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif"
                            name="name" id="name" value="{{ $user->name }}" placeholder="Digite seu Nome"
                            autocomplete="Nome" autofocus required>
                        <div class="input-group-text">
                            <span class="bx bx-user"></span>
                        </div>
                    </div>
                    @include('utils.form.error', ['param' => 'name'])
                </div>
                @include('utils.buttons.submit')
            </form>
        </div>
    </div>
@stop
