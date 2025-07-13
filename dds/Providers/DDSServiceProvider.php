<?php

namespace Dds\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

class DDSServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        // paginacao setada
        Paginator::defaultView('vendor.pagination.default');

        // helper de permissao para as blades
        Blade::if('permiteroute', function ($route, $onlyIf = true) {
            if (session('super_admin_visualization')) {
                return true;
            }
            return $onlyIf && in_array($route, session('routes_user_can_access'));
        });
    }
}
