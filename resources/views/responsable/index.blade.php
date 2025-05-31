<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-box-seam me-2"></i> Stock & Alertes
            </h2>
            <a href="{{ route('responsable.dashboard') }}" class="btn btn-outline-dark">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        <h4 class="mb-4 text-secondary fw-semibold border-bottom pb-2"><i class="bi bi-graph-up me-2"></i>Résumé des produits à surveiller</h4>

        <div class="row g-4 mb-4">
            <!-- Rupture -->
            <div class="col-md-6 animate__animated animate__zoomIn">
                <div class="card border-danger shadow h-100">
                    <div class="card-header bg-danger text-white fw-bold">
                        <i class="bi bi-x-circle-fill me-1"></i> Produits en rupture
                    </div>
                    <div class="card-body">
                        @if($rupture->isEmpty())
                            <p class="text-muted">Aucun produit en rupture.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($rupture as $produit)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $produit->nom_produit }} ({{ $produit->code_produit }})
                                        <span class="badge rounded-pill bg-danger">0</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Seuil critique -->
            <div class="col-md-6 animate__animated animate__zoomIn">
                <div class="card border-warning shadow h-100">
                    <div class="card-header bg-warning text-dark fw-bold">
                        <i class="bi bi-exclamation-circle me-1"></i> Produits sous le seuil
                    </div>
                    <div class="card-body">
                        @if($seuil->isEmpty())
                            <p class="text-muted">Aucun produit sous le seuil de sécurité.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($seuil as $produit)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $produit->nom_produit }} ({{ $produit->code_produit }})
                                        <span class="badge rounded-pill bg-warning text-dark">{{ $produit->quantite }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bientôt expirés -->
            <div class="col-md-6 animate__animated animate__zoomIn">
                <div class="card border-info shadow h-100">
                    <div class="card-header bg-info text-white fw-bold">
                        <i class="bi bi-clock me-1"></i> Bientôt expirés
                    </div>
                    <div class="card-body">
                        @if($bientotExpires->isEmpty())
                            <p class="text-muted">Aucun produit proche de la date d'expiration.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($bientotExpires as $produit)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $produit->nom_produit }} ({{ $produit->code_produit }})
                                        <span class="badge rounded-pill bg-info text-white">{{ $produit->date_expiration }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Expirés -->
            <div class="col-md-6 animate__animated animate__zoomIn">
                <div class="card border-dark shadow h-100">
                    <div class="card-header bg-dark text-white fw-bold">
                        <i class="bi bi-calendar-x me-1"></i> Produits expirés
                    </div>
                    <div class="card-body">
                        @if($expires->isEmpty())
                            <p class="text-muted">Aucun produit expiré.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($expires as $produit)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $produit->nom_produit }} ({{ $produit->code_produit }})
                                        <span class="badge rounded-pill bg-dark">{{ $produit->date_expiration }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de recherche -->
        <div class="card shadow-sm p-4 mb-4 animate__animated animate__fadeIn">
            <input type="text" id="searchProduit" class="form-control shadow-sm border-primary" placeholder="🔍 Rechercher un produit par nom ou code...">
        </div>

        <!-- Tableau des produits -->
<div class="table-responsive animate__animated animate__fadeIn">
    <table class="table table-hover align-middle bg-white shadow-sm" id="stockTable">
        <thead class="table-primary">
            <tr class="text-center">
                <th>Code</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix unitaire (F CFA)</th>
                <th>Prix acquisition (F CFA)</th> <!-- ✅ AJOUTÉ ICI -->
                <th>Quantité</th>
                <th>Date d'expiration</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $produit)
                <tr class="text-center">
                    <td>{{ $produit->code_produit }}</td>
                    <td class="nom-produit fw-semibold text-dark">{{ $produit->nom_produit }}</td>
                    <td>{{ $produit->categorie }}</td>
                    <td>{{ number_format($produit->prix_unitaire, 0, ',', ' ') }}</td>
                    <td>{{ number_format($produit->prix_acquisition, 0, ',', ' ') }}</td> <!-- ✅ AJOUTÉ ICI -->
                    <td>{{ $produit->quantite }}</td>
                    <td>{{ $produit->date_expiration ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchProduit');
            searchInput.addEventListener('input', function () {
                const term = this.value.toLowerCase();
                const rows = document.querySelectorAll('#stockTable tbody tr');

                rows.forEach(row => {
                    const nom = row.querySelector('.nom-produit')?.textContent.toLowerCase() || '';
                    const code = row.children[0].textContent.toLowerCase();
                    row.style.display = (nom.includes(term) || code.includes(term)) ? '' : 'none';
                });
            });
        });
    </script>
</x-app-layout>
