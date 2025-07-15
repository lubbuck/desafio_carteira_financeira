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

    protected $table = 'solicitacoes_transferencias_reversao';

    protected $fillable = [
        'motivo',
        'transferencia_id'
    ];

    protected $searchable = [
        'motivo' => ['like', 'solicitacoes_transferencias_reversao.motivo'],
        'transferencia_id' => ['uuid', 'solicitacoes_transferencias_reversao.transferencia_id'],
        'created' => ['date', 'solicitacoes_transferencias_reversao.created_at'],
        'created_from' => ['begin', 'solicitacoes_transferencias_reversao.created_at'],
        'created_to' => ['end', 'solicitacoes_transferencias_reversao.created_at'],
    ];

    public function transferencia()
    {
        return $this->belongsTo(Transferencia::class, 'transferencia_id');
    }
}
