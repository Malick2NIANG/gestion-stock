<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'code_produit',
        'nom_produit',
        'categorie',
        'prix_unitaire',
        'quantite',
        'date_expiration'
    ];

    protected $dates = ['date_expiration'];

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }
}
