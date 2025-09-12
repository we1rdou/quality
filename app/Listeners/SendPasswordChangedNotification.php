<?php

namespace App\Listeners;

use App\Notifications\PasswordChangedNotification;
use Illuminate\Auth\Events\PasswordReset;

class SendPasswordChangedNotification
{
    /**
     * Handle the event.
     */
    public function handle(PasswordReset $event): void
    {
        // Enviar notificación al usuario que cambió su contraseña
        $event->user->notify(new PasswordChangedNotification());
    }
}
