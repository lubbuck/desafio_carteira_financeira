<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Services\DepositoService;
use App\Services\CarteiraService;
use App\Services\DepositoReversaoService;
use App\Services\SaidaService;

class DepositoReversaoController extends Controller
{
    protected $bag = [
        'view' => 'deposito-reversao',
        'route' => 'deposito_reversao'
    ];

    protected $depositoReversaoService;
    protected $depositoService;
    protected $carteiraService;
    protected $saidaService;

    public function __construct(DepositoReversaoService $depositoReversaoService, DepositoService $depositoService, CarteiraService $carteiraService,  SaidaService $saidaService)
    {
        $this->depositoReversaoService = $depositoReversaoService;
        $this->depositoService = $depositoService;
        $this->carteiraService = $carteiraService;
        $this->saidaService = $saidaService;
    }

    public function store($deposito)
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
