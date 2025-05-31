<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-success fs-4">
                <i class="bi bi-cash-coin me-2"></i> Inventaire Périodique
            </h2>
            <a href="{{ route('responsable.dashboard') }}" class="btn btn-outline-dark">
                <i class="bi bi-house-door"></i> Accueil
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">

        <!-- Formulaire de sélection de période -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('responsable.rapport') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-semibold">Date début :</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-semibold">Date fin :</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Générer Bilan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bilan Inventaire (Période) -->
        <div class="card mt-5 shadow border-success">
            <div class="card-header bg-success text-white fw-bold">
                <i class="bi bi-cash-coin me-1"></i> Bilan Inventaire (du {{ $startDate->format('d/m/Y') }} au {{ $endDate->format('d/m/Y') }})
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-3 g-4">

                    <div class="col">
                        <div class="card border-primary shadow-sm h-100 text-center">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted">Quantité vendue</h6>
                                <h3 class="fw-bold text-primary">{{ $quantiteVendue }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card border-success shadow-sm h-100 text-center">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted">Montant total des ventes</h6>
                                <h4 class="fw-bold text-success">{{ number_format($montantTotalVentes, 0, ',', ' ') }} F CFA</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card border-info shadow-sm h-100 text-center">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted">Coût d'acquisition des produits vendus</h6>
                                <h4 class="fw-bold text-info">{{ number_format($coutAcquisitionVentes, 0, ',', ' ') }} F CFA</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card border-warning shadow-sm h-100 text-center">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted">Bénéfice net</h6>
                                <h4 class="fw-bold text-warning">{{ number_format($beneficeNet, 0, ',', ' ') }} F CFA</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card border-danger shadow-sm h-100 text-center">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted">Valeur pertes (produits expirés)</h6>
                                <h4 class="fw-bold text-danger">{{ number_format($valeurPertes, 0, ',', ' ') }} F CFA</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
