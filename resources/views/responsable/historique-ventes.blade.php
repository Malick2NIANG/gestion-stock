<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-clock-history me-2"></i> Historique détaillé des ventes
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('responsable.ventes') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Historique global
                </a>
                <a href="{{ route('responsable.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        <div class="card shadow p-4 mb-4 border-0">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="date" class="form-label fw-semibold">🗓️ Filtrer par date :</label>
                    <input type="date" id="date" name="date" class="form-control border-primary shadow-sm" value="{{ request('date') }}">
                </div>
                <div class="col-md-4">
                    <label for="searchProduit" class="form-label fw-semibold">🔍 Rechercher un produit :</label>
                    <input type="text" id="searchProduit" class="form-control shadow-sm" placeholder="Nom du produit...">
                </div>
                <div class="col-md-4">
                    <label for="searchVendeur" class="form-label fw-semibold">🔍 Rechercher un vendeur :</label>
                    <input type="text" id="searchVendeur" class="form-control shadow-sm" placeholder="Nom du vendeur...">
                </div>
            </div>
        </div>

        @forelse ($grouped as $jour => $heures)
            <div class="mb-5 animate__animated animate__fadeIn">
                <h4 class="fw-bold text-primary border-bottom pb-1"><i class="bi bi-calendar3 me-2"></i> {{ $jour }}</h4>

                @foreach ($heures as $heure => $ventes)
                    <div class="mb-4 ms-3">
                        <h6 class="fw-semibold text-dark"><i class="bi bi-clock me-1"></i> {{ $heure }}</h6>
                        <div class="table-responsive rounded shadow-sm">
                            <table class="table table-bordered table-hover align-middle bg-white animate__animated animate__fadeIn vente-table">
                                <thead class="table-primary">
                                    <tr class="text-center">
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th>Montant HT</th>
                                        <th>TVA (18%)</th>
                                        <th>Montant TTC</th>
                                        <th>Mode paiement</th>
                                        <th>Vendeur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sousTotal = 0; @endphp
                                    @foreach ($ventes as $vente)
                                        @php
                                            $ht = $vente->prix_total / 1.18;
                                            $tva = $vente->prix_total - $ht;
                                            $sousTotal += $vente->prix_total;
                                        @endphp
                                        <tr>
                                            <td class="produit-nom">{{ $vente->produit->nom_produit }}</td>
                                            <td class="text-center">{{ $vente->quantite }}</td>
                                            <td class="text-end">{{ number_format($ht, 0, ',', ' ') }} F</td>
                                            <td class="text-end">{{ number_format($tva, 0, ',', ' ') }} F</td>
                                            <td class="text-end">{{ number_format($vente->prix_total, 0, ',', ' ') }} F CFA</td>
                                            <td class="text-center">{{ ucfirst($vente->mode_paiement) }}</td>
                                            <td class="text-center vendeur-nom">{{ $vente->vendeur->prenom }} {{ $vente->vendeur->nom }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold table-secondary text-end">
                                        <td colspan="4" class="text-end">🧾 Sous-total TTC :</td>
                                        <td>{{ number_format($sousTotal, 0, ',', ' ') }} F CFA</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="text-center text-muted py-5 animate__animated animate__fadeIn">
                <i class="bi bi-info-circle fs-4"></i> Aucune vente enregistrée pour la date sélectionnée.
            </div>
        @endforelse
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('date');
            const searchProduit = document.getElementById('searchProduit');
            const searchVendeur = document.getElementById('searchVendeur');

            dateInput.addEventListener('change', () => {
                const selectedDate = dateInput.value;
                const params = new URLSearchParams(window.location.search);
                params.set('date', selectedDate);
                window.location.search = params.toString();
            });

            function filterTables() {
                const produitTerm = searchProduit.value.toLowerCase();
                const vendeurTerm = searchVendeur.value.toLowerCase();

                document.querySelectorAll('.vente-table').forEach(table => {
                    const rows = table.querySelectorAll('tbody tr');
                    let visibleRows = 0;

                    rows.forEach(row => {
                        const produit = row.querySelector('.produit-nom')?.textContent.toLowerCase();
                        const vendeur = row.querySelector('.vendeur-nom')?.textContent.toLowerCase();
                        const matchProduit = produit.includes(produitTerm);
                        const matchVendeur = vendeur.includes(vendeurTerm);
                        const show = matchProduit && matchVendeur;
                        row.style.display = show ? '' : 'none';
                        if (show) visibleRows++;
                    });

                    table.closest('.mb-4').style.display = visibleRows > 0 ? '' : 'none';
                });
            }

            searchProduit.addEventListener('input', filterTables);
            searchVendeur.addEventListener('input', filterTables);
        });
    </script>
</x-app-layout>
