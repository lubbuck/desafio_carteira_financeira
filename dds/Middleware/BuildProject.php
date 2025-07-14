<?php

namespace Dds\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Sistema\PermissionRoute;

class BuildProject
{
    public function handle(Request $request, Closure $next)
    {
        $this->handlePermissions();
        return $next($request);
    }

    public function handlePermissions()
    {
        $user = Auth::user();

        $routesInPermiteMiddlewareThatUserHasPermission = is_null($user) ? [] :
            PermissionRoute::whereHas('permission', function ($query) use ($user) {
                $query->whereHas('users', function ($subquery) use ($user) {
                    $subquery->where('id', '=', $user->id);
                });
            })->pluck('route_name')->toArray();

        $routesUserCanAccess = collect(Route::getRoutes())->filter(function ($route) use ($routesInPermiteMiddlewareThatUserHasPermission) {
            $action = $route->getAction() ?? [];
            $routeMiddlewares = $action['middleware'] ?? [];
            $name = $action['as'] ?? null;
            if (!in_array('permited', $routeMiddlewares) && !in_array('superadmin', $routeMiddlewares)) {
                return true;
            }
            if (in_array('permited', $routeMiddlewares) && in_array($name, $routesInPermiteMiddlewareThatUserHasPermission)) {
                return true;
            }
            return false;
        })->map(function ($route) {
            return $route->getAction()['as'] ?? null;
        })->reject(null)->toArray();

        $super_admin_visualization = $user ? $user->isSuperAdmin() && session('super_admin_visualization', $user->isSuperAdmin()) : false;

        session([
            'layout_theme' => session('layout_theme', 'light-style'),
            'super_admin_visualization' => $super_admin_visualization,
            'routes_user_can_access' => $routesUserCanAccess
        ]);
    }
}
