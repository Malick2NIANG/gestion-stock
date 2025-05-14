<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nom_produit', 'like', "%$search%")
                ->orWhere('code_produit', 'like', "%$search%");
        }

        $produits = $query->get();

        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_produit' => 'required|string|unique:produits,code_produit',
            'nom_produit' => 'required|string',
            'categorie' => 'required|in:Alimentaire,Auto,Non alimentaire',
            'prix_unitaire' => 'required|numeric|min:0.01',
            'quantite' => 'required|integer|min:0',
            'date_expiration' => 'nullable|date'
        ]);

        Produit::create($validated);

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'code_produit' => 'required|string|unique:produits,code_produit,' . $produit->id,
            'nom_produit' => 'required|string',
            'categorie' => 'required|in:Alimentaire,Auto,Non alimentaire',
            'prix_unitaire' => 'required|numeric|min:0.01',
            'quantite' => 'required|integer|min:0',
            'date_expiration' => 'nullable|date'
        ]);

        $produit->update($validated);

        return redirect()->route('produits.index')->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function alertes()
    {
        $today = now()->startOfDay();
        $in7days = now()->addDays(7)->endOfDay();

        $rupture = Produit::where('quantite', '<=', 0)->get();
        $seuil = Produit::where('quantite', '<=', 50)->where('quantite', '>', 0)->get();
        $bientotExpires = Produit::whereDate('date_expiration', '>=', $today)
                                ->whereDate('date_expiration', '<=', $in7days)->get();
        $expires = Produit::whereDate('date_expiration', '<', $today)->get();

        Session::put('alertes_vues', true);

        return view('produits.alertes', compact('rupture', 'seuil', 'bientotExpires', 'expires'));
    }

    public static function compterAlertesNonVues()
    {
        if (Session::has('alertes_vues')) {
            return 0;
        }

        $today = now()->startOfDay();
        $in7days = now()->addDays(7)->endOfDay();

        return Produit::where('quantite', '<=', 0)->count() +
               Produit::where('quantite', '<=', 50)->where('quantite', '>', 0)->count() +
               Produit::whereDate('date_expiration', '>=', $today)
                      ->whereDate('date_expiration', '<=', $in7days)->count() +
               Produit::whereDate('date_expiration', '<', $today)->count();
    }
    public function rapports()
{
    // En attendant une vraie analyse, on redirige vers l'index ou une vue de placeholder
    return view('produits.rapports');
}

}
