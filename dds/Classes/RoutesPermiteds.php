<?php

namespace Dds\Classes;

use Illuminate\Support\Facades\Route;

class RoutesPermiteds
{
    public static function get()
    {
        return collect(Route::getRoutes())->filter(function ($permitedRoute) {
            $routeMiddlewares = $permitedRoute->getAction() != null ? $permitedRoute->getAction()['middleware'] ?? [] : [];
            return in_array('permited', $routeMiddlewares);
        })->map(function ($permitedRoute) {
            return [
                'name' => $permitedRoute->getAction()['as'],
                'method' => $permitedRoute->methods[0],
                'uri' => $permitedRoute->uri,
            ];
        });
    }

    public static function getFormated()
    {
        return DDS::groupRoutes(static::get()->toArray());
    }

    public static function filter($routes)
    {
        return static::get()->filter(function ($permitedRoute) use ($routes) {
            return in_array($permitedRoute['name'], $routes);
        })->map(function ($permitedRoute) {
            return $permitedRoute['name'];
        })->toArray();
    }
}
