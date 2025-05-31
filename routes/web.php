<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\Responsable\VenteController as ResponsableVenteController;
use App\Http\Controllers\Responsable\StockController as ResponsableStockController;
use App\Http\Controllers\Responsable\UtilisateurController;
use App\Http\Controllers\Responsable\ResponsableProduitController;
use App\Http\Controllers\Responsable\DashboardResponsableController;
use App\Http\Controllers\ReapprovisionnementController;
use App\Http\Controllers\ModificationStockController;
use App\Http\Controllers\ProfileController;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationNouvelUtilisateur;

// 🔐 Redirection vers login
Route::get('/', fn() => redirect()->route('login'));

// 🟦 Page login
Route::get('/login', fn() => view('auth.login'))->name('login');

// ✅ Traitement login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('redirect');
    }

    return back()->withErrors(['email' => 'Identifiants incorrects.']);
});

// 🔓 Déconnexion
Route::post('/logout', function (Request $request) {
    Auth::logout();
    Session::forget('alertes_vues');
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// 🎯 Redirection selon le rôle
Route::get('/redirect', function () {
    return match (auth()->user()->role) {
        'vendeur' => redirect()->route('vendeur.dashboard'),
        'gestionnaire' => redirect()->route('gestionnaire.dashboard'),
        'responsable' => redirect()->route('responsable.dashboard'),
        default => abort(403),
    };
})->middleware(['auth'])->name('redirect');

// 📊 Dashboards + profil
Route::middleware(['auth'])->group(function () {
    Route::get('/vendeur', fn() => view('dashboard.vendeur'))->name('vendeur.dashboard');
    Route::get('/gestionnaire', fn() => view('dashboard.gestionnaire'))->name('gestionnaire.dashboard');
    Route::get('/responsable', fn() => view('dashboard.responsable'))->name('responsable.dashboard');

    // ✅ Modification de son propre mot de passe
    Route::get('/profil/mot-de-passe', [ProfileController::class, 'editMotDePasse'])->name('profile.password.edit');
    Route::post('/profil/mot-de-passe', [ProfileController::class, 'updateMotDePasse'])->name('profile.password.update');
});

// 📦 Produits & Réapprovisionnement
Route::middleware(['auth'])->group(function () {

    // Produits
    Route::resource('produits', ProduitController::class)->except(['show']);
    Route::get('/produits/alertes', [ProduitController::class, 'alertes'])->name('produits.alertes');
    Route::get('/produits/rapports', [ProduitController::class, 'rapports'])->name('produits.rapports');
    Route::get('/produits/rapports/pdf', [ProduitController::class, 'exportPdf'])->name('produits.rapports.pdf');

    // Réapprovisionnement → logique par produit
    Route::get('/reapprovisionnement/liste-produits', [ReapprovisionnementController::class, 'listeProduits'])->name('reapprovisionnement.liste_produits');
    Route::get('/reapprovisionnement/{produit}/formulaire', [ReapprovisionnementController::class, 'formulaire'])->name('reapprovisionnement.create');
    Route::post('/reapprovisionnement/{produit}/store', [ReapprovisionnementController::class, 'store'])->name('reapprovisionnement.store');

    // Historique des réapprovisionnements (optionnel, si tu le gardes)
    Route::get('/reapprovisionnement', [ReapprovisionnementController::class, 'index'])->name('reapprovisionnement.index');

    // Modifications stock
    Route::get('/modifications-stock', [ModificationStockController::class, 'index'])->name('modifications-stock.index');
    Route::get('/modifications-stock/pdf', [ModificationStockController::class, 'export'])->name('modifications-stock.export');
});

// 🛒 Ventes (vendeur)
Route::middleware(['auth'])->group(function () {
    Route::get('/vente', [VenteController::class, 'create'])->name('vente.create');
    Route::get('/vente/{produit}/formulaire', [VenteController::class, 'formulaire'])->name('vente.formulaire');
    Route::post('/vente/enregistrer', [VenteController::class, 'store'])->name('vente.store');

    Route::get('/vente/historique', [VenteController::class, 'historique'])->name('vente.historique');
    Route::get('/vente/historique/export', [VenteController::class, 'exportPdf'])->name('vente.export');

    Route::post('/vente/panier/ajouter', [PanierController::class, 'ajouter'])->name('vente.panier.ajouter');
    Route::delete('/vente/panier/{id}/supprimer', [PanierController::class, 'supprimer'])->name('vente.panier.supprimer');
    Route::delete('/vente/panier/vider', [PanierController::class, 'vider'])->name('vente.panier.vider');

    Route::get('/vente/recapitulatif', [VenteController::class, 'recapitulatif'])->name('vente.recapitulatif');
    Route::post('/vente/valider', [VenteController::class, 'valider'])->name('vente.valider');

    Route::get('/vente/confirmation', fn() => view('vente.confirmation-impression'))->name('vente.confirmation');
    Route::get('/vente/ticket/pdf', [VenteController::class, 'ticketPdf'])->name('vente.ticket.pdf');

    Route::post('/vente/panier/mettreAJour', [VenteController::class, 'mettreAJour'])->name('vente.panier.mettreAJour');
    Route::get('/vendeur/produits', [VenteController::class, 'create'])->name('vendeur.produits');
});

// 👨‍💼 Espace responsable
Route::middleware(['auth'])->prefix('responsable')->name('responsable.')->group(function () {
    Route::get('/ventes', [ResponsableVenteController::class, 'index'])->name('ventes');
    Route::get('/stock', [ResponsableStockController::class, 'index'])->name('stock');

    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs');
    Route::get('/utilisateurs/{user}/edit', [UtilisateurController::class, 'edit'])->name('utilisateurs.edit');
    Route::put('/utilisateurs/{user}', [UtilisateurController::class, 'update'])->name('utilisateurs.update');
    Route::delete('/utilisateurs/{user}', [UtilisateurController::class, 'destroy'])->name('utilisateurs.destroy');
    Route::post('/utilisateurs/{user}/reset-password', [UtilisateurController::class, 'resetPassword'])->name('utilisateurs.resetPassword');

    Route::post('/utilisateurs/enregistrer', [UtilisateurController::class, 'store'])->name('utilisateurs.store');
    Route::get('/utilisateurs/creer', fn() => view('auth.register'))->name('utilisateurs.create');

    Route::get('/rapport', [ResponsableProduitController::class, 'rapports'])->name('rapport');
    Route::get('/rapport/pdf', [ResponsableProduitController::class, 'exportPdf'])->name('rapport.pdf');

    Route::get('/dashboard/rapport', [DashboardResponsableController::class, 'index'])->name('dashboard.rapport');
    Route::get('/historique-ventes', [DashboardResponsableController::class, 'historiqueVentes'])->name('historique.ventes');
    Route::get('/historique-modifications', [DashboardResponsableController::class, 'historiqueModifications'])->name('historique.modifications');
});

// Test envoi mail
Route::get('/test-mail', function () {
    $utilisateur = User::where('email', 'malick.niang2@gmail.com')->first();
    $motDePasseTemp = 'motdepasse123';
    Mail::to($utilisateur->email)->send(new NotificationNouvelUtilisateur($utilisateur, $motDePasseTemp));
    return '✅ Test d’envoi terminé';
});

// Test
Route::get('/test', fn() => view('test'));
