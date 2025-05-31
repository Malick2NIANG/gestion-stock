<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Affiche la liste globale des produits avec alertes éventuelles.
     */
    public function index(Request $request)
    {
        $today = Carbon::today()->startOfDay();
        $in7days = Carbon::now()->addDays(7)->endOfDay();

        $produits = Produit::orderBy('nom_produit')->get();

        $rupture = Produit::where('quantite', '<=', 0)->get();
        $seuil = Produit::where('quantite', '<=', 50)->where('quantite', '>', 0)->get();
        $bientotExpires = Produit::whereDate('date_expiration', '>=', $today)
                                ->whereDate('date_expiration', '<=', $in7days)->get();
        $expires = Produit::whereDate('date_expiration', '<', $today)->get();

        return view('responsable.index', compact(
            'produits',
            'rupture',
            'seuil',
            'bientotExpires',
            'expires'
        ));
    }
}
