@if (isset($item['header']))
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ $item['header'] }}</span>
    </li>
@else
    @php
        $outside = $item['outside'] ?? false;
        $submenu = $item['submenu'] ?? false;
        $item['classActive'] = '';
        if ($submenu) {
            $route = 'javascript:void(0);';
        } elseif ($outside) {
            $route = $item['route'];
        } else {
            $item['classActive'] = request()->routeIs($item['route']) ? 'active' : '';
            $route = route($item['route']);
        }
    @endphp
    <li class="menu-item {{ $item['classActive'] }}">

        <a href="{{ $route }}" class="menu-link {{ $submenu ? ' menu-toggle ' : '' }}"
            @if (isset($item['target'])) target="__blank" @endif>
            <i class="menu-icon {{ $item['icon'] ?? '' }}"></i>
            <div class="text-truncate">{{ $item['name'] }}</div>
            {{-- <span class="badge badge-center bg-primary ms-auto"></span> --}}
        </a>
        @if ($submenu)
            <ul class="menu-sub">
                @each('layout.sections.sidebar.sidebar-item', $item['submenu'], 'item')
            </ul>
        @endif
    </li>
@endif
