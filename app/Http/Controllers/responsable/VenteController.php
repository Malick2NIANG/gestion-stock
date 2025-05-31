<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vente;
use Carbon\Carbon;

class VenteController extends Controller
{
    /**
     * Affiche l'historique global des ventes regroupées par date et heure.
     */
    public function index(Request $request)
    {
        $date = $request->input('date');

        $query = Vente::with(['produit', 'vendeur'])
            ->when($date, function ($q) use ($date) {
                return $q->whereDate('date_vente', $date);
            })
            ->orderBy('date_vente', 'desc');

        $ventes = $query->get();

        $grouped = $ventes->groupBy(function ($vente) {
            return Carbon::parse($vente->date_vente)->format('d/m/Y');
        })->map(function ($dayGroup) {
            return $dayGroup->groupBy(function ($vente) {
                return Carbon::parse($vente->date_vente)->format('H:i');
            });
        });

        return view('responsable.historique-global', compact('grouped', 'date'));
    }
}
