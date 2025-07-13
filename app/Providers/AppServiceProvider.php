<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\{
    Login,
    Logout
};
use App\Listeners\{
    AuditaLogin,
    AuditaLogout
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            Login::class,
            AuditaLogin::class,
        );

        Event::listen(
            Logout::class,
            AuditaLogout::class,
        );
    }
}
