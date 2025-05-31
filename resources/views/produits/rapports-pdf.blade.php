<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Stock</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #333;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        .header img {
            height: 50px;
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #2c3e50;
        }

        .header small {
            color: #666;
            font-size: 12px;
        }

        .section {
            margin-top: 35px;
        }

        .section h3 {
            background-color: #f1f1f1;
            padding: 8px 12px;
            border-left: 6px solid #2c3e50;
            margin-bottom: 12px;
            color: #000;
        }

        ul.list-group {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .list-group li {
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        table, th, td {
            border: 1px solid #aaa;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        th, td {
            padding: 7px;
            text-align: left;
        }

        .text-muted {
            color: #999;
        }
    </style>
</head>
<body>

<!-- EN-TÊTE CENTRÉE -->
<div class="header">
    <img src="{{ public_path('images/Logo.png') }}" alt="Logo">
    <h2>Gestion Stock</h2>
    <small>Rapport fait le {{ now()->format('d/m/Y H:i') }}</small>
</div>

<!-- STATISTIQUES -->
<div class="section">
    <h3>Statistiques Générales</h3>
    <ul class="list-group">
        <li><strong>Total Produits :</strong> {{ $totalProduits }}</li>
        <li><strong>Valeur Totale du Stock (Prix de vente) :</strong> {{ number_format($valeurTotaleStock, 0, ',', ' ') }} F CFA</li>
        <li><strong>Coût Total d'Acquisition :</strong> {{ number_format($coutTotalAcquisition, 0, ',', ' ') }} F CFA</li>
        <li><strong>Produits en Rupture :</strong> {{ $produitsRupture }}</li>
        <li><strong>Produits Sous Seuil :</strong> {{ $produitsSousSeuil }}</li>
    </ul>
</div>

<!-- EN RUPTURE -->
<div class="section">
    <h3>Produits en Rupture</h3>
    @if($rupture->isEmpty())
        <p class="text-muted">Aucun produit en rupture.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rupture as $produit)
                    <tr>
                        <td>{{ $produit->nom_produit }}</td>
                        <td>{{ $produit->code_produit }}</td>
                        <td>{{ $produit->quantite }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- SOUS LE SEUIL -->
<div class="section">
    <h3>Produits Sous le Seuil</h3>
    @if($seuil->isEmpty())
        <p class="text-muted">Aucun produit sous le seuil.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seuil as $produit)
                    <tr>
                        <td>{{ $produit->nom_produit }}</td>
                        <td>{{ $produit->code_produit }}</td>
                        <td>{{ $produit->quantite }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- BIENTÔT EXPIRÉS -->
<div class="section">
    <h3>Produits Bientôt Expirés</h3>
    @if($bientotExpires->isEmpty())
        <p class="text-muted">Aucun produit proche de la date d'expiration.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Date d'expiration</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bientotExpires as $produit)
                    <tr>
                        <td>{{ $produit->nom_produit }}</td>
                        <td>{{ $produit->code_produit }}</td>
                        <td>{{ $produit->date_expiration }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- EXPIRÉS -->
<div class="section">
    <h3>Produits Expirés</h3>
    @if($expires->isEmpty())
        <p class="text-muted">Aucun produit expiré.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Date d'expiration</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expires as $produit)
                    <tr>
                        <td>{{ $produit->nom_produit }}</td>
                        <td>{{ $produit->code_produit }}</td>
                        <td>{{ $produit->date_expiration }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
