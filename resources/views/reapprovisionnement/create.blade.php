<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-download me-2"></i> Réapprovisionner le produit
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('reapprovisionnement.liste_produits') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour à la liste des produits
                </a>
                <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <h5 class="alert-heading">Erreurs rencontrées :</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- ✅ Formulaire adapté avec route dynamique et hidden produit_id -->
                <form action="{{ route('reapprovisionnement.store', $produit->id) }}" method="POST">
                    @csrf

                    <!-- Champ caché obligatoire -->
                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                    <!-- Infos produit sélectionné -->
                    <div class="mb-4 p-3 border rounded bg-light">
                        <h5 class="text-primary fw-bold mb-2">Produit sélectionné :</h5>
                        <p class="mb-1"><strong>Code :</strong> {{ $produit->code_produit }}</p>
                        <p class="mb-1"><strong>Nom :</strong> {{ $produit->nom_produit }}</p>
                        <p class="mb-0"><strong>Stock actuel :</strong> {{ $produit->quantite }}</p>
                    </div>

                    <!-- Champs du formulaire -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Quantité à ajouter</label>
                            <input type="number" name="quantite_ajoutee" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Prix unitaire d'acquisition (F CFA)</label>
                            <input type="number" name="prix_acquisition_unitaire" class="form-control" step="0.01" min="0.01" required>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-check-circle me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('reapprovisionnement.liste_produits') }}" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle me-1"></i> Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
