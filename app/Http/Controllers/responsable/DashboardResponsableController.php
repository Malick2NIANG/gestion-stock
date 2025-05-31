<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produit;
use App\Models\Vente;
use App\Models\ModificationStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardResponsableController extends Controller
{
    public function index()
    {
        // 📌 Utilisateurs
        $nbVendeurs = User::where('role', 'vendeur')->count();
        $nbGestionnaires = User::where('role', 'gestionnaire')->count();

        // 📌 Produits
        $produits = Produit::all();
        $totalProduits = $produits->count();
        $valeurTotaleStock = $produits->sum(fn($p) => $p->prix_unitaire * $p->quantite);
        $coutTotalAcquisition = $produits->sum(fn($p) => $p->prix_acquisition * $p->quantite);

        $ruptures = $produits->where('quantite', '<=', 0)->count();
        $sousSeuil = $produits->where('quantite', '<=', 50)->where('quantite', '>', 0)->count();

        $aujourdHui = now()->startOfDay();
        $dans7Jours = now()->addDays(7)->endOfDay();
        $bientotExpires = $produits->whereBetween('date_expiration', [$aujourdHui, $dans7Jours])->count();
        $expires = $produits->where('date_expiration', '<', $aujourdHui)->count();

        // 📌 Ventes
        $ventes = Vente::all();
        $totalVentes = $ventes->count();
        $quantiteTotaleVendue = $ventes->sum('quantite');
        $montantTotal = $ventes->sum('prix_total');

        // 📈 Ventes par jour (NOMBRE de ventes)
        $ventesParJour = Vente::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📈 Chiffre d'affaires (CA) par jour
        $caParJour = Vente::selectRaw('DATE(created_at) as date, SUM(prix_total) as total_ca')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📊 Top produits vendus
        $topProduits = Vente::with('produit')
            ->select('produit_id', DB::raw('SUM(quantite) as total'))
            ->groupBy('produit_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->filter(fn($v) => $v->produit);

        $topLabels = $topProduits->pluck('produit.nom_produit')->values();
        $topData = $topProduits->pluck('total')->values();

        // 📊 Produits les moins vendus
        $moinsVendus = Vente::with('produit')
            ->select('produit_id', DB::raw('SUM(quantite) as total'))
            ->groupBy('produit_id')
            ->orderBy('total')
            ->take(5)
            ->get()
            ->filter(fn($v) => $v->produit);

        $moinsLabels = $moinsVendus->pluck('produit.nom_produit')->values();
        $moinsData = $moinsVendus->pluck('total')->values();

        // 🍰 Répartition des catégories (stock)
        $categories = Produit::select('categorie', DB::raw('COUNT(*) as total'))
            ->groupBy('categorie')
            ->get();

        $categorieLabels = $categories->pluck('categorie')->values();
        $categorieData = $categories->pluck('total')->values();

        // 📊 Répartition des ventes par catégorie (univers)
        $ventesParUnivers = Vente::join('produits', 'ventes.produit_id', '=', 'produits.id')
            ->select('produits.categorie as univers', DB::raw('SUM(ventes.quantite) as total'))
            ->groupBy('produits.categorie')
            ->get();

        $universLabels = $ventesParUnivers->pluck('univers')->values();
        $universData = $ventesParUnivers->pluck('total')->values();

        // ✅ Rendu de la vue
        return view('responsable.dashboard-rapports', compact(
            'nbVendeurs',
            'nbGestionnaires',
            'totalProduits',
            'valeurTotaleStock',
            'coutTotalAcquisition',
            'ruptures',
            'sousSeuil',
            'bientotExpires',
            'expires',
            'totalVentes',
            'quantiteTotaleVendue',
            'montantTotal',
            'ventesParJour',
            'caParJour',
            'topLabels',
            'topData',
            'moinsLabels',
            'moinsData',
            'categorieLabels',
            'categorieData',
            'universLabels',
            'universData',
        ));
    }

    public function historiqueVentes()
    {
        $ventes = Vente::with(['produit', 'vendeur'])
            ->orderByDesc('date_vente')
            ->get();

        $grouped = $ventes->groupBy(function ($item) {
            return Carbon::parse($item->date_vente)->format('d/m/Y');
        })->map(function ($dayGroup) {
            return $dayGroup->groupBy(function ($item) {
                return Carbon::parse($item->date_vente)->format('H:i');
            });
        });

        return view('responsable.historique-ventes', compact('grouped'));
    }

    public function historiqueModifications()
    {
        $modifications = ModificationStock::with('gestionnaire')
            ->latest('date_modification')
            ->get();

        return view('responsable.historique-modifications', compact('modifications'));
    }
}
