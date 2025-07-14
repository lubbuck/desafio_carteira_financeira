<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\Repositories\{
    UserRepositoryInterface,
    CarteiraRepositoryInterface
};

use App\Repositories\{
    UserRepository,
    CarteiraRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CarteiraRepositoryInterface::class, CarteiraRepository::class);
    }

    public function boot()
    {
        //
    }
}
