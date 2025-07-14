<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create($data): Model
    {
        $data['password'] = Hash::make($data['password'] ?? Str::random(8));
        return $this->model->create($data);
    }

    public function find($id): ?Model
    {
        if (!Str::isUuid($id)) {
            return null;
        }

        return $this->model->find($id);
    }

    public function all($filters, $order, $sort): Collection
    {
        return $this->model->index($filters, $order, $sort)->get();
    }

    public function paginated($filters, $order, $sort): LengthAwarePaginator
    {
        return $this->model->index($filters, $order, $sort)->qtdPag($filters['qtd'] ?? null);
    }
}
