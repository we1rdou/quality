<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🔐 Tu contraseña ha sido cambiada - QualityApp')
            ->greeting('¡Hola!')
            ->line('Te confirmamos que tu contraseña ha sido cambiada exitosamente.')
            ->line('Si realizaste este cambio, puedes ignorar este mensaje.')
            ->line('Si NO fuiste tú quien cambió la contraseña, tu cuenta podría estar comprometida.')
            ->action('🔒 Acceder a mi cuenta', url('/login'))
            ->line('Por tu seguridad, te recomendamos:')
            ->line('• Cambiar tu contraseña inmediatamente')
            ->line('• Revisar la actividad reciente de tu cuenta')
            ->line('• Contactar a nuestro equipo de soporte si necesitas ayuda')
            ->line('')
            ->line('Saludos,')
            ->line('El equipo de QualityApp')
            ->salutation('');
    }
}
