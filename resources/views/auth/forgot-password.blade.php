@extends('layout.auth')

@section('title', ' Senha -')

@section('content')
    <h2 class="mb-3"> Login </h2>

    <p class="text-justify mb-3 ">Um email com o link para a recuperação da sua senha será enviado para seu email</p>

    @if (session()->get('status'))
        <div class="alert alert-success  text-center">
            {{ session('status') }}<br>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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
        <div class="d-grid mb-3">
            @include('utils.buttons.submit', [
                'class' => 'btn btn-primary',
                'text' => 'Enviar para email',
            ])
        </div>
    </form>
@endsection
