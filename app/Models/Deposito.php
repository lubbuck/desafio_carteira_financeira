<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;
use Dds\Classes\DDS;

class Deposito extends Model
{
    use HasFactory, FastModel;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->primaryKey} = Uuid::uuid4();
        });

        parent::observe(AuditoriaObserver::class);
    }

    protected $keyType = 'string';

    protected $table = 'depositos';

    protected $fillable = [
        'valor',
        'status',
        'carteira_id'
    ];

    protected $searchable = [
        'valor' => ['float', 'depositos.valor'],
        'status' => ['=', 'depositos.status'],
        'carteira_id' => ['uuid', 'depositos.carteira_id'],
        'created' => ['date', 'depositos.created_at'],
        'created_from' => ['begin', 'depositos.created_at'],
        'created_to' => ['end', 'depositos.created_at'],
    ];

    public function valor()
    {
        return DDS::intToFloat2C($this->valor);
    }

    public function status()
    {
        return config('project.enums.status_depositos')[$this->status];
    }

    public function carteira()
    {
        return $this->belongsTo(Carteira::class, 'carteira_id');
    }

    public function reversao()
    {
        return $this->hasOne(DepositoReversao::class, 'deposito_id');
    }
}
