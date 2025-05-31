<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-clock-history me-2"></i> Historique global
            </h2>
            <a href="{{ route('responsable.dashboard') }}" class="btn btn-outline-dark">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        <div class="row g-4">
            <!-- Historique des ventes -->
            <div class="col-md-6 animate__animated animate__zoomIn">
                <div class="card border-primary shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-primary"><i class="bi bi-cart-check"></i> Historique des ventes</h5>
                            <p class="card-text">Consultez l'ensemble des ventes réalisées par les vendeurs avec détails TTC, TVA et HT.</p>
                        </div>
                        <a href="{{ route('responsable.historique.ventes') }}" class="btn btn-outline-primary mt-3">Voir les ventes</a>
                    </div>
                </div>
            </div>

            <!-- Historique des modifications de stock -->
            <div class="col-md-6 animate__animated animate__zoomIn">
                <div class="card border-secondary shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-secondary"><i class="bi bi-pencil-square"></i> Historique des modifications</h5>
                            <p class="card-text">Visualisez toutes les modifications de stock effectuées par les gestionnaires (ajouts, suppressions, modifications).</p>
                        </div>
                        <a href="{{ route('responsable.historique.modifications') }}" class="btn btn-outline-secondary mt-3">Voir les modifications</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
