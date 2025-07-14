<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use App\Observers\AuditoriaObserver;
use Dds\Traits\FastModel;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, FastModel;

    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->primaryKey} = Uuid::uuid4();
        });

        parent::observe(AuditoriaObserver::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_super_admin' => 'boolean',
        ];
    }

    protected $searchable = [
        'user' => ['ilike', [
            'users.name',
            'users.cpf'
        ]],
        'name' => ['ilike', 'users.name'],
        'email' => ['ilike', 'users.email'],
        'permission_nome' => ['ilike', 'permissions.nome'],
        'permission_group' => ['ilike', 'permissions.group'],
        'permission_sub_group' => ['ilike', 'permissions.sub_group'],
        'created' => ['date', 'users.created_at'],
        'created_from' => ['begin', 'users.created_at'],
        'created_to' => ['end', 'users.created_at'],
    ];

    public function isLogged()
    {
        return auth()->id() == $this->id;
    }

    public function isAdmin()
    {
        return $this->isSuperAdmin() || $this->is_admin;
    }

    public function isSuperAdmin()
    {
        return $this->is_super_admin;
    }

    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Sistema\Permission::class, 'users_permissions', 'user_id', 'permission_id');
    }

    public function carteiras()
    {
        return $this->hasMany(Carteira::class, 'user_id');
    }
}
