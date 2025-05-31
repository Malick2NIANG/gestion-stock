<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Notifications\ConnexionNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Ajoute d'autres événements ici si besoin
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Lorsqu’un utilisateur se connecte, on lui envoie un mail de notification
        Event::listen(Login::class, function ($event) {
            $event->user->notify(new ConnexionNotification());
        });
    }
}
