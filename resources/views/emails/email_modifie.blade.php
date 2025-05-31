<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification d’adresse email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            padding: 40px 20px;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }
        h2 {
            color: #1d4ed8;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #374151;
            line-height: 1.6;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }
        .status {
            padding: 12px;
            background-color: #e0f2fe;
            border-left: 4px solid #0284c7;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 500;
            color: #0369a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bonjour {{ $utilisateur->prenom }} {{ $utilisateur->nom }},</h2>

        @if($type === 'ancien')
            <div class="status">
                🔔 Votre adresse e-mail a été modifiée dans la plateforme de gestion de stock.
            </div>
            <p>Si vous n’êtes pas à l’origine de ce changement, veuillez <strong>contacter immédiatement l’administrateur</strong> pour vérifier la sécurité de votre compte.</p>
        @else
            <div class="status" style="background-color: #dcfce7; border-left-color: #22c55e; color: #15803d;">
                ✅ Une nouvelle adresse e-mail a été associée à votre compte.
            </div>
            <p>Cet e-mail est désormais utilisé pour vous connecter et recevoir les notifications liées à votre activité.</p>
        @endif

        <p class="footer">Merci pour votre confiance,<br><strong>L’équipe Gestion Stock</strong></p>
    </div>
</body>
</html>
