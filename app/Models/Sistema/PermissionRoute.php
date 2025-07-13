<?php

namespace App\Models\Sistema;

use Dds\Traits\FastModel;
use App\Observers\AuditoriaObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PermissionRoute extends Model
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

    protected $table = 'permissions_rotas';

    protected $fillable = [
        'route_name',
        'permission_id'
    ];

    protected $searchable = [
        'route_name' => ['ilike', 'permissions_rotas.route_name'],
        'permission' => ['ilike', 'permissions.nome'],
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
