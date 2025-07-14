<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Sistema\Auditoria;
use App\Models\Sistema\AuditoriaAcesso;

class AuditoriaController extends Controller
{
    protected $bag = [
        'view' => 'sistema.auditoria'
    ];

    public function operacoes(Request $request)
    {
        $auditorias = Auditoria::leftJoin('users', 'users.id', '=', 'auditorias.user_id')
            ->select('auditorias.*', 'users.name as username')
            ->index($request->all(), 'auditorias.created_at', 'desc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.operacoes', compact('auditorias'));
    }

    public function acessos(Request $request)
    {
        $acessos = AuditoriaAcesso::leftJoin('users', 'users.id', '=', 'auditorias_acessos.user_id')
            ->select('auditorias_acessos.*', 'users.name as username')
            ->index($request->all(), 'auditorias_acessos.created_at', 'desc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.acessos', compact('acessos'));
    }
}
