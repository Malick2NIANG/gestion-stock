<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ConnexionNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $ip = request()->ip();
        $userAgent = request()->header('User-Agent');
        $date = now()->format('d/m/Y H:i');

        return (new MailMessage)
            ->subject('🔐 Connexion détectée sur votre compte Gestion Stock')
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom . ',')
            ->line('✅ Une nouvelle connexion à votre compte **Gestion Stock** a été détectée.')
            ->line('Voici les informations de connexion :')
            ->line("📅 **Date** : $date")
            ->line("📍 **Adresse IP** : $ip")
            ->line("🖥️ **Navigateur/Appareil** : $userAgent")
            ->line('')
            ->line('> Si c’est bien vous, vous pouvez ignorer ce message.')
            ->line('> Si ce n’est pas vous, nous vous recommandons de changer immédiatement votre mot de passe.')
            ->action('Changer mon mot de passe', url('/password/reset'))
            ->salutation('Cordialement, l’équipe Gestion Stock');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
