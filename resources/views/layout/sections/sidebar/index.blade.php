<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{ config('project.layout.name') }}
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    @php
        $sidebar = \Dds\Classes\OrganizaSidebar::sidebar($sidebar);
    @endphp
    <ul class="menu-inner py-1">
        @each('layout.sections.sidebar.sidebar-item', $sidebar, 'item')
    </ul>
</aside>
