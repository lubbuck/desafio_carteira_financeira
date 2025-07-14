<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    CarteiraController
};

use App\Http\Controllers\Administracao\{
    HomeController as Administracao,
    CarteiraController as Administracao_CarteiraController
};

// todas as rotas NÃO LOGADO
Route::group([], function () {});

// todas as rotas da aplicação logado FORA do middleware de permissão
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'carteira'], function () {
        Route::get('/', [CarteiraController::class, 'index'])->name('carteira.index');
        Route::post('/store', [CarteiraController::class, 'store'])->name('carteira.store');
        Route::get('/show/{carteira}', [CarteiraController::class, 'show'])->name('carteira.show');
        Route::put('/desativar', [CarteiraController::class, 'desativar'])->name('carteira.desativar');
    });
});

// todas as rotas da aplicação logado DENTRO do middleware de permissão
Route::group(['middleware' => ['auth', 'permited']], function () {

    Route::group(['prefix' => 'administracao', 'as' => 'administracao.'], function () {
        Route::get('/', [Administracao::class, 'home'])->name('home');

        Route::group(['prefix' => 'carteira'], function () {
            Route::get('/show/{carteira}', [Administracao_CarteiraController::class, 'show'])->name('carteira.show');
        });
    });
});
