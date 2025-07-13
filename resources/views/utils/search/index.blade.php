@php
    $type = isset($type) && $type === 'card' ? 'card' : 'modal';
@endphp

@extends('utils.search.' . $type)

@section('form')
    <div class="row">
        @yield('search')
    </div>
    @if (isset($between))
        <div class="row">
            <div class="form-group col-lg-6">
                <label class="form-label" for="created_from">Cadastrado a partir do dia:</label>
                <input type="date" name="created_from" id="created_from" value="{{ $_GET['created_from'] ?? '' }}"
                    class="form-control">
            </div>
            <div class="form-group col-lg-6">
                <label class="form-label" for="created_to">Cadastrado até o dia:</label>
                <input type="date" name="created_to" id="created_to" value="{{ $_GET['created_to'] ?? '' }}"
                    class="form-control">
            </div>
        </div>
    @endif
@stop

@section('buttons')
    <div class="form-group">
        @if (!isset($qtd) || $qtd)
            <div class="input-group">
                <input type="number" name="qtd" id="qtd" value="{{ $_GET['qtd'] ?? 100 }}" class="form-control"
                    step="50" min="100" max="1000">
                <div class="input-group-text">
                    <span>Itens</span>
                </div>
            </div>
        @endif
    </div>
    <div class="btn-list">
        <a href="{{ request()->url() }}" class="btn btn-sm btn-outline-dark">Redefinir</a>
        @include('utils.buttons.submit', ['text' => 'Pesquisar', 'csrf' => false])
    </div>
@stop
