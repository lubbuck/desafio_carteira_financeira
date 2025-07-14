<?php

namespace App\Services;

use App\Contracts\Repositories\DepositoReversaoRepositoryInterface;

class DepositoReversaoService
{
    protected $depositoReversaoRepository;

    public function __construct(DepositoReversaoRepositoryInterface $depositoReversaoRepository)
    {
        $this->depositoReversaoRepository = $depositoReversaoRepository;
    }

    public function create($deposito_id, $valor)
    {
        return $this->depositoReversaoRepository->create([
            'valor' => $valor,
            'deposito_id' => $deposito_id,
            'status' => 'success'
        ]);
    }

    public function find($depositoReversao_id)
    {
        return $this->depositoReversaoRepository->find($depositoReversao_id);
    }
}
