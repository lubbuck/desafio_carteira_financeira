@include('utils.form.descricao')

@if (!isset($user))
    <div class="alert alert-alt alert-info alert-dismissible fade show" role="alert">
        A senha do login usuário será aleatória, podendo ser mudada posteriormente.
    </div>
@endif

<h6>Dados do Usuário</h6>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label" for="name">Nome *</label>
        <div class="input-group">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                value="{{ old('name') ? old('name') : $user->name ?? '' }}" placeholder="Digite o Nome"
                autocomplete="Nome" autofocus required>
            <div class="input-group-text">
                <span class="bx bx-user"></span>
            </div>
        </div>
        @include('utils.form.error', ['param' => 'name'])
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label" for="email">Email *</label>
        <div class="input-group">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') ? old('email') : $user->email ?? '' }}"
                placeholder="Digite o Email" required>
            <div class="input-group-text">
                <span class="bx bx-envelope"></span>
            </div>
        </div>
        @include('utils.form.error', ['param' => 'email'])
        @if ($errors->first('email') == 'Já existe esse dado cadastrado no sistema')
            @include('utils.buttons.link', [
                'route' => 'administracao.user.index',
                'text' => '/ Ver Usuário deste Email',
                'params' => ['email' => old('email')],
            ])
        @endif
    </div>
</div>

@include('utils.buttons.submit')
