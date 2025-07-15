<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    CarteiraController,
    DepositoController,
    DepositoReversaoController,
    SaqueController,
    TransferenciaController,
    SolicitacaoTransferenciaReversaoController,
    TransferenciaReversaoController
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
        Route::get('/show/{carteira}/depositos', [CarteiraController::class, 'depositos'])->name('carteira.depositos');
        Route::get('/show/{carteira}/saques', [CarteiraController::class, 'saques'])->name('carteira.saques');
        Route::get('/show/{carteira}/transferencias', [CarteiraController::class, 'transferencias'])->name('carteira.transferencias');
        Route::put('/desativar', [CarteiraController::class, 'desativar'])->name('carteira.desativar');
    });

    Route::group(['prefix' => 'deposito'], function () {
        Route::get('/create', [DepositoController::class, 'create'])->name('deposito.create');
        Route::post('/store', [DepositoController::class, 'store'])->name('deposito.store');

        Route::group(['prefix' => 'reversao'], function () {
            Route::post('/store/{deposito}', [DepositoReversaoController::class, 'store'])->name('deposito_reversao.store');
        });
    });

    Route::group(['prefix' => 'saque'], function () {
        Route::get('/create', [SaqueController::class, 'create'])->name('saque.create');
        Route::post('/store', [SaqueController::class, 'store'])->name('saque.store');
    });

    Route::group(['prefix' => 'transferencia'], function () {
        Route::get('/create', [TransferenciaController::class, 'create'])->name('transferencia.create');
        Route::post('/store', [TransferenciaController::class, 'store'])->name('transferencia.store');

        Route::group(['prefix' => 'reversao'], function () {
            Route::post('/store/{transferencia}', [TransferenciaReversaoController::class, 'store'])->name('transferencia_reversao.store');
        });

        Route::group(['prefix' => 'solicitacao-reversao'], function () {
            Route::get('/create/{transferencia}', [SolicitacaoTransferenciaReversaoController::class, 'create'])->name('solicitacao_transferencia_reversao.create');
            Route::post('/store/{transferencia}/store', [SolicitacaoTransferenciaReversaoController::class, 'store'])->name('solicitacao_transferencia_reversao.store');
        });
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
