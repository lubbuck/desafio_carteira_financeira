<?php

namespace App\Services;

use App\Contracts\Repositories\SaqueRepositoryInterface;

class SaqueService
{
    protected $saqueRepository;

    public function __construct(SaqueRepositoryInterface $saqueRepository)
    {
        $this->saqueRepository = $saqueRepository;
    }

    public function create($carteira_id, $valor)
    {
        return $this->saqueRepository->create([
            'valor' => $valor,
            'carteira_id' => $carteira_id,
            'status' => 'success'
        ]);
    }

    public function find($deposito_id)
    {
        return $this->saqueRepository->find($deposito_id);
    }
}
