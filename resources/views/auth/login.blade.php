@extends('layout.auth')

@section('title', ' Login -')

@section('content')
    <h2 class="mb-3"> Login </h2>
    <form method="POST" action="{{ route('login') }}">
        <div class="form-group mb-3">
            <label class="form-label" for="email">Email</label>
            <div class="input-group">
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    placeholder="Entre com email" autofocus autocomplete="email" value="{{ old('email') }}" required>
                <div class="input-group-text">
                    <span class="bx bx-envelope"></span>
                </div>
            </div>
            @include('utils.form.error', ['param' => 'email'])
        </div>
        <div class="form-group form-password-toggle mb-3">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Senha</label>
                <a href="{{ route('password.request') }}">
                    <small>Esqueceu sua Senha?</small>
                </a>
            </div>
            <div class="input-group">
                <input type="password" id="password" class="form-control" name="password" placeholder="Digite sua senha"
                    aria-describedby="password" required>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="form-group mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember-me">
                <label class="form-check-label" for="remember-me">
                    Lembrar-se
                </label>
            </div>
        </div>
        <div class="d-grid mb-3">
            @include('utils.buttons.submit', [
                'class' => 'btn btn-primary',
                'text' => 'Logar',
            ])
        </div>
        @if (Route::has('register'))
            <span>Não possui cadastro?</span>
            <a class="text-primary" href="{{ route('register') }}">Cadastre-se</a>
        @endif
    </form>
@endsection
