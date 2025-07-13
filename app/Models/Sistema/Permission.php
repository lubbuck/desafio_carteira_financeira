<?php

namespace App\Models\Sistema;

use Dds\Traits\FastModel;
use App\Observers\AuditoriaObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Permission extends Model
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

    protected $table = 'permissions';

    protected $fillable = [
        'nome',
        'group',
        'sub_group',
        'is_open',
        'descricao',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];

    protected $searchable = [
        'nome' => ['ilike', 'permissions.nome'],
        'group' => ['ilike', [
            'permissions.group',
            'permissions.sub_group'
        ]],
        'route_name' => ['ilike', 'permissions_rotas.route_name'],
    ];

    public function subGroup()
    {
        return $this->sub_group ?? 'Sem Subgrupo';
    }

    public function rotas()
    {
        return $this->hasMany(PermissionRoute::class, 'permission_id');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'users_permissions', 'permission_id', 'user_id');
    }
}
