<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Mail\NotificationNouvelUtilisateur;
use App\Mail\EmailModifieNotification;


class UtilisateurController extends Controller
{
    /**
     * Affiche la liste des utilisateurs gestionnaires et vendeurs.
     */
    public function index()
    {
        $utilisateurs = User::whereIn('role', ['gestionnaire', 'vendeur'])->get();
        return view('responsable.liste-utilisateurs', compact('utilisateurs'));
    }

    /**
     * Enregistre un nouvel utilisateur avec mot de passe temporaire et envoie d'email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom'    => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users',
            'role'   => 'required|in:vendeur,gestionnaire',
        ]);

        // 🛡️ Générer un mot de passe aléatoire sécurisé
        $motDePasseTemp = Str::random(10);

        // Créer l'utilisateur avec mot de passe hashé
        $utilisateur = User::create([
            'prenom'   => $request->prenom,
            'nom'      => $request->nom,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($motDePasseTemp),
        ]);

        // 📨 Envoyer l'email avec identifiants
        Mail::to($utilisateur->email)->send(new NotificationNouvelUtilisateur($utilisateur, $motDePasseTemp));

        return redirect()->route('responsable.utilisateurs')->with('success', 'Utilisateur créé avec succès. Un email contenant les identifiants a été envoyé.');
    }

    /**
     * Met à jour les informations d’un utilisateur.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom'    => 'required|string|max:255',
            'email'  => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id), // empêche les doublons sauf pour l’utilisateur actuel
            ],
            'role'   => 'required|in:vendeur,gestionnaire',
        ]);


            if ($user->email !== $request->email) {
                // Ancienne adresse (alerte de changement)
                Mail::to($user->email)->send(new EmailModifieNotification($user));

                // Nouvelle adresse (confirmation du changement)
                Mail::to($request->email)->send(new EmailModifieNotification($user));
            }

        $user->prenom = $request->prenom;
        $user->nom    = $request->nom;
        $user->email  = $request->email;
        $user->role   = $request->role;

        $user->save();

        return redirect()->route('responsable.utilisateurs')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Affiche le formulaire d’édition.
     */
    public function edit($id)
    {
        $utilisateur = User::findOrFail($id);
        return view('responsable.edit', compact('utilisateur'));
    }
    /**
 * Réinitialise le mot de passe d’un utilisateur et envoie un nouvel e-mail.
 */
    public function resetPassword($id)
    {
        $utilisateur = User::findOrFail($id);

        // Générer un nouveau mot de passe temporaire
        $motDePasseTemp = Str::random(10);

        // Mettre à jour le mot de passe dans la base
        $utilisateur->password = Hash::make($motDePasseTemp);
        $utilisateur->doit_changer_password = true; // pour forcer le changement à la connexion
        $utilisateur->save();

        // Envoyer un e-mail avec le nouveau mot de passe
        Mail::to($utilisateur->email)->send(new NotificationNouvelUtilisateur($utilisateur, $motDePasseTemp));

        return redirect()->route('responsable.utilisateurs')->with('success', "Un nouveau mot de passe a été envoyé à {$utilisateur->email}.");
    }

}
