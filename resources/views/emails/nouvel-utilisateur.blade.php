<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur Gestion Stock</title>
</head>
<body style="font-family: 'Segoe UI', sans-serif; background-color: #f4f4f4; margin: 0; padding: 30px;">
    <div style="max-width: 600px; background: #fff; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
        <h2 style="color: #1d4ed8; margin-top: 0;">Bienvenue {{ $utilisateur->prenom }} {{ $utilisateur->nom }} 👋</h2>
        <p style="font-size: 16px; color: #333;">Votre compte a été créé avec succès sur la plateforme <strong>Gestion Stock</strong>.</p>

        <h4 style="color: #111; margin-top: 30px;">🔐 Vos identifiants :</h4>
        <ul style="list-style-type: none; padding-left: 0; font-size: 15px;">
            <li><strong>📧 Email :</strong> {{ $utilisateur->email }}</li>
            <li><strong>🔑 Mot de passe temporaire :</strong> {{ $motDePasseTemp }}</li>
        </ul>

        <p style="font-size: 14px; color: #555;">⚠️ Pour votre sécurité, il vous sera demandé de <strong>changer votre mot de passe</strong> dès votre première connexion.</p>

        <p style="font-size: 14px; color: #555; margin-top: 30px;">
            À bientôt !<br>
            <strong>L’équipe Gestion Stock</strong>
        </p>
    </div>
</body>
</html>
