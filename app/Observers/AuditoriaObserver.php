<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Auditoria;

class AuditoriaObserver
{
    public function setInDatabase($event, $model, $realValues = null)
    {
        Auditoria::create([
            'user_type' => Auth::check() ? 'users' : "Seed",
            'user_id' => Auth::user()->id ?? null,
            'event' => $event,
            'table_name' => $model->getTable(),
            'table_id' => strval($model->getKey()),
            'new_values' => $realValues ?? $model->toArray(),
            'url' => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function created(Model $model)
    {
        $this->setInDatabase('CREATED', $model);
    }

    public function updated(Model $model)
    {
        $jsons = collect($model->getCasts())->filter(function ($value, $key) {
            return $value === 'array';
        })->keys()->toArray();

        $dirty = collect($model->getDirty())->map(function ($item, $key) use ($jsons) {
            return in_array($key, $jsons) ? json_decode($item, true) : $item;
        })->toArray();

        $this->setInDatabase('UPDATED', $model, $dirty);
    }

    public function deleted(Model $model)
    {
        $this->setInDatabase('DELETED', $model);
    }
}
