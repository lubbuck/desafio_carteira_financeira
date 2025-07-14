<?php

namespace App\Services;

use App\Contracts\Repositories\CarteiraRepositoryInterface;

class CarteiraService
{
    protected $carteiraRepository;

    public function __construct(CarteiraRepositoryInterface $carteiraRepository)
    {
        $this->carteiraRepository = $carteiraRepository;
    }

    public function userCarteiras($user_id, $filters, $order, $sort)
    {
        $filters['user_id'] = $user_id;
        return $this->carteiraRepository->all($filters, $order, $sort);
    }

    public function create($user_id)
    {
        return $this->carteiraRepository->create([
            'user_id' => $user_id
        ]);
    }

    public function carteiraAtiva($user_id)
    {
        return $this->carteiraRepository->buscarCarteiraAtiva($user_id);
    }

    public function find($carteira_id)
    {
        return $this->carteiraRepository->find($carteira_id);
    }
}
