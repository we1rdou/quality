<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\BankAccount;
use App\Models\User;

class BankAccountDataNotification extends Notification
{
    use Queueable;

    public $bankAccount;
    public $owner;

    public function __construct(BankAccount $bankAccount, User $owner)
    {
        $this->bankAccount = $bankAccount;
        $this->owner = $owner;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Datos bancarios de ' . $this->owner->name)
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('El propietario ' . $this->owner->name . ' te ha enviado sus datos bancarios para pagos:')
            ->line('Banco: ' . $this->bankAccount->bank_name)
            ->line('Número de cuenta: ' . $this->bankAccount->account_number)
            ->line('Tipo de cuenta: ' . $this->bankAccount->account_type)
            ->line('Titular: ' . $this->bankAccount->account_holder)
            ->line('Cédula/RUC: ' . $this->bankAccount->ci_number)
            ->line('Teléfono de contacto: ' . $this->bankAccount->phone)
            ->line('Si tienes dudas, contacta al propietario.');
    }
}
