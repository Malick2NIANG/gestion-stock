<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'user_id',           // vendeur qui a effectué la vente
        'quantite',
        'prix_total',
        'mode_paiement',     // espèces, mobile, carte, etc.
        'date_vente',        // facultatif, utile si besoin de personnaliser la date
    ];

    protected $dates = ['date_vente'];

    // 🔁 Relation avec le produit
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    // 🔁 Relation avec le vendeur (utilisateur)
    public function vendeur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
