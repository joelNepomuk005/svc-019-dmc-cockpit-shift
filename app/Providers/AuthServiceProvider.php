<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('SV SternTaler – E-Mail-Adressbestätigung')
                ->line('Sie haben sich gerade für den SternTalerShop registriert.')
                ->line('Um Ihren Registrierungsprozess abzuschließen, klicken Sie bitte den Button „E-Mail-Adresse bestätigen“.')
                ->line('Wenn Sie keine Registrierung durchgeführt haben, sind Ihrerseits keine weiteren Schritte erforderlich.')
                ->line('Sie können diese Bestätigungs-E-Mail ignorieren, es wird kein Nutzerkonto für Sie angelegt.')
                ->action('E-Mail Adresse bestätigen', $url);
        });
    }
}
