<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EntradaRepositoryInterface
{
    public function model(): Model;
    public function create(array $data): Model;
    public function all($filters, $order, $sort): Collection;
}
