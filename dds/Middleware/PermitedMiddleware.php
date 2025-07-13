<?php

namespace Dds\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PermitedMiddleware
{
    use AuthorizesRequests;

    public function handle(Request $request, Closure $next)
    {
        if ((auth()->check() && auth()->user()->isSuperAdmin()) || in_array($request->route()->getName(), session('routes_user_can_access'))) {
            return $next($request);
        }

        return redirect()->route('home')->with(['error' => "Você não tem permissão para acessar esta rota"]);
    }
}
