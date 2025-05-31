<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificationStock extends Model
{
    use HasFactory;

    protected $table = 'modifications_stock';

    // ✅ Constante pour sécuriser les actions autorisées
    public const ACTIONS = [
        'ajout',
        'modification',
        'suppression',
        'réapprovisionnement',
    ];

    protected $fillable = [
        'produit_id',
        'nom_produit',
        'gestionnaire_id',
        'action',
        'ancienne_quantite',
        'nouvelle_quantite',
        'quantite_totale',
        'date_modification',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }
}
