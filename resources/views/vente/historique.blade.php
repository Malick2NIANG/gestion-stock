<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-clock-history me-2"></i> Historique des ventes
            </h2>
            <a href="{{ route('vendeur.dashboard') }}" class="btn btn-outline-dark">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </x-slot>

    <div class="card shadow-sm p-4 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="date" class="form-label fw-semibold">Filtrer par date :</label>
                <input type="date" id="date" name="date" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="searchProduit" class="form-label fw-semibold">Filtrer par produit :</label>
                <input type="text" id="searchProduit" class="form-control" placeholder="Rechercher un produit...">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Actions :</label>
                <div class="d-flex gap-2">
                    <a href="{{ route('vente.export', ['date' => request('date')]) }}" class="btn btn-outline-secondary w-50">
                        <i class="bi bi-download"></i> Exporter PDF
                    </a>
                    <a href="{{ route('vente.historique') }}" class="btn btn-outline-dark w-50">
                        <i class="bi bi-arrow-counterclockwise"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2 animate__animated animate__fadeInUp">
        @forelse ($grouped as $jour => $heures)
            <div class="mb-5">
                <h5 class="fw-bold text-primary border-bottom pb-1">{{ $jour }}</h5>

                @foreach ($heures as $heure => $ventes)
                    <div class="mb-4 ms-3">
                        <h6 class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($ventes->first()->created_at)->format('H:i') }}</h6>
                        <p class="text-muted small mb-1">Vendeur : <strong>{{ $ventes->first()->vendeur->prenom }} {{ $ventes->first()->vendeur->nom }}</strong></p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle shadow-sm vente-table">
                                <thead class="table-light">
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
                                    @foreach ($ventes as $vente)
                                        @php
                                            $tva = $vente->prix_total * 0.18;
                                            $ttc = $vente->prix_total + $tva;
                                            $totalHT += $vente->prix_total;
                                            $totalTVA += $tva;
                                            $totalTTC += $ttc;
                                        @endphp
                                        <tr>
                                            <td class="produit-nom">{{ $vente->produit->nom_produit }}</td>
                                            <td>{{ $vente->quantite }}</td>
                                            <td>{{ number_format($vente->prix_total, 0, ',', ' ') }} F CFA</td>
                                            <td>{{ number_format($tva, 0, ',', ' ') }} F CFA</td>
                                            <td>{{ number_format($ttc, 0, ',', ' ') }} F CFA</td>
                                            <td>{{ ucfirst($vente->mode_paiement) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold bg-light">
                                        <td colspan="2" class="text-end">Totaux :</td>
                                        <td>{{ number_format($totalHT, 0, ',', ' ') }} F CFA</td>
                                        <td>{{ number_format($totalTVA, 0, ',', ' ') }} F CFA</td>
                                        <td>{{ number_format($totalTTC, 0, ',', ' ') }} F CFA</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-info-circle"></i> Aucune vente enregistrée pour la date sélectionnée.
            </div>
        @endforelse
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('date');
            const searchInput = document.getElementById('searchProduit');

            dateInput.addEventListener('change', () => {
                const selectedDate = dateInput.value;
                if (selectedDate) {
                    const params = new URLSearchParams(window.location.search);
                    params.set('date', selectedDate);
                    window.location.search = params.toString();
                }
            });

            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();
                const tables = document.querySelectorAll('.vente-table');

                tables.forEach(table => {
                    const rows = table.querySelectorAll('tbody tr');
                    let tableVisible = false;

                    rows.forEach(row => {
                        const produitCell = row.querySelector('.produit-nom');
                        if (!produitCell) return;
                        const produitNom = produitCell.textContent.toLowerCase();
                        const match = produitNom.includes(searchTerm);
                        row.style.display = match ? '' : 'none';
                        if (match) tableVisible = true;
                    });

                    table.closest('.mb-4').style.display = tableVisible ? '' : 'none';
                });
            });
        });
    </script>
</x-app-layout>
