<?php

namespace App\Services;

use App\Contracts\Repositories\SolicitacaoTransferenciaReversaoRepositoryInterface;

class SolicitacaoTransferenciaReversaoService
{
    protected $solicitacaoTransferenciaReversaoRepository;

    public function __construct(SolicitacaoTransferenciaReversaoRepositoryInterface $solicitacaoTransferenciaReversaoRepository)
    {
        $this->solicitacaoTransferenciaReversaoRepository = $solicitacaoTransferenciaReversaoRepository;
    }

    public function create($transferencia_id, $motivo)
    {
        return $this->solicitacaoTransferenciaReversaoRepository->create([
            'motivo' => $motivo,
            'transferencia_id' => $transferencia_id,
        ]);
    }

    public function find($deposito_id)
    {
        return $this->solicitacaoTransferenciaReversaoRepository->find($deposito_id);
    }
}
