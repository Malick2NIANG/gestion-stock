<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-pencil-square me-2"></i> Historique des modifications de stock
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
                    <label for="date" class="form-label fw-semibold">📅 Filtrer par date :</label>
                    <input type="date" id="date" name="date" class="form-control border-primary shadow-sm" value="{{ request('date') }}">
                </div>
                <div class="col-md-4">
                    <label for="searchProduit" class="form-label fw-semibold">🔍 Rechercher un produit :</label>
                    <input type="text" id="searchProduit" class="form-control shadow-sm" placeholder="Nom du produit...">
                </div>
                <div class="col-md-4 text-end">
                    <label class="form-label fw-semibold">&nbsp;</label>
                    <a href="{{ route('modifications-stock.export') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-download"></i> Exporter PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="table-responsive animate__animated animate__fadeIn">
            <table class="table table-bordered table-striped align-middle shadow-sm" id="modificationsTable">
                <thead class="table-primary">
                    <tr class="text-center">
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
                            <td class="produit-nom">{{ $modif->nom_produit ?? '-' }}</td>
                            <td class="text-center">
                                @if($modif->action === 'ajout')
                                    <span class="badge bg-success">Ajout</span>
                                @elseif($modif->action === 'modification')
                                    <span class="badge bg-warning text-dark">Modification</span>
                                @elseif($modif->action === 'suppression')
                                    <span class="badge bg-danger">Suppression</span>
                                @elseif($modif->action === 'réapprovisionnement')
                                    <span class="badge bg-info text-dark">Réapprovisionnement</span>
                                @else
                                    <span class="badge bg-secondary">Inconnue</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $modif->ancienne_quantite ?? '-' }}</td>
                            <td class="text-end">{{ $modif->nouvelle_quantite }}</td>
                            <td class="text-end">{{ $modif->quantite_totale }}</td>
                            <td class="text-center">{{ $modif->gestionnaire->prenom ?? '-' }} {{ $modif->gestionnaire->nom ?? '' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($modif->date_modification)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucune modification enregistrée pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchProduit = document.getElementById('searchProduit');
            const dateInput = document.getElementById('date');

            searchProduit.addEventListener('input', () => {
                const term = searchProduit.value.toLowerCase();
                document.querySelectorAll('#modificationsTable tbody tr').forEach(row => {
                    const produit = row.querySelector('.produit-nom')?.textContent.toLowerCase();
                    row.style.display = produit.includes(term) ? '' : 'none';
                });
            });

            dateInput.addEventListener('change', () => {
                const selectedDate = dateInput.value;
                const params = new URLSearchParams(window.location.search);
                params.set('date', selectedDate);
                window.location.search = params.toString();
            });
        });
    </script>
</x-app-layout>
