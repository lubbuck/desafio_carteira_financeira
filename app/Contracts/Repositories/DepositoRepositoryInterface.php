<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface DepositoRepositoryInterface
{
    public function model(): Model;
    public function create(array $data): Model;
    public function find($id): ?Model;
    public function all($filters, $order, $sort): Collection;
    public function paginated($filters, $order, $sort): LengthAwarePaginator;
}
