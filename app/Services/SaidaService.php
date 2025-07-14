<?php

namespace App\Services;

use App\Contracts\Repositories\SaidaRepositoryInterface;
use App\Contracts\Repositories\CarteiraRepositoryInterface;

class SaidaService
{
    protected $saida;
    protected $carteiraRepository;

    public function __construct(SaidaRepositoryInterface $saida, CarteiraRepositoryInterface $carteiraRepository)
    {
        $this->saida = $saida;
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

        if (!$carteira->possuiSaldoParaRetirar($valor)) {
            throw new \Exception("Saldo indisponível. Não é possivel realizar a operação.");
        }

        $carteira->update([
            'saldo' => $carteira->saldo - $valor
        ]);

        return $this->saida->create([
            'tipo_operacao' => $tipo_operacao,
            'valor' => $valor,
            'status' => $status,
            'operacao_id' => $operacao_id,
            'carteira_id' => $carteira_id,
        ]);
    }
}
