@auth
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <i class="bx bx-user"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="{{ route('account.show') }}">
                    <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <a class="dropdown-item" href="{{ route('account.show') }}">
                <i class="bx bx-user text-primary me-2"></i>
                <span class="align-middle">Minha Conta</span>
            </a>
            <a class="dropdown-item" href="{{ route('account.edit') }}">
                <i class="bx bx-edit text-warning me-2"></i>
                <span class="align-middle">Editar Conta</span>
            </a>
            <a class="dropdown-item" href="{{ route('account.password') }}">
                <i class="bx bx-lock-open-alt text-danger me-2"></i>
                <span class="align-middle">Editar Senha</span>
            </a>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <a class="dropdown-item" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bx bx-power-off text-danger me-2"></i>
                <span class="align-middle">Sair</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </li>
@else
    <li class="nav-item lh-1 me-3">
        <a class="btn btn-primary" href="{{ route('login') }}" data-icon="octicon-star" data-size="large"
            data-show-count="true" aria-label="Login">
            Fazer Login
        </a>
    </li>
@endauth
