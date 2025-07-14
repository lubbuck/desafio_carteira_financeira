<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carteira;
use App\Services\CarteiraService;

class CarteiraController extends Controller
{
    protected $bag = [
        'view' => 'carteira',
        'route' => 'carteira'
    ];

    protected $carteiraService;

    public function __construct(CarteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }

    public function index(Request $request)
    {
        $carteiras = auth()->user()->carteiras()->index($request->all(), 'created_at', 'desc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.index', compact('carteiras'));
    }

    public function store()
    {
        if (!is_null($this->carteiraService->buscarCarteiraAtiva(auth()->user()))) {
            return redirect()->back()->with(['error' => "Você já possui uma carteira ativa"]);
        }

        try {
            DB::beginTransaction();
            $carteira = $this->carteiraService->create(auth()->id());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['carteira' => $carteira->getKey()])->with(['success' => "Carteira cadastrada com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function show(Carteira $carteira)
    {
        if ($carteira->user_id != auth()->id()) {
            return redirect()->back()->with(['error' => "Você não possui acesso nesta carteira"]);
        }

        return view($this->bag['view'] . '.show', compact('carteira'));
    }

    public function desativar()
    {
        $carteira = $this->carteiraService->buscarCarteiraAtiva(auth()->user());

        if (is_null($carteira)) {
            return redirect()->back()->with(['error' => "Você não possui uma carteira ativa"]);
        }

        if ($this->carteiraService->verificaSaldo($carteira)) {
            return redirect()->back()->with(['error' => "Você ainda possui saldo na carteira. Saque ou transfira antes de desativar"]);
        }

        try {
            DB::beginTransaction();
            $this->carteiraService->desativarCarteira($carteira);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['carteira' => $carteira->getKey()]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }
}
