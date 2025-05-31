<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ventes()
    {
        return $this->hasMany(Vente::class, 'vendeur_id');
    }

    public function isVendeur()
    {
        return $this->role === 'vendeur';
    }

    public function isGestionnaire()
    {
        return $this->role === 'gestionnaire';
    }

    public function isResponsable()
    {
        return $this->role === 'responsable';
    }
    public function reapprovisionnements()
    {
        return $this->hasMany(Reapprovisionnement::class, 'gestionnaire_id');
    }

}

