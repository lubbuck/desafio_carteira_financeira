<?php

namespace App\Services;

use App\Contracts\Repositories\TransferenciaRepositoryInterface;
use App\Contracts\Repositories\CarteiraRepositoryInterface;

class TransferenciaService
{
    protected $transferenciaRepository;
    protected $carteiraRepository;

    public function __construct(TransferenciaRepositoryInterface $transferenciaRepository, CarteiraRepositoryInterface $carteiraRepository)
    {
        $this->transferenciaRepository = $transferenciaRepository;
        $this->carteiraRepository = $carteiraRepository;
    }

    public function create($carteira_origem_id, $codigo_destino, $valor)
    {
        $carteiraDestino = $this->carteiraRepository->findByCodigo($codigo_destino);

        if (is_null($carteiraDestino) || !$carteiraDestino->ativada) {
            throw new \Exception("Carteira de Destino não encontrada.");
        }

        if ($carteira_origem_id == $carteiraDestino->id) {
            throw new \Exception("Não é possível enviar para a propria conta.");
        }

        return $this->transferenciaRepository->create([
            'valor' => $valor,
            'carteira_origem_id'  => $carteira_origem_id,
            'carteira_destino_id'  => $carteiraDestino->id,
            'status' => 'success'
        ]);
    }

    public function find($deposito_id)
    {
        return $this->transferenciaRepository->find($deposito_id);
    }
}
