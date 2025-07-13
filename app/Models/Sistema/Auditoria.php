<?php

namespace App\Models\Sistema;

use Dds\Traits\FastModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory, FastModel;

    protected $table = 'auditorias';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_type',
        'user_id',
        'event',
        'table_name',
        'table_id',
        'new_values',
        'url',
        'ip_address',
        'user_agent'
    ];

    protected $searchable = [
        'created' => ['date', 'auditorias.created_at'],
        'user' => ['ilike', 'users.name'],
        'user_id' => ['uuid', 'auditorias.user_id'],
        'event' => ['=', 'auditorias.event'],
        'table_id' => ['=', 'auditorias.table_id'],
        'table_name' => ['ilike', 'auditorias.table_name'],
    ];

    protected $casts = [
        'new_values' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }  
}
