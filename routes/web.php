<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProduitController;

/*
|--------------------------------------------------------------------------
| Connexion (login)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('redirect'); // Redirection selon rôle
    }

    return back()->withErrors([
        'email' => 'Identifiants incorrects.',
    ]);
});

/*
|--------------------------------------------------------------------------
| Déconnexion (logout)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function (Request $request) {
    Auth::logout();
    Session::forget('alertes_vues'); // ← pour réinitialiser les alertes à la prochaine connexion
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| Redirection automatique après connexion
|--------------------------------------------------------------------------
*/
Route::get('/redirect', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'vendeur' => redirect()->route('vendeur.dashboard'),
        'gestionnaire' => redirect()->route('gestionnaire.dashboard'),
        'responsable' => redirect()->route('responsable.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('redirect');

/*
|--------------------------------------------------------------------------
| Dashboards par rôle
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/vendeur', function () {
        return view('dashboard.vendeur');
    })->name('vendeur.dashboard');

    Route::get('/gestionnaire', function () {
        return view('dashboard.gestionnaire');
    })->name('gestionnaire.dashboard');

    Route::get('/responsable', function () {
        return view('dashboard.responsable');
    })->name('responsable.dashboard');
});

/*
|--------------------------------------------------------------------------
| Gestion des Produits (par le gestionnaire)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.gestionnaire'])->group(function () {
    Route::resource('produits', ProduitController::class)->except(['show']);
    Route::get('/produits/alertes', [ProduitController::class, 'alertes'])->name('produits.alertes');
    Route::get('/produits/rapports', [ProduitController::class, 'rapports'])->name('produits.rapports');

});

/*
|--------------------------------------------------------------------------
| Route de test (à supprimer plus tard)
|--------------------------------------------------------------------------
*/
Route::get('/test', function () {
    return view('test');
});
