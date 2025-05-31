<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Vente</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0 auto;
            padding: 10px;
            width: 80mm;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .ticket-container {
            width: 100%;
            max-width: 80mm;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            width: 100%;
        }
        .logo {
            height: 50px;
            margin-bottom: 5px;
        }
        .title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .info {
            margin-bottom: 5px;
            width: 100%;
        }
        .details {
            margin: 15px 0;
            width: 100%;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .total {
            font-weight: bold;
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            width: 100%;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .payment {
            margin: 15px 0;
            width: 100%;
        }
        .payment-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-style: italic;
            width: 100%;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <img src="{{ public_path('images/Logo.png') }}" class="logo" alt="Logo">
            <div class="title">Gestion Stock</div>
            <div>Ticket généré le {{ now()->format('d/m/Y H:i') }}</div>
        </div>

        <div class="info">
            <strong>Vendeur :</strong> {{ $vendeur->prenom }} {{ $vendeur->nom }}
        </div>

        <div class="info">
            <strong>Mode de paiement :</strong> {{ ucfirst($ventes[0]['mode_paiement'] ?? 'especes') }}
        </div>

        <div class="details">
            <strong>Détail des produits :</strong>
            @php
                $totalHT = 0;
                $totalTTC = 0;
            @endphp
            @foreach ($ventes as $vente)
                @php
                    $ht = $vente['total'] / 1.18;
                    $tva = $vente['total'] - $ht;
                    $totalHT += $ht;
                    $totalTTC += $vente['total'];
                @endphp
                <div class="detail-item">
                    <span>{{ $vente['produit']->nom_produit }} x{{ $vente['quantite'] }}</span>
                    <span>{{ number_format($vente['total'], 0, ',', ' ') }} F</span>
                </div>
            @endforeach
        </div>

        <div class="divider"></div>

        <div class="total">
            <div class="total-row">
                <span>Total HT :</span>
                <span>{{ number_format($totalHT, 0, ',', ' ') }} F</span>
            </div>
            <div class="total-row">
                <span>TVA (18%) :</span>
                <span>{{ number_format($totalTTC - $totalHT, 0, ',', ' ') }} F</span>
            </div>
            <div class="total-row">
                <span>Total TTC :</span>
                <span>{{ number_format($totalTTC, 0, ',', ' ') }} F</span>
            </div>
        </div>

        <div class="payment">
            <strong>Paiement :</strong>
            <div class="payment-item">
                <span>Montant reçu :</span>
                <span>{{ number_format($montant_recu ?? $totalTTC, 0, ',', ' ') }} F</span>
            </div>
            @if(($montant_recu ?? $totalTTC) > $totalTTC)
            <div class="payment-item">
                <span>Montant rendu :</span>
                <span>{{ number_format(($montant_recu ?? $totalTTC) - $totalTTC, 0, ',', ' ') }} F</span>
            </div>
            @endif
        </div>

        <div class="footer">
            Merci pour votre achat
        </div>
    </div>
</body>
</html>
