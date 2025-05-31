<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailModifieNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $utilisateur;
    public $type; // 'ancien' ou 'nouveau'

    public function __construct(User $utilisateur, $type = 'ancien')
    {
        $this->utilisateur = $utilisateur;
        $this->type = $type;
    }

    public function build()
    {
        return $this->subject('Notification de modification d’adresse email')
                    ->view('emails.email_modifie');
    }
}

