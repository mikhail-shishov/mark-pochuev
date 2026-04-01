<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('Подтверждение адреса электронной почты'))
            ->line(Lang::get('Пожалуйста, нажмите на кнопку ниже, чтобы подтвердить свой адрес электронной почты.'))
            ->action(Lang::get('Подтвердить адрес'), $verificationUrl)
            ->line(Lang::get('Если вы не создавали учетную запись, никаких дальнейших действий не требуется.'));
    }
}
