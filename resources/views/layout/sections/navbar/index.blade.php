<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">

    @if ($hasSidebar)
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>
    @endif

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <li class="nav-item lh-1 me-3">
                <a href="{{ route('home') }}">Início</a>
            </li>
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @auth
                @each('layout.sections.navbar.navbar-item', config('project.navbar'), 'item')
            @endauth
            @include('layout.sections.navbar.auth-dropdown')
        </ul>
    </div>
</nav>
