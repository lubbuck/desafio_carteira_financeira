<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\DepositoRequest;
use App\Services\DepositoService;
use App\Services\CarteiraService;
use App\Services\EntradaService;

class DepositoController extends Controller
{
    protected $bag = [
        'view' => 'deposito',
        'route' => 'deposito'
    ];

    protected $depositoService;
    protected $carteiraService;
    protected $entradaService;

    public function __construct(DepositoService $depositoService, CarteiraService $carteiraService, EntradaService $entradaService)
    {
        $this->depositoService = $depositoService;
        $this->carteiraService = $carteiraService;
        $this->entradaService = $entradaService;
    }

    public function create()
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        return view($this->bag['view'] . '.create', compact('carteira'));
    }

    public function store(DepositoRequest $request)
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        try {
            DB::beginTransaction();
            $deposito = $this->depositoService->create($carteira->id, $request->valor);
            $this->entradaService->create($carteira->id, 'deposito', $request->valor, $deposito->id);
            DB::commit();
            return redirect()->route('carteira.depositos', ['carteira' => $carteira->getKey()])->with(['success' => "Valor Depositado com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
