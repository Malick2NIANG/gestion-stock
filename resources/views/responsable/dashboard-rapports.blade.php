<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-speedometer2 me-2"></i> Tableau de bord Responsable
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('responsable.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container py-4 animate__animated animate__fadeInUp">

    <!-- Statistiques générales -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-start border-info border-4 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Vendeurs</h6>
                    <p class="fs-3 fw-bold text-info">{{ $nbVendeurs }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-primary border-4 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Gestionnaires</h6>
                    <p class="fs-3 fw-bold text-primary">{{ $nbGestionnaires }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-success border-4 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Produits</h6>
                    <p class="fs-3 fw-bold text-success">{{ $totalProduits }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-secondary border-4 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Valeur Stock (Prix de vente)</h6>
                    <p class="fs-5 fw-bold text-secondary">{{ number_format($valeurTotaleStock, 0, ',', ' ') }} F CFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Coût d'acquisition du stock -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-start border-dark border-4 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Coût Total d'Acquisition</h6>
                    <p class="fs-5 fw-bold text-dark">{{ number_format($coutTotalAcquisition, 0, ',', ' ') }} F CFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques (Camembert + Courbe ventes par jour) -->
    <div class="row g-4 mb-4">
        <!-- Camembert État du stock -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">État global du stock</div>
                <div class="card-body">
                    <canvas id="etatStockChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Courbe Ventes par jour -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">Évolution des ventes</div>
                <div class="card-body">
                    <canvas id="ventesParJourChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 produits les plus et les moins vendus -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Top 5 produits les plus vendus</div>
                <div class="card-body">
                    <canvas id="topProduitsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">Top 5 produits les moins vendus</div>
                <div class="card-body">
                    <canvas id="moinsProduitsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Camembert répartition catégories et univers -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">Répartition des produits par catégorie</div>
                <div class="card-body">
                    <canvas id="categorieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">Répartition des ventes par univers</div>
                <div class="card-body">
                    <canvas id="universChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div> <!-- container -->

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Graphiques -->
<script>
    // Camembert État du stock
    new Chart(document.getElementById('etatStockChart'), {
        type: 'pie',
        data: {
            labels: ['Ruptures', 'Sous Seuil', 'Bientôt Expirés', 'Expirés'],
            datasets: [{
                data: [{{ $ruptures }}, {{ $sousSeuil }}, {{ $bientotExpires }}, {{ $expires }}],
                backgroundColor: ['#dc3545', '#ffc107', '#17a2b8', '#343a40']
            }]
        }
    });

    // Courbe Ventes par jour
    new Chart(document.getElementById('ventesParJourChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($ventesParJour->pluck('date')->toArray()) !!},
            datasets: [{
                label: 'Nb Ventes',
                data: {!! json_encode($ventesParJour->pluck('total')->toArray()) !!},
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Bar chart Top 5 produits les plus vendus
    new Chart(document.getElementById('topProduitsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topLabels) !!},
            datasets: [{
                label: 'Quantité vendue',
                data: {!! json_encode($topData) !!},
                backgroundColor: '#007bff'
            }]
        }
    });

    // Bar chart Top 5 produits les moins vendus
    new Chart(document.getElementById('moinsProduitsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($moinsLabels) !!},
            datasets: [{
                label: 'Quantité vendue',
                data: {!! json_encode($moinsData) !!},
                backgroundColor: '#6c757d'
            }]
        }
    });

    // Camembert répartition des catégories
    new Chart(document.getElementById('categorieChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($categorieLabels) !!},
            datasets: [{
                data: {!! json_encode($categorieData) !!},
                backgroundColor: [
                    '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff', '#ff9f40', '#00c49f'
                ]
            }]
        }
    });

    // Camembert répartition des ventes par univers
    new Chart(document.getElementById('universChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($universLabels) !!},
            datasets: [{
                data: {!! json_encode($universData) !!},
                backgroundColor: [
                    '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff', '#ff9f40', '#00c49f'
                ]
            }]
        }
    });
</script>

</x-app-layout>
