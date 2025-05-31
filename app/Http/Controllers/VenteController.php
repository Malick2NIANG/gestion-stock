<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class VenteController extends Controller
{
    public function create()
    {
        $produits = Produit::where('quantite', '>', 0)->get();
        return view('vente.produits', compact('produits'));
    }

    public function formulaire($id)
    {
        $produit = Produit::findOrFail($id);
        return view('vente.formulaire-vente', compact('produit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1'
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        if ($request->quantite > $produit->quantite) {
            return back()->withErrors(['quantite' => 'Quantité demandée supérieure au stock disponible.']);
        }

        $prixHT = $produit->prix_unitaire * $request->quantite;
        $prixTTC = $prixHT * 1.18;

        Vente::create([
            'produit_id'    => $produit->id,
            'user_id'       => Auth::id(),
            'quantite'      => $request->quantite,
            'prix_total'    => $prixTTC,
            'mode_paiement' => 'especes'
        ]);

        $produit->decrement('quantite', $request->quantite);

        return redirect()->route('vente.create')->with('success', 'Vente enregistrée avec succès !');
    }

    public function recapitulatif()
    {
        $panier = session('panier', []);

        if (empty($panier)) {
            return redirect()->route('vente.create')->withErrors('Le panier est vide.');
        }

        $produits = Produit::whereIn('id', array_keys($panier))->get();
        $ventes = [];
        $totalGeneral = 0;

        foreach ($produits as $produit) {
            $quantite = $panier[$produit->id];
            $totalHT = $quantite * $produit->prix_unitaire;
            $totalTTC = $totalHT * 1.18;
            $totalGeneral += $totalTTC;

            $ventes[] = [
                'produit' => $produit,
                'quantite' => $quantite,
                'total' => $totalTTC,
            ];
        }

        return view('vente.recapitulatif', compact('ventes', 'totalGeneral'));
    }

    public function valider(Request $request)
    {
        $request->validate([
            'mode_paiement' => 'required|in:especes,wave,orange money,carte',
            'montant_recu' => 'nullable|numeric|min:0'
        ]);

        $panier = session('panier', []);
        if (empty($panier)) {
            return redirect()->route('vente.create')->withErrors('Le panier est vide.');
        }

        $ventesEffectuees = [];
        $totalGeneral = 0;

        foreach ($panier as $produitId => $quantite) {
            $produit = Produit::find($produitId);

            if (!$produit || $produit->quantite < $quantite) {
                return redirect()->route('vente.create')->withErrors("Produit indisponible ou stock insuffisant : {$produit->nom_produit}");
            }

            $montantHT = $produit->prix_unitaire * $quantite;
            $montantTTC = $montantHT * 1.18;
            $totalGeneral += $montantTTC;

            Vente::create([
                'produit_id'      => $produit->id,
                'user_id'         => Auth::id(),
                'quantite'        => $quantite,
                'prix_total'      => $montantTTC,
                'mode_paiement'   => $request->mode_paiement,
                'date_vente'      => now(),
            ]);

            $produit->decrement('quantite', $quantite);

            $ventesEffectuees[] = [
                'produit'       => $produit,
                'quantite'      => $quantite,
                'total'         => $montantTTC,
                'mode_paiement' => $request->mode_paiement,
            ];
        }

        $montantRecu = $request->mode_paiement === 'especes'
            ? ($request->montant_recu ?? $totalGeneral)
            : $totalGeneral;

        session()->forget('panier');
        session()->put('derniere_vente', $ventesEffectuees);
        session()->put('montant_recu', $montantRecu);

        return redirect()->route('vente.confirmation');
    }

    public function exportPdf(Request $request)
    {
        $query = Vente::with('produit')->where('user_id', auth()->id());

        if ($request->has('date')) {
            $query->whereDate('date_vente', $request->input('date'));
        }

        $ventes = $query->orderByDesc('date_vente')->get();
        $pdf = Pdf::loadView('vente.historique-pdf', compact('ventes'));

        return $pdf->download('historique_ventes.pdf');
    }

    public function ticketPdf()
    {
        $ventes = session('derniere_vente', []);
        $montantRecu = session('montant_recu', null);

        if (empty($ventes)) {
            return redirect()->route('vendeur.dashboard')->withErrors('Aucune vente récente à imprimer.');
        }

        $total = array_sum(array_column($ventes, 'total'));
        $vendeur = Auth::user();

        $pdf = Pdf::loadView('vente.ticket-pdf', [
            'ventes' => $ventes,
            'total' => $total,
            'vendeur' => $vendeur,
            'date' => now()->format('d/m/Y H:i'),
            'montant_recu' => $montantRecu
        ]);

        return $pdf->stream('ticket_vente.pdf');
    }

    public function historique(Request $request)
    {
        $date = $request->input('date');

        $query = Vente::with('produit')
            ->where('user_id', Auth::id());

        if ($date) {
            $query->whereDate('date_vente', $date);
        }

        $ventes = $query->orderBy('date_vente', 'desc')->get();

        $grouped = $ventes->groupBy(function ($item) {
            return Carbon::parse($item->date_vente)->format('d/m/Y');
        })->map(function ($dayGroup) {
            return $dayGroup->groupBy(function ($item) {
                return Carbon::parse($item->date_vente)->format('H:i');
            });
        });

        return view('vente.historique', compact('grouped', 'date'));
    }

    public function mettreAJour(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1'
        ]);

        $panier = session('panier', []);
        $produitId = $request->produit_id;
        $quantite = $request->quantite;

        $produit = Produit::find($produitId);
        if ($produit->quantite < $quantite) {
            return response()->json(['success' => false, 'message' => 'Stock insuffisant.'], 400);
        }

        $panier[$produitId] = $quantite;
        session(['panier' => $panier]);

        $totalHT = $produit->prix_unitaire * $quantite;
        $total = $totalHT * 1.18;
        $totalGeneral = 0;
        foreach ($panier as $id => $qte) {
            $p = Produit::find($id);
            $totalGeneral += $p->prix_unitaire * $qte * 1.18;
        }

        return response()->json([
            'success' => true,
            'quantite' => $quantite,
            'total' => $total,
            'totalGeneral' => $totalGeneral
        ]);
    }
}
