<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reapprovisionnement extends Model
{
    protected $fillable = [
        'produit_id',
        'gestionnaire_id',
        'quantite_initiale',
        'quantite_ajoutee',
        'quantite_totale',
        'prix_acquisition_unitaire',
        'prix_acquisition_total', // ✅ On ajoute bien ce champ !
        'date_reappro', // ✅ On utilise le bon nom
    ];

    public $timestamps = true;

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }
}
