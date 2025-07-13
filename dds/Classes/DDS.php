<?php

namespace DDS\Classes;

use Carbon\Carbon;
use Illuminate\Support\Str;

class DDS
{
    public static function cpfOculto($cpf)
    {
        return $cpf ? '***.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-**' : 'Não Informado';
    }

    public static function cepMask($cep)
    {
        return substr($cep, 0, 5) . '-' . substr($cep, 4, 3);
    }

    public static function celularMask($numero)
    {
        return $numero ? '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 5) . '-' . substr($numero, 7, 4) :  'Não Informado';
    }

    public static function telefoneMask($numero)
    {
        return $numero ? '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6, 4) :  'Não Informado';
    }

    // number helper
    public static function intToFloat2C($valor)
    {
        if (!$valor) {
            return '0,00';
        }
        $valor  = (float) $valor / 100;
        $valor = str_replace('.', ',', $valor);
        if (!Str::contains($valor, ',')) {
            return $valor . ',00';
        }
        if (Str::length(Str::after($valor, ',')) === 1) {
            return $valor . '0';
        }
        return $valor;
    }

    public static function floatToInt($valor)
    {
        if (!$valor) {
            return null;
        }
        $valor = str_replace(',', '.', preg_replace('/[^0-9,]/', "", $valor));
        if ($valor == '') {
            return null;
        }
        return  (int) (round(100 * ((float) $valor), 0, PHP_ROUND_HALF_DOWN));
    }

    public static function parseDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public static function groupRoutes($routes)
    {
        $groupedRoutes = [];
        foreach ($routes as $route) {
            $names = explode('.', $route['name']);
            $count = count($names);
            if ($count == 1) {
                $groupedRoutes[''][] = $route;
            } elseif ($count == 2) {
                $groupedRoutes[$names[0]][''][] = $route;
            } else {
                $groupedRoutes[$names[0]][$names[1]][] = $route;
            }
        }
        return collect($groupedRoutes)->sortKeys()->map(function ($group, $key) {
            $group = collect($group)->sortKeys()->toArray();
            return $group;
        })->toArray();
    }
}
