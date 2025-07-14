<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;

use App\Models\User;

class HomeController extends Controller
{
    protected $bag = [
        'view' => 'sistema'
    ];

    public function index()
    {
        $users = User::where('is_super_admin', true)->orderBy('name', 'asc')->get();
        return view($this->bag['view'] . '.home', compact('users'));
    }
}
