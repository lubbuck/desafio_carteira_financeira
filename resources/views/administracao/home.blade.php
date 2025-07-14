@extends('layout.page', ['sidebar' => 'administracao'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Dashboard do Administrador',
        'items' => [
            'Administração' => null,
        ],
    ])
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="widget-stat card">
                <div class="card-body p-4">
                    <div class="media ai-icon">
                        <span class="me-3 bgl-primary text-primary">
                            <i class='bx bx-group text-primary'></i>
                        </span>
                        <div class="media-body">
                            <p class="mb-1">Usuários</p>
                            <h4 class="mb-0">{{ $users }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
