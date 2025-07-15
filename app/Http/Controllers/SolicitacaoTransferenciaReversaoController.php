<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\SolicitacaoTransferenciaReversaoRequest;
use App\Services\SolicitacaoTransferenciaReversaoService;
use App\Services\TransferenciaService;
use App\Services\CarteiraService;

class SolicitacaoTransferenciaReversaoController extends Controller
{
    protected $bag = [
        'view' => 'solicitacao-transferencia-reversao',
        'route' => 'solicitacao_transferencia_reversao'
    ];

    protected $solicitacaoTransferenciaReversaoService;
    protected $transferenciaService;
    protected $carteiraService;

    public function __construct(SolicitacaoTransferenciaReversaoService $solicitacaoTransferenciaReversaoService, TransferenciaService $transferenciaService, CarteiraService $carteiraService)
    {
        $this->solicitacaoTransferenciaReversaoService = $solicitacaoTransferenciaReversaoService;
        $this->transferenciaService = $transferenciaService;
        $this->carteiraService = $carteiraService;
    }

    public function create($transferencia)
    {
        $transferencia = $this->transferenciaService->find($transferencia);

        if (is_null($transferencia)) {
            abort(404);
        }

        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        if (!$transferencia->isOrigem($carteira->id)) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "Você não pode solicitar a reversão da transação. Apenas quem enviou a transferencia pode"]);;
        }

        if ($transferencia->reversao) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "A transferência já foi revertida"]);;
        }

        if ($transferencia->solicitacaoReversao) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "A transferência já possui uma solicitacao de reversão "]);;
        }

        return view($this->bag['view'] . '.create', compact('transferencia', 'carteira'));
    }

    public function store($transferencia, SolicitacaoTransferenciaReversaoRequest $request)
    {
        $transferencia = $this->transferenciaService->find($transferencia);

        if (is_null($transferencia)) {
            abort(404);
        }

        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route('carteira.index')->with(['error' => "Você não possui uma carteira ativa"]);
        }

        if (!$transferencia->isOrigem($carteira->id)) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "Você não pode solicitar a reversão da transação. Apenas quem enviou a transferencia pode"]);;
        }

        if ($transferencia->reversao) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "A transferência já foi revertida"]);;
        }

        if ($transferencia->solicitacaoReversao) {
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['warning' => "A transferência já possui uma solicitacao de reversão "]);;
        }

        try {
            DB::beginTransaction();
            $this->solicitacaoTransferenciaReversaoService->create($transferencia->id, $request->motivo);
            DB::commit();
            return redirect()->route('carteira.transferencias', ['carteira' => $carteira->getKey()])->with(['success' => "Solicitação de Reversão de Transferência salva com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
