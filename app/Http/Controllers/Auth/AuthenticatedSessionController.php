<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
  public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // 🔐 Redirection obligatoire si mot de passe temporaire
    if (auth()->user()->doit_changer_password) {
        return redirect()->route('profile.password.edit')->with('warning', 'Veuillez modifier votre mot de passe avant de continuer.');
    }

    // 🎯 Redirection selon le rôle
    switch (auth()->user()->role) {
        case 'vendeur':
            return redirect()->route('vendeur.dashboard');
        case 'gestionnaire':
            return redirect()->route('gestionnaire.dashboard');
        case 'responsable':
            return redirect()->route('responsable.dashboard');
        default:
            abort(403);
    }
}



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
