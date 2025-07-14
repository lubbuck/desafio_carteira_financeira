<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/project.php';

use App\Http\Controllers\{
    HomeController,
    AccountController,
    Administracao\UserController
};

use App\Http\Controllers\Sistema\{
    HomeController as Sistema_Home,
    AuditoriaController,
    PermissionController
};

// Página inicial
Route::get('/', [HomeController::class, 'home'])->name('home');

// rotas do user logado gerir suas infos
Route::group(['prefix' => '/minha-conta', 'middleware' => ['auth']], function () {
    Route::get('/', [AccountController::class, 'show'])->name('account.show');
    Route::get('/editar', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/editar-senha', [AccountController::class, 'password'])->name('account.password');
    Route::put('/password/update', [AccountController::class, 'passwordUpdate'])->name('account.passwordUpdate');
});

// rotas de administracao dos users DENTRO do middleware de permissão
Route::group(['prefix' => '/administracao/user', 'as' => 'administracao.', 'middleware' => ['auth', 'permited']], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/show/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('user.update');
    // Route::post('/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/deleted', [UserController::class, 'deleted'])->name('user.deleted');
    Route::post('/restore/{user}', [UserController::class, 'restore'])->name('user.restore');
    // Route::get('/excel', [UserController::class, 'excel'])->name('user.excel');

    Route::get('/permission/{user}', [UserController::class, 'permission'])->name('user.permission.edit');
    Route::put('/permission/{user}/update', [UserController::class, 'permissionUpdate'])->name('user.permission.update');

    Route::get('/password/{user}', [UserController::class, 'password'])->name('user.password.edit');
    Route::put('/password/{user}/update', [UserController::class, 'passwordUpdate'])->name('user.password.update');
});

// rotas de gestão do sistema regradas por superadmin
Route::group(['prefix' => 'sistema', 'as' => 'sistema.', 'middleware' => ['auth', 'superadmin']], function () {
    Route::get('/', [Sistema_Home::class, 'index'])->name('home');

    Route::group(['prefix' => 'auditoria'], function () {
        Route::get('/operacoes', [AuditoriaController::class, 'operacoes'])->name('auditoria.operacoes');
        Route::get('/acessos', [AuditoriaController::class, 'acessos'])->name('auditoria.acessos');
    });

    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('/show/{permission}', [PermissionController::class, 'show'])->name('permission.show');
        Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('permission.update');
        Route::post('/destroy/{permission}', [PermissionController::class, 'destroy'])->name('permission.destroy');
        Route::get('/mass/{permission}', [PermissionController::class, 'mass'])->name('permission.mass');
        Route::post('/mass/{permission}/update', [PermissionController::class, 'massUpdate'])->name('permission.massUpdate');
    });

    Route::get('/toogle-super-admin', function () {
        session(['super_admin_visualization' => !session('super_admin_visualization')]);
        return redirect()->back();
    })->name('toogle');
});

Route::get('/toogle-layout-theme', function () {
    session(['layout_theme' => session('layout_theme') == 'dark-style' ? 'light-style' : 'dark-style']);
    return redirect()->back();
})->name('toogleTheme');

Route::fallback(function () {
    return view('errors.404');
});
