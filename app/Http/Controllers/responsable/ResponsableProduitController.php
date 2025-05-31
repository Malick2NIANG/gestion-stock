<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Reapprovisionnement; // ✅ ajouter
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Vente;
use Carbon\Carbon;



class ResponsableProduitController extends Controller
{
public function rapports(Request $request)
{
    $produits = Produit::all();

    $totalProduits = $produits->count();

    // Valeur totale du stock (prix de vente)
    $valeurTotaleStock = $produits->sum(fn($p) => $p->prix_unitaire * $p->quantite);

    // Coût total d'acquisition du stock
    $coutTotalAcquisition = $produits->sum(fn($p) => $p->prix_acquisition * $p->quantite);

    $produitsSousSeuil = $produits->where('quantite', '<=', 50)->where('quantite', '>', 0)->count();
    $produitsRupture = $produits->where('quantite', '<=', 0)->count();

    $today = now()->startOfDay();
    $in7days = now()->addDays(7)->endOfDay();

    $bientotExpires = $produits->filter(fn($p) => $p->date_expiration && $p->date_expiration >= $today && $p->date_expiration <= $in7days);
    $expires = $produits->filter(fn($p) => $p->date_expiration && $p->date_expiration < $today);

    // *** BILAN INVENTAIRE ***
    $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : now()->startOfMonth();
    $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : now();

    // Ventes sur la période
    $ventesPeriode = Vente::whereBetween('date_vente', [$startDate, $endDate])->get();

    $quantiteVendue = $ventesPeriode->sum('quantite');
    $montantTotalVentes = $ventesPeriode->sum('prix_total');

    // Coût d'acquisition des produits vendus
    $coutAcquisitionVentes = $ventesPeriode->sum(function ($vente) {
        return $vente->produit ? $vente->produit->prix_acquisition * $vente->quantite : 0;
    });

    // Bénéfice net
    $beneficeNet = $montantTotalVentes - $coutAcquisitionVentes;

    // Pertes sur la période (produits expirés)
    $valeurPertes = $expires->sum(function ($produit) {
        return $produit->prix_acquisition * $produit->quantite;
    });

    return view('responsable.rapport', compact(
        'totalProduits',
        'valeurTotaleStock',
        'coutTotalAcquisition',
        'produitsSousSeuil',
        'produitsRupture',
        'bientotExpires',
        'expires',
        'startDate',
        'endDate',
        'quantiteVendue',
        'montantTotalVentes',
        'coutAcquisitionVentes',
        'beneficeNet',
        'valeurPertes'
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

    $pdf = Pdf::loadView('responsable.rapport-pdf', compact(
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

    return $pdf->download('rapport-stock-responsable.pdf');
}

}
