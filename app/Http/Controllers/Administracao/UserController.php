<?php

namespace App\Http\Controllers\Administracao;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Administracao\User\{
    UserRequest,
    UpdatePasswordRequest,
    UpdatePermissionRequest,
};
use App\Models\User;
use App\Models\Sistema\Permission;
use App\Services\UserService;
use App\Services\CarteiraService;

class UserController extends Controller
{
    protected $bag = [
        'view' => 'administracao.user',
        'route' => 'administracao.user',
    ];

    protected $userService;
    protected $carteiraService;

    public function __construct(UserService $userService, CarteiraService $carteiraService)
    {
        $this->userService = $userService;
        $this->carteiraService = $carteiraService;
    }

    public function index(Request $request)
    {
        $users = User::index($request->all(), 'name', 'asc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.index', compact('users'));
    }

    public function create()
    {
        return view($this->bag['view'] . '.create');
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->create($request->name, $request->email);
            $this->carteiraService->create($user->id);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.permission.edit', ['user' => $user->getKey()])->with(['success' => "Usuário cadastrado com sucesso"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function show(User $user, Request $request)
    {
        $permissions = $user->permissions()->orderBy('permissions.nome', 'asc')->get();
        $carteiras = $user->carteiras()->index($request->all(), 'created_at', 'desc')->get();
        return view($this->bag['view'] . '.show', compact('user', 'permissions', 'carteiras'));
    }

    public function edit(User $user)
    {
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with(['error' => "Não é possivel alterar os dados deste usuário"]);
        }

        return view($this->bag['view'] . '.edit', compact('user'));
    }

    public function update(User $user, UserRequest $request)
    {
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with(['error' => "Não é possivel alterar os dados deste usuário"]);
        }

        try {
            DB::beginTransaction();
            $user->update($request->validated());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['user' => $user->getKey()])->with(['success' => "Dados do Usuário Alterados com Sucesso!"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function destroy(User $user, Request $request)
    {
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with(['error' => "Não é possivel excluir este usuário"]);
        }

        try {
            $esta_logado = auth()->id() === $user->id;
            $user->delete();
            if ($esta_logado) {
                auth()->logout();
            }
            return redirect()->route($this->bag['route'] . '.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erro ao Apagar o Registro']);
        }
    }

    public function deleted(Request $request)
    {
        $users = User::onlyTrashed()->index($request->all(), 'name', 'asc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.deleted', compact('users'));
    }

    public function restore($user)
    {
        try {
            DB::beginTransaction();
            $user = User::onlyTrashed()->where('id', $user)->first();
            if ($user) {
                $user->restore();
            }
            DB::commit();
            return redirect()->route($this->bag['route'] . '.deleted')->with(['success' => "Usuário Restaurado"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Erro ao Restaurar o Registro']);
        }
    }

    public function permission(User $user)
    {
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with(['error' => "Não é possivel alterar as permissões deste usuário"]);
        }

        $userPermissions = $user->permissions;
        $permissions = Permission::orderBy('nome', 'asc')->get();
        return view($this->bag['view'] . '.permission', compact('user', 'userPermissions', 'permissions'));
    }

    public function permissionUpdate(User $user, UpdatePermissionRequest $request)
    {
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with(['error' => "Não é possivel alterar as permissões deste usuário"]);
        }

        $validated = $request->validated();
        $validated['is_admin'] = auth()->user()->isAdmin() ? !is_null($request->is_admin) : $user->isAdmin();
        $validated['is_super_admin'] = auth()->user()->isSuperAdmin() ? !is_null($request->is_super_admin) : $user->isSuperAdmin();

        try {
            DB::beginTransaction();
            $user->update($validated);
            $user->permissions()->sync($request->permissions ?? []);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['user' => $user->getKey()])->with(['success' => "Permissões do Usuário Alteradas com Sucesso!"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function password(User $user)
    {
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with(['error' => "Não é possivel alterar a senha deste usuário"]);
        }

        return view($this->bag['view'] . '.password', compact('user'));
    }

    public function passwordUpdate(User $user, UpdatePasswordRequest $request)
    {
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with(['error' => "Não é possivel alterar a senha deste usuário"]);
        }

        if (!Hash::check($request->senha, auth()->user()->password)) {
            return redirect()->back()->with(['error' => "Sua Senha está Incorreta!"]);
        }

        try {
            DB::beginTransaction();
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            DB::commit();
            return redirect()->back()->with(['success' => "Senha do Usuário alterada com sucesso!"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }
}
