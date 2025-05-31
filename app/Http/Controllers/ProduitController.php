<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\ModificationStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'prix_acquisition' => 'required|numeric|min:0.01', // ✅
            'quantite' => 'required|integer|min:0',
            'date_expiration' => 'nullable|date'
        ]);

        $produit = Produit::create($validated);

        ModificationStock::create([
            'produit_id' => $produit->id,
            'nom_produit' => $produit->nom_produit,
            'gestionnaire_id' => Auth::id(),
            'action' => 'ajout',
            'ancienne_quantite' => null,
            'nouvelle_quantite' => $validated['quantite'],
            'quantite_totale' => $validated['quantite'],
            'date_modification' => now(),
        ]);

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
            'prix_acquisition' => 'required|numeric|min:0.01', // ✅
            'quantite' => 'required|integer|min:0',
            'date_expiration' => 'nullable|date'
        ]);

        $ancienneQuantite = $produit->quantite;

        $produit->update($validated);

        ModificationStock::create([
            'produit_id' => $produit->id,
            'nom_produit' => $produit->nom_produit,
            'gestionnaire_id' => Auth::id(),
            'action' => 'modification',
            'ancienne_quantite' => $ancienneQuantite,
            'nouvelle_quantite' => $validated['quantite'],
            'quantite_totale' => $validated['quantite'],
            'date_modification' => now(),
        ]);

        return redirect()->route('produits.index')->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Produit $produit)
    {
        ModificationStock::create([
            'produit_id' => $produit->id,
            'nom_produit' => $produit->nom_produit,
            'gestionnaire_id' => Auth::id(),
            'action' => 'suppression',
            'ancienne_quantite' => $produit->quantite,
            'nouvelle_quantite' => 0,
            'quantite_totale' => 0,
            'date_modification' => now(),
        ]);

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
        if (Session::get('alertes_vues')) {
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
    $produits = Produit::all();

    $totalProduits = $produits->count();

    // Valeur totale du stock (prix de vente)
    $valeurTotaleStock = $produits->sum(function ($produit) {
        return $produit->prix_unitaire * $produit->quantite;
    });

    // Coût total d'acquisition (prix acquisition * quantité)
    $coutTotalAcquisition = $produits->sum(function ($produit) {
        return $produit->prix_acquisition * $produit->quantite;
    });

    $produitsSousSeuil = $produits->where('quantite', '<=', 50)->where('quantite', '>', 0)->count();
    $produitsRupture = $produits->where('quantite', '<=', 0)->count();

    $today = now()->startOfDay();
    $in7days = now()->addDays(7)->endOfDay();

    $bientotExpires = $produits->filter(function ($produit) use ($today, $in7days) {
        return $produit->date_expiration && $produit->date_expiration >= $today && $produit->date_expiration <= $in7days;
    });

    $expires = $produits->filter(function ($produit) use ($today) {
        return $produit->date_expiration && $produit->date_expiration < $today;
    });

    return view('produits.rapports', compact(
        'totalProduits',
        'valeurTotaleStock',
        'coutTotalAcquisition',
        'produitsSousSeuil',
        'produitsRupture',
        'bientotExpires',
        'expires'
    ));
}

public function exportPdf()
{
    $produits = Produit::all();

    $totalProduits = $produits->count();

    // Valeur totale du stock (prix de vente)
    $valeurTotaleStock = $produits->sum(function ($produit) {
        return $produit->prix_unitaire * $produit->quantite;
    });

    // Coût total d'acquisition
    $coutTotalAcquisition = $produits->sum(function ($produit) {
        return $produit->prix_acquisition * $produit->quantite;
    });

    $produitsSousSeuil = $produits->where('quantite', '<=', 50)->where('quantite', '>', 0)->count();
    $produitsRupture = $produits->where('quantite', '<=', 0)->count();

    $today = now()->startOfDay();
    $in7days = now()->addDays(7)->endOfDay();

    $rupture = $produits->where('quantite', '<=', 0);
    $seuil = $produits->where('quantite', '<=', 50)->where('quantite', '>', 0);
    $bientotExpires = $produits->filter(fn($p) => $p->date_expiration && $p->date_expiration >= $today && $p->date_expiration <= $in7days);
    $expires = $produits->filter(fn($p) => $p->date_expiration && $p->date_expiration < $today);

    $pdf = Pdf::loadView('produits.rapports-pdf', compact(
        'totalProduits',
        'valeurTotaleStock',
        'coutTotalAcquisition',
        'produitsSousSeuil',
        'produitsRupture',
        'rupture',
        'seuil',
        'bientotExpires',
        'expires'
    ));

    return $pdf->download('rapport-stock-gestionnaire.pdf');
}

}
