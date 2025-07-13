@extends('layout.base')

@php
    $sidebar = $sidebar ?? null;
    $sidebar = config('project.sidebar.' . $sidebar);
    $hasSidebar = !is_null($sidebar);
@endphp

@section('body')
    <div class="layout-wrapper layout-content-navbar {{ $hasSidebar ? '' : 'layout-without-menu' }}">
        <div class="layout-container">
            @if ($hasSidebar)
                @include('layout.sections.sidebar.index', ['sidebar' => $sidebar])
            @endif
            <div class="layout-page">
                @include('layout.sections.navbar.index', ['hasSidebar' => $hasSidebar])
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div style="word-wrap: break-word">
                            @yield('content_header')
                            @include('utils.layout.alerts')
                            @yield('content')
                        </div>
                    </div>
                    @include('layout.sections.footer.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
@endsection
