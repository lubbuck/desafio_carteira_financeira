<?php

namespace App\Models\Sistema;

use Dds\Traits\FastModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaAcesso extends Model
{
    use HasFactory, FastModel;

    protected $table = 'auditorias_acessos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'event',
        'url',
        'ip_address',
        'user_agent',
        'user_id',
    ];

    protected $searchable = [
        'created' => ['date', 'auditorias_acessos.created_at'],
        'event' => ['=', 'auditorias_acessos.event'],
        'user_id' => ['uuid', 'auditorias_acessos.user_id'],
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
