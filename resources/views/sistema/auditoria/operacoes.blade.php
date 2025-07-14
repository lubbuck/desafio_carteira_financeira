@extends('layout.page', ['sidebar' => 'sistema'])

@section('content_header')
    @include('utils.layout.contentHeader', [
        'title' => 'Auditoria das Operações',
        'items' => [
            'Sistema' => ['sistema.home'],
            'Operações' => null,
        ],
    ])
@stop

@section('content')
    <div class="mb-2">
        @include('sistema.auditoria.search-operacao')
    </div>
    @foreach ($auditorias as $auditoria)
        <div class="card mb-3">
            <div class="card-header d-sm-flex justify-content-between align-items-center pb-0 border-bottom-0">
                <h6 class="card-title text-muted">
                    {{ $auditoria->event }}
                </h6>
                @include('utils.buttons.audit-operacao', [
                    'params' => [
                        'table_name' => $auditoria->table_name,
                        'table_id' => $auditoria->table_id,
                    ],
                ])
            </div>
            <div class="card-body py-0">
                <h5>Tabela: <span class="text-primary">{{ $auditoria->table_name }}</span></h5>
                <div class="mb-2 text-justify" title="Navegador">
                    <b class="text-primary">URL: </b>
                    {{ $auditoria->url }}
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-2">
                            <b class="mr-2 text-primary">ID:</b>
                            <strong>{{ $auditoria->table_id }}</strong>
                        </div>
                        <div class="mb-2" title="Alterado por">
                            <i class="fa fa-user mr-2 text-primary"></i>
                            @if ($auditoria->user_id)
                                @include('utils.buttons.link', [
                                    'route' => 'administracao.user.show',
                                    'params' => ['user' => $auditoria->user_id],
                                    'class' => 'text-primary',
                                    'text' => $auditoria->username,
                                ])
                            @else
                                <span>Inserido por Seed</span>
                            @endif
                        </div>

                        <div class="mb-2 text-justify" title="Navegador">
                            <i class="fa fa-desktop mr-2 text-primary"></i>
                            {{ $auditoria->user_agent }}
                        </div>
                        <div class="mb-2" title="Endereço IP">
                            <i class="fa fa-wifi mr-2 text-primary"></i>
                            {{ $auditoria->ip_address }}
                        </div>
                        <div class="mb-2" title="Cadastrado em:">
                            <i class="fa fa-calendar mr-2 text-primary"></i>
                            {{ $auditoria->createdAt() }}
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <h5>Valores Inseridos</h5>
                        <div class="row">
                            @foreach ($auditoria->new_values as $key => $value)
                                <div class="col-lg-6 mb-2">
                                    @if (is_array($value))
                                        <a class="text-primary text-strong collapsed" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false"
                                            href="#audit-{{ $auditoria->id }}-{{ $key }}"
                                            aria-controls="audit-{{ $auditoria->id }}-{{ $key }}">
                                            <strong>{{ $key }}:</strong> <ins>Ver mais</ins>
                                        </a>
                                        <div class="collapse" id="audit-{{ $auditoria->id }}-{{ $key }}">
                                            @foreach ($value as $key_item => $item)
                                                <b>{{ $key_item }}:</b> {{ var_dump($item) }}
                                            @endforeach
                                        </div>
                                    @else
                                        <strong class="text-primary">{{ $key }}:</strong>
                                        <span class="text-justify">
                                            {{ var_dump($value) }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @include('utils.layout.pagination', ['items' => $auditorias])
@stop
