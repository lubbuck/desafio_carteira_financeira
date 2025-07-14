<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\SaqueRequest;
use App\Services\SaqueService;
use App\Services\CarteiraService;
use App\Services\SaidaService;

class SaqueController extends Controller
{
    protected $bag = [
        'view' => 'saque',
        'route' => 'saque'
    ];

    protected $saqueService;
    protected $carteiraService;
    protected $saidaService;

    public function __construct(SaqueService $saqueService, CarteiraService $carteiraService, SaidaService $saidaService)
    {
        $this->saqueService = $saqueService;
        $this->carteiraService = $carteiraService;
        $this->saidaService = $saidaService;
    }

    public function create()
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        return view($this->bag['view'] . '.create', compact('carteira'));
    }

    public function store(SaqueRequest $request)
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        try {
            DB::beginTransaction();
            $saque = $this->saqueService->create($carteira->id, $request->valor);
            $this->saidaService->create($carteira->id, 'saque', $request->valor, $saque->id);
            DB::commit();
            return redirect()->route('carteira.saques', ['carteira' => $carteira->getKey()])->with(['success' => "Valor Sacado com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
