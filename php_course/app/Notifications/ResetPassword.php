<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends BaseResetPassword
{
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->subject(Lang::get('Уведомление о сбросе пароля'))
            ->line(Lang::get('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.'))
            ->action(Lang::get('Сбросить пароль'), $this->resetUrl($notifiable))
            ->line(Lang::get('Срок действия ссылки для сброса пароля истечет через :count минут.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.'));
    }
}
