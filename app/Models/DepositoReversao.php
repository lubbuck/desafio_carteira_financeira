<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;
use Dds\Classes\DDS;

class DepositoReversao extends Model
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

    protected $table = 'depositos_reversao';

    protected $fillable = [
        'valor',
        'status',
        'deposito_id'
    ];

    protected $searchable = [
        'valor' => ['float', 'depositos_reversao.valor'],
        'status' => ['=', 'depositos_reversao.status'],
        'deposito_id' => ['uuid', 'depositos_reversao.deposito_id'],
        'created' => ['date', 'depositos_reversao.created_at'],
        'created_from' => ['begin', 'depositos_reversao.created_at'],
        'created_to' => ['end', 'depositos_reversao.created_at'],
    ];

    public function valor()
    {
        return DDS::intToFloat2C($this->valor);
    }

    public function status()
    {
        return config('project.enums.status_depositos_reversao')[$this->status];
    }

    public function deposito()
    {
        return $this->belongsTo(Deposito::class, 'deposito_id');
    }
}
