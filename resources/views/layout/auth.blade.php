@extends('layout.base')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('body')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-between align-center">
                            <a href="{{ route('home') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset(config('project.layout.' . ($layout_theme === 'light-style' ? 'logo' : 'logoDark'))) }}"
                                        alt="" width="200">
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder">
                                </span>
                            </a>
                            @include('utils.buttons.toggleTheme')
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
