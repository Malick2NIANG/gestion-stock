<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Espace Gestionnaire') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="text-center mb-5 animate__animated animate__fadeInDown">
            <h1 class="display-5 fw-bold">Bienvenue dans votre espace de gestion</h1>
            <p class="lead">Gérez efficacement les produits, surveillez les alertes et consultez les rapports en toute simplicité.</p>
        </div>

        <div class="row g-4">

            <!-- Ajouter un produit -->
            <div class="col-md-6 col-lg-4 animate__animated animate__zoomIn">
                <div class="card border-success shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success"><i class="bi bi-plus-circle-fill"></i> Ajouter un produit</h5>
                            <p class="card-text">Ajoutez un nouveau produit au stock avec ses informations complètes.</p>
                        </div>
                        <a href="{{ route('produits.create') }}" class="btn btn-outline-success mt-3">Ajouter</a>
                    </div>
                </div>
            </div>

            <!-- Gérer les produits -->
            <div class="col-md-6 col-lg-4 animate__animated animate__zoomIn">
                <div class="card border-info shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-info"><i class="bi bi-box-seam"></i> Liste des produits</h5>
                            <p class="card-text">Afficher, modifier ou supprimer les produits disponibles en stock.</p>
                        </div>
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-info mt-3">Gérer</a>
                    </div>
                </div>
            </div>

            <!-- Alertes -->
            <div class="col-md-6 col-lg-4 animate__animated animate__zoomIn">
                <div class="card border-warning shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-warning"><i class="bi bi-bell-fill"></i> Alertes de stock</h5>
                            <p class="card-text">Produits en rupture, expirés ou sous le seuil de sécurité.</p>
                        </div>
                        <a href="{{ route('produits.alertes') }}" class="btn btn-outline-warning mt-3 position-relative">
                            Voir les alertes
                            @php
                                $nbAlertes = App\Models\Produit::compterAlertesNonVues();
                            @endphp
                            @if ($nbAlertes > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $nbAlertes }}
                                    <span class="visually-hidden">notifications non lues</span>
                                </span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            <!-- Rapports -->
            <div class="col-md-12 animate__animated animate__fadeInUp">
                <div class="card border-secondary shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-secondary"><i class="bi bi-bar-chart-fill"></i> Rapports</h5>
                            <p class="card-text">Analyser l'état global du stock à travers des rapports détaillés et téléchargeables.</p>
                        </div>
                        <a href="{{ route('produits.rapports') }}" class="btn btn-outline-secondary mt-3">Voir les rapports</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
