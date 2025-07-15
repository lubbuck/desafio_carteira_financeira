<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\Repositories\{
    UserRepositoryInterface,
    CarteiraRepositoryInterface,
    EntradaRepositoryInterface,
    SaidaRepositoryInterface,
    DepositoRepositoryInterface,
    DepositoReversaoRepositoryInterface,
    SaqueRepositoryInterface,
    TransferenciaRepositoryInterface,
    TransferenciaReversaoRepositoryInterface,
    SolicitacaoTransferenciaReversaoRepositoryInterface,
};

use App\Repositories\{
    UserRepository,
    CarteiraRepository,
    EntradaRepository,
    SaidaRepository,
    DepositoRepository,
    DepositoReversaoRepository,
    SaqueRepository,
    TransferenciaRepository,
    TransferenciaReversaoRepository,
    SolicitacaoTransferenciaReversaoRepository,
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
        $this->app->bind(SaqueRepositoryInterface::class, SaqueRepository::class);
        $this->app->bind(TransferenciaRepositoryInterface::class, TransferenciaRepository::class);
        $this->app->bind(TransferenciaReversaoRepositoryInterface::class, TransferenciaReversaoRepository::class);
        $this->app->bind(SolicitacaoTransferenciaReversaoRepositoryInterface::class, SolicitacaoTransferenciaReversaoRepository::class);
    }

    public function boot()
    {
        //
    }
}
