<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('🔑 Recupera tu contraseña - QualityApp')
            ->greeting('¡Hola!')
            ->line('Recibimos una solicitud para restablecer la contraseña de tu cuenta.')
            ->line('Haz clic en el siguiente botón para crear una nueva contraseña:')
            ->action('🔄 Restablecer Contraseña', $url)
            ->line('Este enlace de restablecimiento expirará en 60 minutos.')
            ->line('Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna acción.')
            ->line('')
            ->line('Saludos,')
            ->line('El equipo de QualityApp')
            ->salutation('');
    }
}
