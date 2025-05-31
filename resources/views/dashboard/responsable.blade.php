<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-person-badge me-2"></i> Espace Responsable
            </h2>
        </div>
    </x-slot>

    <div class="container py-5 animate__animated animate__fadeInUp">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-primary">Bienvenue, Responsable</h1>
            <p class="lead">Surveillez, gérez et contrôlez l’ensemble du système en toute simplicité.</p>
        </div>

        <div class="row g-4">

            <!-- Tableau de bord -->
            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInLeft">
                <div class="card border-info border-3 shadow-lg h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-info"><i class="bi bi-bar-chart-line"></i> Tableau de bord</h5>
                            <p class="card-text">Consultez les indicateurs clés : ventes, alertes, produits critiques.</p>
                        </div>
                        <a href="{{ route('responsable.dashboard.rapport') }}" class="btn btn-info mt-3">Voir le dashboard</a>
                    </div>
                </div>
            </div>

            <!-- Gestion utilisateurs -->
            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInRight">
                <div class="card border-primary border-3 shadow-lg h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-primary"><i class="bi bi-people"></i> Utilisateurs</h5>
                            <p class="card-text">Créer, modifier ou supprimer des comptes avec rôles (vendeur, gestionnaire).</p>
                        </div>
                        <a href="{{ route('responsable.utilisateurs') }}" class="btn btn-primary mt-3">Gérer les utilisateurs</a>
                    </div>
                </div>
            </div>

            <!-- Historique des ventes -->
            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp">
                <div class="card border-success border-3 shadow-lg h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success"><i class="bi bi-clock-history"></i> Historique global</h5>
                            <p class="card-text">Consultez toutes les ventes regroupées par date, heure et vendeur.</p>
                        </div>
                        <a href="{{ route('responsable.ventes') }}" class="btn btn-success mt-3">Voir les ventes</a>
                    </div>
                </div>
            </div>

            <!-- Stock & alertes -->
            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInLeft">
                <div class="card border-warning border-3 shadow-lg h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-warning"><i class="bi bi-box-seam"></i> Stock & Alertes</h5>
                            <p class="card-text">Consultez les produits expirés, en rupture ou en seuil critique.</p>
                        </div>
                        <a href="{{ route('responsable.stock') }}" class="btn btn-warning mt-3">Surveiller le stock</a>
                    </div>
                </div>
            </div>

            <!-- Inventaire & Bilan -->
            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInRight">
                <div class="card border-secondary border-3 shadow-lg h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-secondary"><i class="bi bi-clipboard-data"></i> Inventaire & Bilan</h5>
                            <p class="card-text">Générez un inventaire détaillé sur une période donnée : bénéfices, pertes, coûts.</p>
                        </div>
                        <a href="{{ route('responsable.rapport') }}" class="btn btn-secondary mt-3">Voir l'inventaire</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
