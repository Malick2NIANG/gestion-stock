<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Espace Vendeur') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <!-- En-tête de bienvenue -->
        <div class="text-center mb-5 animate__animated animate__fadeInDown">
            <h1 class="display-5 fw-bold">Bienvenue dans votre espace de vente</h1>
            <p class="lead">Effectuez, gérez et consultez vos ventes rapidement et efficacement.</p>
        </div>

        <div class="row g-4">
            <!-- Effectuer une vente -->
            <div class="col-md-6 col-lg-4 animate__animated animate__zoomIn">
                <div class="card border-primary shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-primary"><i class="bi bi-cash-coin"></i> Effectuer une vente</h5>
                            <p class="card-text">Sélectionnez des produits, définissez les quantités et finalisez la vente.</p>
                        </div>
                        <a href="{{ route('vente.create') }}" class="btn btn-outline-primary mt-3">Nouvelle vente</a>
                    </div>
                </div>
            </div>

             <!-- Exporter rapport -->
            <div class="col-md-6 col-lg-4 animate__animated animate__zoomIn">
                <div class="card border-info shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success"><i class="bi bi-clock-history"></i> Historique des ventes</h5>
                            <p class="card-text">Recherchez vos anciennes ventes par date et exportez les rapports.</p>
                        </div>
                        <a href="{{ route('vente.historique') }}" class="btn btn-outline-success mt-3">Consulter</a>
                    </div>
                </div>
            </div>

            <!-- Historique des ventes -->
            <div class="col-md-6 col-lg-4 animate__animated animate__zoomIn">
                <div class="card border-success shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success"><i class="bi bi-clock-history"></i> Historique des ventes</h5>
                            <p class="card-text">Recherchez vos anciennes ventes par date et exportez les rapports.</p>
                        </div>
                        <a href="{{ route('vente.historique') }}" class="btn btn-outline-success mt-3">Consulter</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
