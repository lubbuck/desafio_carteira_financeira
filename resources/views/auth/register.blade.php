@extends('layout.auth')

@section('title', 'Registro -')

@section('content')
    <h2 class="mb-3">Registre-se </h2>
    <form method="POST" action="{{ route('register') }}">
        <div class="form-group mb-3">
            <label class="form-label" for="name">Nome</label>
            <div class="input-group">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    value="{{ old('name') }}" placeholder="Digite seu Nome" autocomplete="Nome" autofocus required>
                <div class="input-group-text">
                    <span class="bx bx-user"></span>
                </div>
            </div>
            @include('utils.form.error', ['param' => 'name'])
        </div>
        <div class="form-group mb-3">
            <label class="form-label">E-mail *</label>
            <div class="input-group">
                <input type="email" class="form-control  @if ($errors->has('email')) is-invalid @endif"
                    name="email" id="email" value="{{ old('email') }}" placeholder="Email" aria-label="Email"
                    name="email" required>
                <div class="input-group-text">
                    <span class="bx bx-envelope"></span>
                </div>
            </div>
            @include('utils.form.error', ['param' => 'email'])
        </div>
        <div class="form-group mb-3 form-password-toggle">
            <label class="form-label" for="password">Senha</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Digite a senha do usuário" aria-describedby="password" required>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            @include('utils.form.error', ['param' => 'password'])
        </div>
        <div class="form-group mb-3 form-password-toggle">
            <label class="form-label" for="password">Digite sua senha novamente</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
                    placeholder="Digite novamente a senha do usuário" aria-describedby="password_confirmation" required>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="d-grid mb-3">
            @include('utils.buttons.submit', [
                'class' => 'btn btn-primary',
                'text' => 'Logar',
            ])
        </div>
        <span>Já possui conta?</span>
        <a class="text-primary" href="{{ route('login') }}">Faça login</a>
    </form>
@endsection
