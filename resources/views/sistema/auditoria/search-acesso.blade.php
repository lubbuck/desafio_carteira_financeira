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
            <option value="LOGIN" {{ isset($_GET['event']) ? ($_GET['event'] === 'LOGIN' ? 'selected' : '') : '' }}>
                LOGIN
            </option>
            <option value="LOGOUT" {{ isset($_GET['event']) ? ($_GET['event'] === 'LOGOUT' ? 'selected' : '') : '' }}>
                LOGOUT
            </option>
        </select>
    </div>
    <div class="form-group col-lg-3">
        <label class="form-label" for="created">No dia:</label>
        <input type="date" name="created" class="form-control"value="{{ $_GET['created'] ?? '' }}">
    </div>
@stop
