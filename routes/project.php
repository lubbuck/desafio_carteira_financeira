<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Administracao\{
    HomeController as Administracao,
};

// todas as rotas NÃO LOGADO
Route::group([], function () {});

// todas as rotas da aplicação logado FORA do middleware de permissão
Route::group(['middleware' => ['auth']], function () {});

// todas as rotas da aplicação logado DENTRO do middleware de permissão
Route::group(['middleware' => ['auth', 'permited']], function () {

    Route::group(['prefix' => 'administracao', 'as' => 'administracao.'], function () {
        Route::get('/', [Administracao::class, 'home'])->name('home');
    });
});
