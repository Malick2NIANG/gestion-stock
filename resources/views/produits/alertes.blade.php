<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Alertes Produits') }}
            </h2>
            <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-secondary btn-sm">← Retour</a>
        </div>
    </x-slot>

    <div class="container mt-5">
        <h4 class="mb-4">Produits en alerte</h4>

        <div class="row">
            <!-- Produits en rupture -->
            <div class="col-md-6 mb-4">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">Produits en rupture</div>
                    <div class="card-body">
                        @if($rupture->isEmpty())
                            <p class="text-muted">Aucun produit en rupture.</p>
                        @else
                            <ul class="list-group">
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

            <!-- Produits en quantité faible -->
            <div class="col-md-6 mb-4">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">Produits sous le seuil</div>
                    <div class="card-body">
                        @if($seuil->isEmpty())
                            <p class="text-muted">Aucun produit sous le seuil de sécurité.</p>
                        @else
                            <ul class="list-group">
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
            <div class="col-md-6 mb-4">
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

            <!-- Produits expirés -->
            <div class="col-md-6 mb-4">
                <div class="card border-secondary">
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
    </div>
</x-app-layout>
