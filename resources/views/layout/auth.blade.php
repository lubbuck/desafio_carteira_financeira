@extends('layout.base')

@section('body')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-between align-center">
                            <a href="{{ route('home') }}" class="app-brand-link gap-2">
                                <h3 class="text-center">{{ config('project.layout.name') }}</h3>
                            </a>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
