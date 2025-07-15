<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;
use Dds\Classes\DDS;

class Transferencia extends Model
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

    protected $table = 'transferencias';

    protected $fillable = [
        'valor',
        'status',
        'carteira_origem_id',
        'carteira_destino_id'
    ];

    protected $searchable = [
        'valor' => ['float', 'transferencias.valor'],
        'status' => ['=', 'transferencias.status'],
        'carteira_origem_id' => ['uuid', 'transferencias.carteira_origem_id'],
        'carteira_destino_id' => ['uuid', 'transferencias.carteira_destino_id'],
        'created' => ['date', 'transferencias.created_at'],
        'created_from' => ['begin', 'transferencias.created_at'],
        'created_to' => ['end', 'transferencias.created_at'],
    ];

    public function valor()
    {
        return DDS::intToFloat2C($this->valor);
    }

    public function status()
    {
        return config('project.enums.status_transferencias')[$this->status];
    }

    public function isOrigem($carteira_id)
    {
        return $this->carteira_origem_id == $carteira_id;
    }

    public function isDestino($carteira_id)
    {
        return $this->carteira_destino_id == $carteira_id;
    }

    public function origem()
    {
        return $this->belongsTo(Carteira::class, 'carteira_origem_id');
    }

    public function destino()
    {
        return $this->belongsTo(Carteira::class, 'carteira_destino_id');
    }

    public function reversao()
    {
        return $this->hasOne(TransferenciaReversao::class, 'transferencia_id');
    }

    public function solicitacaoReversao()
    {
        return $this->hasOne(SolicitacaoTransferenciaReversao::class, 'transferencia_id');
    }
}
