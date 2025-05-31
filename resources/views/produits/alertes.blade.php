<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-danger fs-4">
                <i class="bi bi-exclamation-triangle me-2"></i> Alertes Produits
            </h2>
            <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-dark">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        <h4 class="mb-4 text-secondary">Résumé des produits à surveiller</h4>

        <div class="row g-4">
            <!-- Produits en rupture -->
            <div class="col-md-6">
                <div class="card border-danger shadow">
                    <div class="card-header bg-danger text-white fw-semibold">
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
                                        <span class="badge bg-danger">0</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Produits sous le seuil -->
            <div class="col-md-6">
                <div class="card border-warning shadow">
                    <div class="card-header bg-warning text-dark fw-semibold">
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
                                        <span class="badge bg-warning text-dark">{{ $produit->quantite }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Produits bientôt expirés -->
            <div class="col-md-6">
                <div class="card border-info shadow">
                    <div class="card-header bg-info text-white fw-semibold">
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
                                        <span class="badge bg-info text-white">{{ $produit->date_expiration }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Produits expirés -->
            <div class="col-md-6">
                <div class="card border-dark shadow">
                    <div class="card-header bg-dark text-white fw-semibold">
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
                                        <span class="badge bg-dark">{{ $produit->date_expiration }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
