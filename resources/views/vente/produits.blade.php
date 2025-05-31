<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-box-seam me-2"></i> Nouvelle Vente
            </h2>
            <a href="{{ route('vendeur.dashboard') }}" class="btn btn-outline-dark">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un produit par nom ou code...">
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="productTable">
                <thead class="table-dark">
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th style="width: 180px;">Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $produit->code_produit }}</td>
                            <td>{{ $produit->nom_produit }}</td>
                            <td>{{ $produit->categorie }}</td>
                            <td>
                                <form action="{{ route('vente.panier.ajouter') }}" method="POST" class="d-flex align-items-center formulaire-vente" data-stock="{{ $produit->quantite }}">
                                    @csrf
                                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                    <input type="number"
                                           name="quantite"
                                           min="1"
                                           max="{{ $produit->quantite }}"
                                           class="form-control form-control-sm me-2 quantite-input"
                                           style="width: 70px;"
                                           placeholder="Qté"
                                           required>
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('vente.recapitulatif') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-right-circle me-1"></i> Passer au paiement
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#productTable tbody tr');

            searchInput.addEventListener('input', () => {
                const term = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    const code = row.children[0].textContent.toLowerCase();
                    const nom = row.children[1].textContent.toLowerCase();
                    row.style.display = (code.includes(term) || nom.includes(term)) ? '' : 'none';
                });
            });

            // Validation du stock avant soumission
            document.querySelectorAll('.formulaire-vente').forEach(form => {
                const stockDispo = parseInt(form.getAttribute('data-stock'), 10);
                const input = form.querySelector('.quantite-input');

                form.addEventListener('submit', e => {
                    const value = parseInt(input.value, 10);
                    if (value > stockDispo) {
                        e.preventDefault();
                        alert(`Quantité demandée (${value}) indisponible. Stock actuel : ${stockDispo}`);
                        input.focus();
                    }
                });
            });
        });
    </script>
</x-app-layout>
