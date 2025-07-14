@extends('utils.search.index')

@section('search')
    <div class="form-group col-lg-6">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control" maxlength="45" placeholder="Nome"
            value="{{ $_GET['name'] ?? '' }}">
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label">Email</label>
        <input type="text" name="email" class="form-control" maxlength="45" placeholder="Email"
            value="{{ $_GET['email'] ?? '' }}">
    </div>
@stop
