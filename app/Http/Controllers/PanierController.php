<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanierController extends Controller
{
    /**
     * Ajoute un produit au panier de session.
     */
    public function ajouter(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|integer',
            'quantite'   => 'required|integer|min:1'
        ]);

        $produitId = $request->produit_id;
        $quantite = $request->quantite;

        // Récupérer ou initialiser le panier en session
        $panier = session()->get('panier', []);

        // Ajouter ou mettre à jour la quantité
        if (isset($panier[$produitId])) {
            $panier[$produitId] += $quantite;
        } else {
            $panier[$produitId] = $quantite;
        }

        session()->put('panier', $panier);

        return back()->with('success', 'Produit ajouté au panier.');
    }

    /**
     * Supprime un produit du panier.
     */
    public function supprimer($id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vide complètement le panier.
     */
    public function vider()
    {
        session()->forget('panier');
        return back()->with('success', 'Panier vidé.');
    }
    

}
