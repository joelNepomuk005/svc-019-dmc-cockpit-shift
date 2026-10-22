<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('DMC-Cockpit - Passwortanforderung')
            ->line('Sie haben ein neues Passwort für Ihr Benutzerkonto angefordert. Mit „Passwort zurücksetzen“ können Sie sich ein neues Passwort vergeben.')
            ->action('Passwort zurücksetzen', url('password/reset', $this->token))
            ->line('Der Link zum Passwort zurücksetzen ist für 60 Minuten aktiv.')
            ->line('Wenn Sie nicht die Zurücksetzung Ihres Passworts beantragt haben, sind Ihrerseits keine weiteren Schritte erforderlich. ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
