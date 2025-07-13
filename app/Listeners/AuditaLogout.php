<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\Sistema\AuditoriaAcesso;

class AuditaLogout
{
    public function __construct()
    {
        //
    }

    public function handle(Logout $event)
    {
        AuditoriaAcesso::create([
            'user_id' => $event->user->id,
            'event' => 'LOGOUT',
            'url' => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
