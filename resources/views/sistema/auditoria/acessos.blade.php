@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Auditorias dos Acessos',
        'items' => [
            'Sistema' => ['sistema.home'],
            'Acessos' => null,
        ],
    ])
@stop

@section('content')
    <div class="mb-2">
        @include('sistema.auditoria.search-acesso')
    </div>
    <div class="row">
        @foreach ($acessos as $acesso)
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-sm-flex justify-content-between align-items-center pb-0 border-bottom-0">
                        <h6 class="card-title text-muted">
                            {{ $acesso->event }}
                        </h6>
                        @include('utils.buttons.audit-acesso', [
                            'params' => ['user_id' => $acesso->user_id],
                        ])
                    </div>
                    <div class="card-body py-0">
                        <div class="mb-2" title="Cadastrado em:">
                            <i class="fa fa-calendar mr-2 text-primary"></i>
                            {{ $acesso->createdAt() }}
                        </div>
                        <div class="mb-2 text-justify" title="Alterado por">
                            <i class="fa fa-user mr-2 text-primary"></i>
                            @include('utils.buttons.link', [
                                'route' => 'administracao.user.show',
                                'params' => ['user' => $acesso->user_id],
                                'class' => 'text-primary',
                                'text' => $acesso->username,
                            ])
                        </div>
                        <div class="mb-2 text-justify" title="Navegador">
                            <i class="fa fa-desktop mr-2 text-primary"></i>
                            {{ $acesso->user_agent }}
                        </div>
                        <div class="mb-2" title="Endereço IP">
                            <i class="fa fa-wifi mr-2 text-primary"></i>
                            {{ $acesso->ip_address }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('utils.layout.pagination', ['items' => $acessos])
@stop
