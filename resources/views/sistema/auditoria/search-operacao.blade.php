@extends('utils.search.index')

@section('search')
    <div class="form-group col-lg-9">
        <label class="form-label">Operado por</label>
        <input type="text" name="user" class="form-control" maxlength="45" placeholder="Nome do usuário"
            value="{{ $_GET['user'] ?? '' }}">
    </div>
    <div class="form-group col-lg-3">
        <label class="form-label">Operação</label>
        <select class="form-control form-select" name="event">
            <option value="">
            </option>
            <option value="CREATED" {{ isset($_GET['event']) ? ($_GET['event'] === 'CREATED' ? 'selected' : '') : '' }}>
                CREATED
            </option>
            <option value="UPDATED" {{ isset($_GET['event']) ? ($_GET['event'] === 'UPDATED' ? 'selected' : '') : '' }}>
                UPDATED
            </option>
            <option value="DELETED" {{ isset($_GET['event']) ? ($_GET['event'] === 'DELETED' ? 'selected' : '') : '' }}>
                DELETED
            </option>
        </select>
    </div>
    <div class="form-group col-lg-5">
        <label class="form-label">Id da Tabela</label>
        <input type="text" name="table_id" class="form-control" placeholder="Id na Tabela"
            value="{{ $_GET['table_id'] ?? '' }}">
    </div>
    <div class="form-group col-lg-4">
        <label class="form-label">Tabela</label>
        <input type="text" name="table_name" class="form-control" maxlength="45" placeholder="Exemplo: users"
            value="{{ $_GET['table_name'] ?? '' }}">
    </div>
    <div class="form-group col-lg-3">
        <label class="form-label" for="created">No dia:</label>
        <input type="date" name="created" class="form-control"value="{{ $_GET['created'] ?? '' }}">
    </div>
@stop
