<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Redefinição de senha')
            ->line('Você esta recebendo esse e-mail, porque uma redefinição de senha foi solicitada.')
            ->action('Redifinir senha', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Se você não requisitou isto, por favor desconsidere.');
    }
}
