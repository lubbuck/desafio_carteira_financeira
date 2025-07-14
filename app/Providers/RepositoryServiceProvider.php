<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\Repositories\{
    UserRepositoryInterface,
    CarteiraRepositoryInterface,
    EntradaRepositoryInterface,
    SaidaRepositoryInterface,
    DepositoRepositoryInterface,
    DepositoReversaoRepositoryInterface
};

use App\Repositories\{
    UserRepository,
    CarteiraRepository,
    EntradaRepository,
    SaidaRepository,
    DepositoRepository,
    DepositoReversaoRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CarteiraRepositoryInterface::class, CarteiraRepository::class);
        $this->app->bind(EntradaRepositoryInterface::class, EntradaRepository::class);
        $this->app->bind(SaidaRepositoryInterface::class, SaidaRepository::class);
        $this->app->bind(DepositoRepositoryInterface::class, DepositoRepository::class);
        $this->app->bind(DepositoReversaoRepositoryInterface::class, DepositoReversaoRepository::class);
    }

    public function boot()
    {
        //
    }
}
