<?php

namespace App\Repositories;

use App\Contracts\Repositories\CarteiraRepositoryInterface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Str;
use App\Models\Carteira;

class CarteiraRepository implements CarteiraRepositoryInterface
{
    protected $model;

    public function __construct(Carteira $model)
    {
        $this->model = $model;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function create($data): Model
    {
        $data['codigo'] = Str::random(50);
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

    public function buscarCarteiraAtiva($user_id): ?Model
    {
        return $this->model->where('user_id', $user_id)->where('ativada', true)->first();
    }
}
