<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\DepositoRequest;
use App\Services\DepositoService;
use App\Services\CarteiraService;
use App\Services\EntradaService;
use App\Services\DepositoReversaoService;
use App\Services\SaidaService;

class DepositoController extends Controller
{
    protected $bag = [
        'view' => 'deposito',
        'route' => 'deposito'
    ];

    protected $depositoService;
    protected $carteiraService;
    protected $entradaService;
    protected $depositoReversaoService;
    protected $saidaService;

    public function __construct(DepositoService $depositoService, CarteiraService $carteiraService, EntradaService $entradaService, DepositoReversaoService $depositoReversaoService, SaidaService $saidaService)
    {
        $this->depositoService = $depositoService;
        $this->carteiraService = $carteiraService;
        $this->entradaService = $entradaService;
        $this->depositoReversaoService = $depositoReversaoService;
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

    public function reverter($deposito)
    {
        $deposito = $this->depositoService->find($deposito);

        if (is_null($deposito)) {
            abort(404);
        }

        $carteira = $this->carteiraService->find($deposito->carteira_id);

        if ($carteira->user_id != auth()->id()) {
            return redirect()->route($this->bag['route'] . '.index')->with(['info' => "Você não possui acesso nesta carteira"]);;
        }

        if ($deposito->reversao) {
            return redirect()->route('carteira.depositos', ['carteira' => $carteira->getKey()])->with(['warning' => "O depósito já foi revertido"]);;
        }

        try {
            DB::beginTransaction();
            $depositoReversao = $this->depositoReversaoService->create($deposito->id, $deposito->valor);
            $this->saidaService->create($carteira->id, 'deposito_reversao', $depositoReversao->valor, $depositoReversao->id);
            DB::commit();
            return redirect()->route('carteira.depositos', ['carteira' => $carteira->getKey()])->with(['success' => "Deposito Revertido com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
