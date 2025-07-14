<?php

namespace App\Http\Controllers\Administracao;

use App\Http\Controllers\Controller;

use App\Models\Carteira;
use App\Services\CarteiraService;

class CarteiraController extends Controller
{
    protected $bag = [
        'view' => 'administracao.carteira',
        'route' => 'administracao.carteira'
    ];

    protected $carteiraService;

    public function __construct(CarteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }

    public function show(Carteira $carteira)
    {
        return view($this->bag['view'] . '.show', compact('carteira'));
    }
}
