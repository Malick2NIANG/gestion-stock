<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $fillable = [
        'produit_id',
        'vendeur_id',
        'quantite_vendue',
        'date_vente',
        'montant_total',
    ];

    protected $dates = ['date_vente'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }
}
