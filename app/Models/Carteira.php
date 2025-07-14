<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;
use Dds\Classes\DDS;

class Carteira extends Model
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

    protected $table = 'carteiras';

    protected $fillable = [
        'codigo',
        'saldo',
        'ativada',
        'user_id'
    ];

    protected $casts = [
        'ativada' => 'boolean'
    ];

    protected $searchable = [
        'codigo' => ['like', 'carteiras.codigo'],
        'saldo' => ['float', 'carteiras.saldo'],
        'user_id' => ['uuid', 'carteiras.user_id'],
        'created' => ['date', 'carteiras.created_at'],
        'created_from' => ['begin', 'carteiras.created_at'],
        'created_to' => ['end', 'carteiras.created_at'],
    ];

    public function saldo()
    {
        return DDS::intToFloat2C($this->saldo);
    }

    public function ativada()
    {
        return $this->ativada ? 'Ativada' : 'Desativada';
    }

    public function situacao()
    {
        return $this->ativada ? $this->saldo() : 'Desativada';
    }

    public function possuiSaldo()
    {
        return $this->saldo > 0;
    }

    public function possuiSaldoParaRetirar($valor)
    {
        return (int) $this->saldo >= (int) $valor;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'carteira_id');
    }

    public function saidas()
    {
        return $this->hasMany(Saida::class, 'carteira_id');
    }

    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'carteira_id');
    }
}
