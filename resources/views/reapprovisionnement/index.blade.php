<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-truck me-2"></i> Historique des réapprovisionnements
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('reapprovisionnement.create') }}" class="btn btn-outline-success">
                    <i class="bi bi-plus-circle me-1"></i> Nouveau réapprovisionnement
                </a>
                <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Produit</th>
                        <th>Quantité initiale</th>
                        <th>Quantité ajoutée</th>
                        <th>Quantité totale</th>
                        <th>Prix unitaire d'acquisition (F CFA)</th>
                        <th>Gestionnaire</th>
                        <th>Date de réapprovisionnement</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reapprovisionnements as $reappro)
                        <tr>
                            <td>{{ $reappro->produit_nom }}</td>
                            <td class="text-center">{{ $reappro->quantite_initiale }}</td>
                            <td class="text-center text-success fw-bold">+{{ $reappro->quantite_ajoutee }}</td>
                            <td class="text-center">{{ $reappro->quantite_totale }}</td>
                            <td class="text-end">{{ number_format($reappro->prix_acquisition_unitaire, 2) }}</td>
                            <td class="text-center">
                                {{ $reappro->gestionnaire->prenom }} {{ $reappro->gestionnaire->nom }}
                            </td>
                            <td class="text-center">
                                {{ $reappro->date_ajout->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucun réapprovisionnement enregistré pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
