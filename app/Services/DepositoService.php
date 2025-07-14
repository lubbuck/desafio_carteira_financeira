<?php

namespace App\Services;

use App\Contracts\Repositories\DepositoRepositoryInterface;

class DepositoService
{
    protected $depositoRepository;

    public function __construct(DepositoRepositoryInterface $depositoRepository)
    {
        $this->depositoRepository = $depositoRepository;
    }

    public function create($carteira_id, $valor)
    {
        return $this->depositoRepository->create([
            'valor' => $valor,
            'carteira_id' => $carteira_id,
            'status' => 'success'
        ]);
    }

    public function find($deposito_id)
    {
        return $this->depositoRepository->find($deposito_id);
    }
}
