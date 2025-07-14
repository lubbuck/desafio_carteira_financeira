<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Sistema\PermissionRequest;
use App\Models\Sistema\Permission;
use App\Models\Sistema\PermissionRoute;
use App\Models\User;
use Dds\Classes\RoutesPermiteds;

class PermissionController extends Controller
{
    protected $bag = [
        'route' => 'sistema.permission',
        'view' => 'sistema.permission'
    ];

    public function index(Request $request)
    {
        $permissions = Permission::join('permissions_rotas', 'permissions.id', '=', 'permissions_rotas.permission_id')
            ->select('permissions.*', DB::raw("STRING_AGG(permissions_rotas.route_name, ', ' order by permissions_rotas.route_name) as routes"))
            ->groupBy('permissions.id')->index($request->all(), 'nome', 'asc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.index', compact('permissions'));
    }

    public function create()
    {
        $permitedRoutes = RoutesPermiteds::getFormated();
        $registereds = PermissionRoute::with('permission')->get();
        return view($this->bag['view'] . '.create', compact('permitedRoutes', 'registereds'));
    }

    public function store(PermissionRequest $request)
    {
        try {
            DB::beginTransaction();
            $permission = Permission::create($request->validated());
            foreach ($request->routes as $route) {
                PermissionRoute::create([
                    'route_name' => $route,
                    'permission_id' => $permission->id
                ]);
            }
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['permission' => $permission->getKey()]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function show(Permission $permission, Request $request)
    {
        $routes = $permission->rotas()->orderBy('route_name', 'asc')->select('route_name as name')->get()->toArray();
        $users = $permission->users()->index($request->all(), 'name', 'asc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.show', compact('permission', 'routes', 'users'));
    }

    public function edit(Permission $permission)
    {
        $permitedRoutes = RoutesPermiteds::getFormated();
        $registereds = PermissionRoute::with('permission')->get();
        return view($this->bag['view'] . '.edit', compact('permission', 'permitedRoutes', 'registereds'));
    }

    public function update(Permission $permission, PermissionRequest $request)
    {
        $permissionRoutes = $permission->rotas()->get('route_name')->pluck('route_name')->toArray();

        $routes = $request->routes;
        $insertRoutes = collect($routes)->filter(function ($route) use ($permissionRoutes) {
            return !in_array($route, $permissionRoutes);
        })->toArray();

        $deleteRoutes = collect($permissionRoutes)->filter(function ($route) use ($routes) {
            return !in_array($route, $routes);
        })->toArray();

        try {
            DB::beginTransaction();
            $permission->update($request->validated());
            foreach ($insertRoutes as $route) {
                PermissionRoute::create([
                    'route_name' => $route,
                    'permission_id' => $permission->id
                ]);
            }
            foreach ($deleteRoutes as $route) {
                $rota  = PermissionRoute::where('route_name', $route)->where('permission_id', $permission->id)->first();
                if ($rota) {
                    $rota->delete();
                }
            }
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['permission' => $permission->getKey()])->with(['success' => "Registro Alterado com Sucesso!"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function destroy(Permission $permission, Request $request)
    {
        try {
            $permission->delete();
            return redirect()->route($this->bag['route'] . '.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Erro ao Apagar o Registro']);
        }
    }

    public function mass(Permission $permission, Request $request)
    {
        $users = User::leftJoin('users_permissions', 'users_permissions.user_id', '=', 'users.id')
            ->leftJoin('permissions', 'permissions.id', '=', 'users_permissions.permission_id')
            ->select('users.*', DB::raw("STRING_AGG(permissions.nome, ', ' order by permissions.nome) as permissions"))
            ->groupBy('users.id')
            ->index($request->all(), 'users.name', 'asc')->qtdPag($request->qtd);
        return view($this->bag['view'] . '.mass', compact('permission', 'users'));
    }

    public function massUpdate(Permission $permission, Request $request)
    {
        try {
            DB::beginTransaction();
            $users = User::leftJoin('users_permissions', 'users_permissions.user_id', '=', 'users.id')
                ->leftJoin('permissions', 'permissions.id', '=', 'users_permissions.permission_id')
                ->select("users.id")
                ->index($request->all(), 'users.name', 'asc')->get();
            $permission->users()->sync($users->modelKeys() ?? []);
            DB::commit();
            alert()->success('Usuários atribuídos à Permissão com Sucesso!');
            return redirect()->route($this->bag['route'] . '.show', ['permission' => $permission->getKey()]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }
}
