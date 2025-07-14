<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;
use Dds\Classes\DDS;

class Saida extends Model
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

    protected $table = 'saidas';

    protected $fillable = [
        'tipo_operacao',
        'valor',
        'status',
        'operacao_id',
        'carteira_id'
    ];

    protected $searchable = [
        'tipo_operacao' => ['=', 'saidas.tipo_operacao'],
        'valor' => ['float', 'saidas.valor'],
        'status' => ['=', 'saidas.status'],
        'carteira_id' => ['uuid', 'saidas.carteira_id'],
        'created' => ['date', 'saidas.created_at'],
        'created_from' => ['begin', 'saidas.created_at'],
        'created_to' => ['end', 'saidas.created_at'],
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
        return config('project.enums.status_saidas')[$this->status];
    }

    public function carteira()
    {
        return $this->belongsTo(Carteira::class, 'carteira_id');
    }
}
