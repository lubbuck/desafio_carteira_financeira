<?php

namespace App\Services;

use App\Contracts\Repositories\EntradaRepositoryInterface;
use App\Contracts\Repositories\CarteiraRepositoryInterface;

class EntradaService
{
    protected $entradaRepository;
    protected $carteiraRepository;

    public function __construct(EntradaRepositoryInterface $entradaRepository, CarteiraRepositoryInterface $carteiraRepository)
    {
        $this->entradaRepository = $entradaRepository;
        $this->carteiraRepository = $carteiraRepository;
    }

    public function create($carteira_id, $tipo_operacao, $valor, $operacao_id, $status = 'success')
    {
        $carteira = $this->carteiraRepository->model()->lockForUpdate()->find($carteira_id);

        if (is_null($carteira)) {
            throw new \Exception("Conta não foi encontrada.");
        }

        if (!$carteira->ativada) {
            throw new \Exception("Não é possivel realizar a operação em uma conta desativada.");
        }

        $carteira->update([
            'saldo' => $carteira->saldo + $valor
        ]);

        return $this->entradaRepository->create([
            'tipo_operacao' => $tipo_operacao,
            'valor' => $valor,
            'status' => $status,
            'operacao_id' => $operacao_id,
            'carteira_id' => $carteira_id,
        ]);
    }
}
