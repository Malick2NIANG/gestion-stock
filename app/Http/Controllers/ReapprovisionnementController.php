<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Reapprovisionnement;
use App\Models\ModificationStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReapprovisionnementController extends Controller
{
    /**
     * Affiche la liste des produits pour réapprovisionnement.
     */
    public function listeProduits()
    {
        $produits = Produit::all();
        return view('reapprovisionnement.liste_produits', compact('produits'));
    }

    /**
     * Affiche le formulaire de réapprovisionnement pour un produit.
     */
    public function formulaire(Produit $produit)
    {
        return view('reapprovisionnement.create', compact('produit'));
    }

    /**
     * Enregistre un réapprovisionnement.
     */
    public function store(Request $request, Produit $produit)
    {
        // Validation
        $validated = $request->validate([
            'quantite_ajoutee' => 'required|integer|min:1',
            'prix_acquisition_unitaire' => 'required|numeric|min:0.01',
        ]);

        // Création du réapprovisionnement
        $reappro = Reapprovisionnement::create([
            'produit_id' => $produit->id,
            'gestionnaire_id' => Auth::id(),
            'quantite_ajoutee' => $validated['quantite_ajoutee'],
            'prix_acquisition_unitaire' => $validated['prix_acquisition_unitaire'],
            'prix_acquisition_total' => $validated['quantite_ajoutee'] * $validated['prix_acquisition_unitaire'],
            'date_reappro' => now(),
        ]);

        // Mise à jour du produit
        $ancienne_quantite = $produit->quantite;
        $produit->quantite += $validated['quantite_ajoutee'];
        $produit->prix_acquisition = $validated['prix_acquisition_unitaire'];
        $produit->save();

        // Historique des modifications
ModificationStock::create([
    'produit_id' => $produit->id,
    'nom_produit' => $produit->nom_produit,
    'gestionnaire_id' => Auth::id(),
    'action' => 'réapprovisionnement',
    'ancienne_quantite' => $ancienne_quantite,
    'nouvelle_quantite' => $validated['quantite_ajoutee'], // ✅ correction ici
    'quantite_totale' => $produit->quantite, // ✅ ceci reste la quantité finale
    'date_modification' => now(),
]);


        return redirect()->route('reapprovisionnement.liste_produits')
            ->with('success', 'Réapprovisionnement enregistré avec succès.');
    }

    /**
     * (Optionnel) Affiche l’historique des réapprovisionnements.
     */
    public function index()
    {
        $reapprovisionnements = Reapprovisionnement::with('produit', 'gestionnaire')
            ->orderBy('date_reappro', 'desc')
            ->get();

        return view('reapprovisionnement.index', compact('reapprovisionnements'));
    }
}
