<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\TransferenciaRequest;
use App\Services\TransferenciaService;
use App\Services\CarteiraService;
use App\Services\EntradaService;
use App\Services\SaidaService;

class TransferenciaController extends Controller
{
    protected $bag = [
        'view' => 'transferencia',
        'route' => 'transferencia'
    ];

    protected $transferenciaService;
    protected $carteiraService;
    protected $entradaService;
    protected $saidaService;

    public function __construct(TransferenciaService $transferenciaService, CarteiraService $carteiraService, EntradaService $entradaService, SaidaService $saidaService)
    {
        $this->transferenciaService = $transferenciaService;
        $this->carteiraService = $carteiraService;
        $this->entradaService = $entradaService;
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

    public function store(TransferenciaRequest $request)
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        try {
            DB::beginTransaction();
            $transferencia = $this->transferenciaService->create($carteira->id, $request->codigo, $request->valor);
            $this->saidaService->create($transferencia->carteira_origem_id, 'transferencia', $transferencia->valor, $transferencia->id);
            $this->entradaService->create($transferencia->carteira_destino_id, 'transferencia', $transferencia->valor, $transferencia->id);
            DB::commit();
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['success' => "Valor Transferido com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
