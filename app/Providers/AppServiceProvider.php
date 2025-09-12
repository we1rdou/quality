<?php

namespace App\Providers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar listener de forma única para envío de notificación cuando se cambie contraseña
        Event::listen(PasswordReset::class, function (PasswordReset $event) {
            // Agregar un pequeño delay para evitar duplicaciones
            if (!cache()->has('password_changed_' . $event->user->id)) {
                cache()->put('password_changed_' . $event->user->id, true, 10); // 10 segundos
                $event->user->notify(new \App\Notifications\PasswordChangedNotification());
            }
        });
    }
}
