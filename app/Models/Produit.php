<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

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

    /**
     * Compter les alertes non vues (badge rouge)
     */
    public static function compterAlertesNonVues()
    {
        if (Session::get('alertes_vues')) {
            return 0;
        }

        $today = now()->startOfDay();
        $in7days = now()->addDays(7)->endOfDay();

        $rupture = self::where('quantite', '<=', 0)->count();
        $seuil = self::where('quantite', '<=', 50)->where('quantite', '>', 0)->count();
        $bientotExpires = self::whereDate('date_expiration', '>=', $today)
                              ->whereDate('date_expiration', '<=', $in7days)
                              ->count();
        $expires = self::whereDate('date_expiration', '<', $today)->count();

        return $rupture + $seuil + $bientotExpires + $expires;
    }
}
