<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Historique des modifications de stock
        </h2>
    </x-slot>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('modifications-stock.export') }}" class="btn btn-outline-secondary">
                <i class="bi bi-download me-1"></i> Exporter en PDF
            </a>
            <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i> Retour à l’accueil
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Action</th>
                        <th>Ancienne quantité</th>
                        <th>Nouvelle quantité</th>
                        <th>Quantité totale</th>
                        <th>Par</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($modifications as $modif)
                        <tr>
                            <td>{{ $modif->nom_produit ?? '-' }}</td>
                            <td>
                                @if($modif->action === 'ajout')
                                    <span class="badge bg-success">Ajout</span>
                                @elseif($modif->action === 'modification')
                                    <span class="badge bg-warning text-dark">Modification</span>
                                @elseif($modif->action === 'suppression')
                                    <span class="badge bg-danger">Suppression</span>
                                @elseif($modif->action === 'réapprovisionnement') <!-- ✅ Ajout du cas réapprovisionnement -->
                                    <span class="badge bg-info text-dark">Réapprovisionnement</span>
                                @endif
                            </td>
                            <td>{{ $modif->ancienne_quantite ?? '-' }}</td>
                            <td>{{ $modif->nouvelle_quantite }}</td>
                            <td>{{ $modif->quantite_totale }}</td>
                            <td>{{ $modif->gestionnaire->prenom ?? '-' }} {{ $modif->gestionnaire->nom ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($modif->date_modification)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucune modification enregistrée pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
