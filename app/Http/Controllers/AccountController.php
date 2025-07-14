<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Account\UpdateUserRequest;
use App\Http\Requests\Account\UpdatePasswordRequest;

class AccountController extends Controller
{
    protected $bag = [
        'view' => 'account',
    ];

    public function show()
    {
        $user = auth()->user();
        $permissions = $user->permissions()->orderBy('permissions.nome', 'asc')->get();
        $carteira = $user->carteiras()->where('ativada', true)->first();
        return view($this->bag['view'] . '.show', compact('user', 'permissions', 'carteira'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view($this->bag['view'] . '.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();
        try {
            DB::beginTransaction();
            $user->update($request->validated());
            DB::commit();
            return redirect()->back()->with(['success' => "Seus Dados foram Alterados com Sucesso!"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();

        try {
            $user->delete();
            auth()->logout();
            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erro ao Apagar o Registro']);
        }
    }

    public function password()
    {
        $user = auth()->user();
        return view($this->bag['view'] . '.password', compact('user'));
    }

    public function passwordUpdate(UpdatePasswordRequest $request)
    {
        $user = auth()->user();

        if (!Hash::check($request->senha, auth()->user()->password)) {
            return redirect()->back()->with(['error' => "Sua Senha está Incorreta!"]);
        }

        try {
            DB::beginTransaction();
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            DB::commit();
            return redirect()->back()->with(['success' => "Senha alterada com sucesso!"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }
}
