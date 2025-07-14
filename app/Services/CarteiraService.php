<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Carteira;

class CarteiraService
{
    public function create($user_id)
    {
        return Carteira::create([
            'codigo' => Str::random(50),
            'user_id' => $user_id
        ]);
    }

    public function buscarCarteiraAtiva($user)
    {
        return $user->carteiras()->where('ativada', true)->first();
    }

    public function verificaSaldo($carteira)
    {
        return $carteira->possuiSaldo();
    }

    public function desativarCarteira($carteira)
    {
        $carteira->update(['ativada' => false]);
    }
}
