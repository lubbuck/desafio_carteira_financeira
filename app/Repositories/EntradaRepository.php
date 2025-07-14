<?php

namespace App\Repositories;

use App\Contracts\Repositories\EntradaRepositoryInterface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Models\Entrada;

class EntradaRepository implements EntradaRepositoryInterface
{
    protected $model;

    public function __construct(Entrada $model)
    {
        $this->model = $model;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function create($data): Model
    {
        return $this->model->create($data);
    }

    public function all($filters, $order, $sort): Collection
    {
        return $this->model->index($filters, $order, $sort)->get();
    }
}
