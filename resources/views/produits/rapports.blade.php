<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-success fs-4">
                <i class="bi bi-graph-up-arrow me-2"></i> Rapports Produits
            </h2>
            <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-dark">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        <!-- Statistiques générales -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-primary border-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Total Produits</h6>
                        <p class="fs-3 fw-bold text-primary">{{ $totalProduits }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-success border-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Valeur Stock (vente)</h6>
                        <p class="fs-4 fw-bold text-success">{{ number_format($valeurTotaleStock, 0, ',', ' ') }} F CFA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-info border-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Coût Acquisition</h6>
                        <p class="fs-4 fw-bold text-info">{{ number_format($coutTotalAcquisition, 0, ',', ' ') }} F CFA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-warning border-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Sous Seuil</h6>
                        <p class="fs-3 fw-bold text-warning">{{ $produitsSousSeuil }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <div class="card shadow-sm border-start border-danger border-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Ruptures</h6>
                        <p class="fs-3 fw-bold text-danger">{{ $produitsRupture }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produits expirés et bientôt expirés -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">Produits bientôt expirés</div>
                    <div class="card-body">
                        @if($bientotExpires->isEmpty())
                            <p class="text-muted">Aucun produit proche de la date d'expiration.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($bientotExpires as $produit)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $produit->nom_produit }} ({{ $produit->code_produit }})
                                        <span class="badge bg-info">{{ $produit->date_expiration }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Produits expirés</div>
                    <div class="card-body">
                        @if($expires->isEmpty())
                            <p class="text-muted">Aucun produit expiré.</p>
                        @else
                            <ul class="list-group">
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

        <!-- Actions -->
        <div class="text-end mt-5">
            <a href="{{ route('produits.rapports.pdf') }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
            </a>
        </div>
    </div>
</x-app-layout>
