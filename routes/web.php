<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/project.php';

use App\Http\Controllers\{
    HomeController,
    AccountController,
};

Route::get('/', [HomeController::class, 'home'])->name('home');

// rotas do user logado gerir suas infos
Route::group(['prefix' => '/minha-conta', 'middleware' => ['auth']], function () {
    Route::get('/', [AccountController::class, 'show'])->name('account.show');
    Route::get('/editar', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/editar-senha', [AccountController::class, 'password'])->name('account.password');
    Route::put('/password/update', [AccountController::class, 'passwordUpdate'])->name('account.passwordUpdate');
});

Route::fallback(function () {
    return view('errors.404');
});
