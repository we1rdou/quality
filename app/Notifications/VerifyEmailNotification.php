<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('🔐 Verifica tu dirección de email - QualityApp')
            ->greeting('¡Hola!')
            ->line('Gracias por registrarte en QualityApp.')
            ->line('Para completar tu registro, necesitamos verificar tu dirección de email.')
            ->action('✅ Verificar Email', $verificationUrl)
            ->line('Si no creaste una cuenta, no es necesario realizar ninguna acción.')
            ->line('Este enlace expirará en 60 minutos.')
            ->line('')
            ->line('Saludos,')
            ->line('El equipo de QualityApp')
            ->salutation('');
    }
}
