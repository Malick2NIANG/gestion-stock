<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-cash-coin me-2"></i> Effectuer une vente
            </h2>
            <a href="{{ route('vente.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-arrow-left-circle"></i> Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="mb-4 text-dark">Produit sélectionné : <strong>{{ $produit->nom_produit }}</strong></h5>

                <form action="{{ route('vente.store') }}" method="POST" id="venteForm">
                    @csrf
                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                    <div class="mb-3">
                        <label for="quantite" class="form-label fw-semibold">Quantité à vendre</label>
                        <input type="number" min="1" max="{{ $produit->quantite }}"
                               class="form-control @error('quantite') is-invalid @enderror"
                               name="quantite" id="quantite" required>
                        @error('quantite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Prix unitaire</label>
                        <input type="text" class="form-control" value="{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} F CFA" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="mode_paiement" class="form-label fw-semibold">Mode de paiement</label>
                        <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                            <option value="espèces">Espèces</option>
                            <option value="mobile">Mobile Money</option>
                            <option value="carte">Carte bancaire</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Total à payer</label>
                        <input type="text" class="form-control fw-bold" id="total" disabled>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-check-circle me-1"></i> Valider la vente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script de calcul automatique -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantiteInput = document.getElementById('quantite');
            const totalInput = document.getElementById('total');
            const prixUnitaire = {{ $produit->prix_unitaire }};

            quantiteInput.addEventListener('input', () => {
                const qte = parseInt(quantiteInput.value) || 0;
                const total = qte * prixUnitaire;
                totalInput.value = total.toLocaleString('fr-FR') + ' F CFA';
            });
        });
    </script>
</x-app-layout>
