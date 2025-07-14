<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;
use Dds\Classes\DDS;

class Entrada extends Model
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

    protected $table = 'entradas';

    protected $fillable = [
        'tipo_operacao',
        'valor',
        'status',
        'operacao_id',
        'carteira_id'
    ];

    protected $searchable = [
        'tipo_operacao' => ['=', 'entradas.tipo_operacao'],
        'valor' => ['float', 'entradas.valor'],
        'status' => ['=', 'entradas.status'],
        'carteira_id' => ['uuid', 'entradas.carteira_id'],
        'created' => ['date', 'entradas.created_at'],
        'created_from' => ['begin', 'entradas.created_at'],
        'created_to' => ['end', 'entradas.created_at'],
    ];

    public function valor()
    {
        return DDS::intToFloat2C($this->valor);
    }

    public function tipoOperacao()
    {
        return config('project.enums.tipos_operacao')[$this->tipo_operacao];
    }

    public function status()
    {
        return config('project.enums.status_entradas')[$this->status];
    }

    public function carteira()
    {
        return $this->belongsTo(Carteira::class, 'carteira_id');
    }
}
