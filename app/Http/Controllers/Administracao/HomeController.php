<?php

namespace App\Http\Controllers\Administracao;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    protected $bag = [
        'view' => 'administracao',
    ];

    public function home(Request $request)
    {
        $users = User::count();
        return view($this->bag['view'] . '.home', compact('users'));
    }
}
