<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CarteiraService;

class HomeController extends Controller
{
    protected $bag = [
        'view' => 'home',
        'route' => 'home'
    ];

    protected $carteiraService;

    public function __construct(CarteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }

    public function home(Request $request)
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());
        return view($this->bag['view'], compact('carteira'));
    }
}
