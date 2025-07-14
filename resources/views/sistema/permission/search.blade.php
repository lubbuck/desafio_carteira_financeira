@extends('utils.search.index')

@section('search')
    <div class="form-group col-lg-12">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" maxlength="45" placeholder="Nome"
            value="{{ $_GET['nome'] ?? '' }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label">Grupo</label>
        <input type="text" name="group" class="form-control" maxlength="45" placeholder="Grupo"
            value="{{ $_GET['group'] ?? '' }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label">Nome da Rota</label>
        <input type="text" name="route_name" class="form-control" maxlength="45" placeholder="Nome da Rota"
            value="{{ $_GET['route_name'] ?? '' }}">
    </div>
@stop
