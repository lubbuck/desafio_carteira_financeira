@extends('utils.search.index', ['qtd' => false])

@section('search')
    <div class="form-group col-lg-4">
        <label class="form-label">Permissão</label>
        <input type="text" name="permission_nome" class="form-control" maxlength="45" placeholder="Permissão"
            value="{{ $_GET['permission_nome'] ?? '' }}">
    </div>
    <div class="form-group col-lg-4">
        <label class="form-label">Grupo</label>
        <input type="text" name="permission_group" class="form-control" maxlength="45" placeholder="Grupo"
            value="{{ $_GET['permission_group'] ?? '' }}">
    </div>
    <div class="form-group col-lg-4">
        <label class="form-label">SubGrupo</label>
        <input type="text" name="permission_sub_group" class="form-control" maxlength="45" placeholder="SubGrupo"
            value="{{ $_GET['permission_sub_group'] ?? '' }}">
    </div>
@stop
