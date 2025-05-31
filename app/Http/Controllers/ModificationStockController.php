<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModificationStock;
use Barryvdh\DomPDF\Facade\Pdf;


class ModificationStockController extends Controller
{
    /**
     * Affiche l’historique des modifications de stock.
     */
    public function index()
    {
        $modifications = ModificationStock::with('produit', 'gestionnaire')
                            ->latest('date_modification')
                            ->get();

        return view('produits.modifications-stock', compact('modifications'));
    }


    public function export()
    {
        $modifications = ModificationStock::orderByDesc('date_modification')->get();
        $gestionnaire = auth()->user(); // Utilisateur actuellement connecté

        $pdf = Pdf::loadView('produits.modifications-stock-pdf', [
            'modifications' => $modifications,
            'gestionnaire' => $gestionnaire
        ]);

        return $pdf->download('historique_modifications_stock.pdf');
    }



}
