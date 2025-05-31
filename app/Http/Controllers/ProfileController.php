<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class ProfileController extends Controller
{
    /**
     * Affiche le formulaire de changement de mot de passe.
     */
    public function editMotDePasse()
    {
        return view('profile.password');
    }

    /**
     * Met à jour le mot de passe de l'utilisateur connecté.
     */
    public function updateMotDePasse(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        // ✅ Met à jour le mot de passe et désactive le forçage de changement
        $user->password = Hash::make($request->new_password);
        $user->doit_changer_password = false;
        $user->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }

}
