<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des modifications de stock</title>
    <style>
        @page {
            margin: 40px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info-top {
            text-align: left;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #888;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>
<body>

<header>
    <h2>📋 Historique des modifications de stock</h2>
</header>

<div class="info-top">
    <strong>Date :</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}<br>
    @if(isset($gestionnaire))
        <strong>Généré par :</strong> {{ $gestionnaire->prenom }} {{ $gestionnaire->nom }}
    @endif
</div>

<table>
    <thead>
    <tr>
        <th>Produit</th>
        <th>Action</th>
        <th>Ancienne Qte</th>
        <th>Nouvelle Qte</th>
        <th>Quantité Totale</th>
        <th>Par</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @forelse($modifications as $modif)
        <tr>
            <td>{{ $modif->nom_produit ?? '-' }}</td>
            <td>
                @if($modif->action === 'ajout')
                    Ajout
                @elseif($modif->action === 'modification')
                    Modification
                @elseif($modif->action === 'suppression')
                    Suppression
                @elseif($modif->action === 'réapprovisionnement')
                    Réapprovisionnement
                @else
                    -
                @endif
            </td>
            <td>{{ $modif->ancienne_quantite ?? '-' }}</td>
            <td>
                @if($modif->action === 'réapprovisionnement')
                    {{ $modif->nouvelle_quantite }} <!-- Qte ajoutée -->
                @else
                    {{ $modif->nouvelle_quantite }}
                @endif
            </td>
            <td>{{ $modif->quantite_totale }}</td>
            <td>{{ $modif->gestionnaire->prenom ?? '-' }} {{ $modif->gestionnaire->nom ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($modif->date_modification)->format('d/m/Y H:i') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7">Aucune modification enregistrée.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<footer>
    Page <span class="pagenum"></span>
</footer>

</body>
</html>
