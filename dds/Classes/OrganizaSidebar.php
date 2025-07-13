<?php

namespace DDS\Classes;

use Illuminate\Support\Facades\Route;

class OrganizaSidebar
{
    public static function sidebar($sidebarArray)
    {
        return collect($sidebarArray)
            ->map(function ($item) {
                return static::organiza($item);
            })->reject(null)->toArray();
    }

    private static function organiza($item)
    {
        $itemActiveClass = "active";
        $menuActiveClass = 'active open';
        $route = $item['route'] ?? null;
        $submenu = $item['submenu'] ?? null;

        if ($route) {
            if (!in_array($route, session('routes_user_can_access')) && !session('super_admin_visualization')) {
                return null;
            }
            $item['classActive'] = $route === Route::currentRouteName() ? $itemActiveClass : '';
        }

        if ($submenu) {
            $realSubmenu = [];
            foreach ($submenu as $sub) {
                $itemOrganizado = static::organiza($sub); // recursivamente verifica
                if ($itemOrganizado) {
                    $realSubmenu[] = $itemOrganizado;
                }
            }
            if (count($realSubmenu) > 0) {
                $activesClasses = array_column($realSubmenu, 'classActive'); // verifica por classes ativas no item
                $item['classActive'] = in_array('active', $activesClasses) || in_array($menuActiveClass, $activesClasses) ? $menuActiveClass : '';
                $item['submenu'] = $realSubmenu;
            } else {
                return null;
            }
        }

        return $item;
    }
}
