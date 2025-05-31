<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-truck me-2"></i> Réapprovisionner des produits
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <!-- Barre de recherche dynamique -->
        <div class="mb-4 animate__animated animate__fadeIn">
            <input type="text" id="searchProduit" class="form-control" placeholder="🔍 Rechercher un produit par nom ou code...">
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="produitTable">
                <thead class="table-dark">
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix vente (F CFA)</th>
                        <th>Prix acquisition (F CFA)</th>
                        <th>Quantité</th>
                        <th>Expiration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                        <tr class="produit-row">
                            <td>{{ $produit->code_produit }}</td>
                            <td class="produit-nom">{{ $produit->nom_produit }}</td>
                            <td>{{ $produit->categorie }}</td>
                            <td>{{ number_format($produit->prix_unitaire, 2) }}</td>
                            <td>{{ number_format($produit->prix_acquisition, 2) }}</td>
                            <td>{{ $produit->quantite }}</td>
                            <td>{{ $produit->date_expiration ?? 'N/A' }}</td>
                            <td>
                                <!-- ✅ BONNE ROUTE : reapprovisionnement.formulaire -->
                                <a href="{{ route('reapprovisionnement.create', $produit) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-truck"></i> Réapprovisionner
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script JS de recherche dynamique -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchProduit');
            const rows = document.querySelectorAll('.produit-row');

            searchInput.addEventListener('input', () => {
                const term = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const code = row.children[0].textContent.toLowerCase();
                    const nom = row.querySelector('.produit-nom').textContent.toLowerCase();
                    const match = code.includes(term) || nom.includes(term);
                    row.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
</x-app-layout>
