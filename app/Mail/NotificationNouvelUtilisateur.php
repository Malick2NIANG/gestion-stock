<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class NotificationNouvelUtilisateur extends Mailable
{
    use Queueable, SerializesModels;

    public $utilisateur;
    public $motDePasseTemp;

    /**
     * Crée une nouvelle instance du message.
     */
    public function __construct(User $utilisateur, $motDePasseTemp)
    {
        $this->utilisateur = $utilisateur;
        $this->motDePasseTemp = $motDePasseTemp;
    }

    /**
     * Construit le message.
     */
    public function build()
    {
        return $this->subject('🎉 Bienvenue sur l\'application de gestion de stock')
                    ->view('emails.nouvel-utilisateur')
                    ->with([
                        'prenom' => $this->utilisateur->prenom,
                        'email' => $this->utilisateur->email,
                        'motDePasseTemp' => $this->motDePasseTemp,
                    ]);
    }
}
