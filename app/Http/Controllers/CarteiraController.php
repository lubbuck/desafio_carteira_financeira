<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $carteiras = $this->carteiraService->userCarteiras(auth()->id(), $request->all(), 'created_at', 'desc');
        $carteiraAtiva = $this->carteiraService->carteiraAtiva(auth()->id());
        return view($this->bag['view'] . '.index', compact('carteiras', 'carteiraAtiva'));
    }

    public function store()
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (!is_null($carteira)) {
            return redirect()->route($this->bag['route'] . '.show', ['carteira' => $carteira->getKey()])->with(['error' => "Você já possui uma carteira ativa"]);;
        }

        try {
            DB::beginTransaction();
            $carteira = $this->carteiraService->create(auth()->id());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['carteira' => $carteira->getKey()])->with(['success' => "Carteira cadastrada com sucesso"]);;
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    public function show($carteira)
    {
        $carteira = $this->carteiraService->find($carteira);

        if (is_null($carteira)) {
            abort(404);
        }

        if ($carteira->user_id != auth()->id()) {
            return redirect()->route($this->bag['route'] . '.index')->with(['info' => "Você não possui acesso nesta carteira"]);;
        }

        $entradas = $carteira->entradas()->orderBy('created_at', 'desc')->get();
        $saidas = $carteira->saidas()->orderBy('created_at', 'desc')->get();
        return view($this->bag['view'] . '.show', compact('carteira', 'entradas', 'saidas'));
    }

    public function depositos($carteira)
    {
        $carteira = $this->carteiraService->find($carteira);

        if (is_null($carteira)) {
            abort(404);
        }

        if ($carteira->user_id != auth()->id()) {
            return redirect()->route($this->bag['route'] . '.index')->with(['info' => "Você não possui acesso nesta carteira"]);;
        }

        $depositos = $carteira->depositos()->with('reversao')->orderBy('created_at', 'desc')->get();
        return view($this->bag['view'] . '.depositos', compact('carteira', 'depositos'));
    }

    public function saques($carteira)
    {
        $carteira = $this->carteiraService->find($carteira);

        if (is_null($carteira)) {
            abort(404);
        }

        if ($carteira->user_id != auth()->id()) {
            return redirect()->route($this->bag['route'] . '.index')->with(['info' => "Você não possui acesso nesta carteira"]);;
        }

        $saques = $carteira->saques()->orderBy('created_at', 'desc')->get();
        return view($this->bag['view'] . '.saques', compact('carteira', 'saques'));
    }

    public function desativar()
    {
        $carteira = $this->carteiraService->carteiraAtiva(auth()->id());

        if (is_null($carteira)) {
            return redirect()->route($this->bag['route'] . '.index')->with(['error' => "Você não possui uma carteira ativa"]);;
        }

        if ($carteira->possuiSaldo()) {
            return redirect()->route($this->bag['route'] . '.show', ['carteira' => $carteira->id])->with(['error' => "Você ainda possui saldo na carteira. Saque ou transfira antes de desativar"]);;
        }

        try {
            DB::beginTransaction();
            $carteira->update(['ativada' => false]);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['carteira' => $carteira->getKey()])->with(['success' => 'Carteira Desativada com sucesso']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
