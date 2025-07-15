<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Services\TransferenciaReversaoService;
use App\Services\TransferenciaService;
use App\Services\CarteiraService;
use App\Services\EntradaService;
use App\Services\SaidaService;

class TransferenciaReversaoController extends Controller
{
    protected $bag = [
        'view' => 'deposito-reversao',
        'route' => 'deposito_reversao'
    ];

    protected $transferenciaReversaoService;
    protected $transferenciaService;
    protected $carteiraService;
    protected $entradaService;
    protected $saidaService;

    public function __construct(TransferenciaReversaoService $transferenciaReversaoService, TransferenciaService $transferenciaService, CarteiraService $carteiraService, EntradaService $entradaService, SaidaService $saidaService)
    {
        $this->transferenciaReversaoService = $transferenciaReversaoService;
        $this->transferenciaService = $transferenciaService;
        $this->carteiraService = $carteiraService;
        $this->entradaService = $entradaService;
        $this->saidaService = $saidaService;
    }

    public function store($transferencia)
    {
        $transferencia = $this->transferenciaService->find($transferencia);

        if (is_null($transferencia)) {
            abort(404);
        }

        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        if ($transferencia->reversao) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "A transferência já foi revertida"]);;
        }

        if (!$transferencia->isDestino($carteira->id)) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "Você não pode reverter a transação. Apenas quem recebeu a transferencia pode"]);;
        }

        try {
            DB::beginTransaction();
            $transferenciaReversao = $this->transferenciaReversaoService->create($transferencia->id, $transferencia->valor);
            $this->saidaService->create($transferencia->carteira_destino_id, 'transferencia_reversao', $transferencia->valor, $transferenciaReversao->id);
            $this->entradaService->create($transferencia->carteira_origem_id, 'transferencia_reversao', $transferencia->valor, $transferenciaReversao->id);
            DB::commit();
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['success' => "Deposito Revertido com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
