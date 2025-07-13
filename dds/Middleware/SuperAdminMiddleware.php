<?php

namespace Dds\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SuperAdminMiddleware
{
    use AuthorizesRequests;

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return $next($request);
        }

        alert()->error('Acesso não Autorizado');
        return redirect()->route('home');
    }
}
