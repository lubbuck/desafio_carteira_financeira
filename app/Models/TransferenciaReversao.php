<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;
use Dds\Classes\DDS;

class TransferenciaReversao extends Model
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
        'valor',
        'status',
        'transferencia_id'
    ];

    protected $searchable = [
        'valor' => ['float', 'transferencias_reversao.valor'],
        'status' => ['=', 'transferencias_reversao.status'],
        'transferencia_id' => ['uuid', 'transferencias_reversao.transferencia_id'],
        'created' => ['date', 'transferencias_reversao.created_at'],
        'created_from' => ['begin', 'transferencias_reversao.created_at'],
        'created_to' => ['end', 'transferencias_reversao.created_at'],
    ];

    public function valor()
    {
        return DDS::intToFloat2C($this->valor);
    }

    public function status()
    {
        return config('project.enums.status_transferencias_reversao')[$this->status];
    }

    public function transferencia()
    {
        return $this->belongsTo(Transferencia::class, 'transferencia_id');
    }
}
