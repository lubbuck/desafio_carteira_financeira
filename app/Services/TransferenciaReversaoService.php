<?php

namespace App\Services;

use App\Contracts\Repositories\TransferenciaReversaoRepositoryInterface;

class TransferenciaReversaoService
{
    protected $transferenciaReversaoRepository;

    public function __construct(TransferenciaReversaoRepositoryInterface $transferenciaReversaoRepository)
    {
        $this->transferenciaReversaoRepository = $transferenciaReversaoRepository;
    }

    public function create($transferencia_id, $valor)
    {
        return $this->transferenciaReversaoRepository->create([
            'valor' => $valor,
            'transferencia_id' => $transferencia_id,
            'status' => 'success'
        ]);
    }

    public function find($depositoReversao_id)
    {
        return $this->transferenciaReversaoRepository->find($depositoReversao_id);
    }
}
