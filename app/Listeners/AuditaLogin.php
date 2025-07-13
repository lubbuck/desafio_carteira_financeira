<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Sistema\AuditoriaAcesso;

class AuditaLogin
{
    public function __construct()
    {
        //
    }

    public function handle(Login $event)
    {
        AuditoriaAcesso::create([
            'user_id' => $event->user->id,
            'event' => 'LOGIN',
            'url' => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
