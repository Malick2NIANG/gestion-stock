<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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


require __DIR__.'/auth.php';
