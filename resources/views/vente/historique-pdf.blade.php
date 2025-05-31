<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des ventes</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .header h2 {
            color: #0d6efd;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .filter-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .day-group {
            margin-bottom: 25px;
        }
        .day-header {
            color: #0d6efd;
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #0d6efd;
            padding-bottom: 3px;
            margin-bottom: 15px;
        }
        .hour-group {
            margin-bottom: 20px;
            margin-left: 15px;
        }
        .hour-header {
            font-weight: 600;
            color: #212529;
            margin-bottom: 5px;
        }
        .vendeur-info {
            color: #6c757d;
            font-size: 11px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-weight: 600;
        }
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .text-end {
            text-align: right;
        }
        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 40px 0;
        }
        .logo {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo img {
            height: 50px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('images/Logo.png') }}" alt="Logo">
    </div>

    <div class="header">
        <h2>Historique des ventes</h2>
        @if(request('date'))
            <div class="filter-info">
                Filtre appliqué : {{ \Carbon\Carbon::parse(request('date'))->format('d/m/Y') }}
            </div>
        @endif
    </div>

    @if($ventes->isNotEmpty())
        @php
            $grouped = $ventes->groupBy([
                fn($item) => \Carbon\Carbon::parse($item->date_vente)->format('d/m/Y'),
                fn($item) => \Carbon\Carbon::parse($item->date_vente)->format('H\h'),
            ]);
        @endphp

        @foreach($grouped as $jour => $heures)
            <div class="day-group">
                <div class="day-header">{{ $jour }}</div>

                @foreach($heures as $heure => $ventesGroupees)
                    <div class="hour-group">
                        <div class="hour-header">{{ $heure }}</div>
                        <div class="vendeur-info">
                            Vendeur : <strong>{{ $ventesGroupees->first()->vendeur->prenom }} {{ $ventesGroupees->first()->vendeur->nom }}</strong>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Total HT</th>
                                    <th>TVA (18%)</th>
                                    <th>Total TTC</th>
                                    <th>Mode paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalHT = 0;
                                    $totalTVA = 0;
                                    $totalTTC = 0;
                                @endphp
                                @foreach($ventesGroupees as $vente)
                                    @php
                                        $tva = $vente->prix_total * 0.18;
                                        $ttc = $vente->prix_total + $tva;
                                        $totalHT += $vente->prix_total;
                                        $totalTVA += $tva;
                                        $totalTTC += $ttc;
                                    @endphp
                                    <tr>
                                        <td>{{ $vente->produit->nom_produit }}</td>
                                        <td>{{ $vente->quantite }}</td>
                                        <td>{{ number_format($vente->prix_total, 0, ',', ' ') }} F</td>
                                        <td>{{ number_format($tva, 0, ',', ' ') }} F</td>
                                        <td>{{ number_format($ttc, 0, ',', ' ') }} F</td>
                                        <td>{{ ucfirst($vente->mode_paiement) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="2" class="text-end">Totaux :</td>
                                    <td>{{ number_format($totalHT, 0, ',', ' ') }} F</td>
                                    <td>{{ number_format($totalTVA, 0, ',', ' ') }} F</td>
                                    <td>{{ number_format($totalTTC, 0, ',', ' ') }} F</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="no-data">
            <i class="bi bi-info-circle"></i> Aucune vente enregistrée pour la date sélectionnée.
        </div>
    @endif

    <div style="text-align: right; margin-top: 30px; font-size: 11px; color: #6c757d;">
        Généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
