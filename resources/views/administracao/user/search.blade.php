@extends('utils.search.index', ['between' => true])

@section('search')
    <div class="form-group col-lg-6">
        <label class="form-label">Usuário</label>
        <input type="text" name="user" class="form-control" maxlength="45" placeholder="Nome do Usuário ou CPF"
            value="{{ $_GET['user'] ?? '' }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label">Email</label>
        <input type="text" name="email" class="form-control" maxlength="45" placeholder="Email"
            value="{{ $_GET['email'] ?? '' }}">
    </div>
@stop
