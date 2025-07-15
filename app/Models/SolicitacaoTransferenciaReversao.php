<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;

class SolicitacaoTransferenciaReversao extends Model
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

    protected $table = 'transferencias_reversao';

    protected $fillable = [
        'motivo',
        'transferencia'
    ];

    protected $searchable = [
        'motivo' => ['like', 'transferencias_reversao.motivo'],
        'transferencia' => ['uuid', 'transferencias_reversao.transferencia'],
        'created' => ['date', 'transferencias_reversao.created_at'],
        'created_from' => ['begin', 'transferencias_reversao.created_at'],
        'created_to' => ['end', 'transferencias_reversao.created_at'],
    ];

    public function transferencia()
    {
        return $this->belongsTo(Transferencia::class, 'transferencia_id');
    }
}
