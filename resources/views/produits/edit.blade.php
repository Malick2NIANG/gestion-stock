<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-warning fs-4">
                <i class="bi bi-pencil-square me-2"></i> Modifier un produit
            </h2>
            <div>
                <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('produits.update', $produit) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Code produit</label>
                            <input type="text" name="code_produit" value="{{ old('code_produit', $produit->code_produit) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom du produit</label>
                            <input type="text" name="nom_produit" value="{{ old('nom_produit', $produit->nom_produit) }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Catégorie</label>
                            <select name="categorie" class="form-select" required>
                                <option value="" disabled>-- Choisir --</option>
                                <option value="Alimentaire" {{ $produit->categorie == 'Alimentaire' ? 'selected' : '' }}>Alimentaire</option>
                                <option value="Auto" {{ $produit->categorie == 'Auto' ? 'selected' : '' }}>Auto</option>
                                <option value="Non alimentaire" {{ $produit->categorie == 'Non alimentaire' ? 'selected' : '' }}>Non alimentaire</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Prix unitaire (F CFA)</label>
                            <input type="number" step="0.01" name="prix_unitaire" value="{{ old('prix_unitaire', $produit->prix_unitaire) }}" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Prix d'acquisition (F CFA)</label>
                            <input type="number" step="0.01" name="prix_acquisition" value="{{ old('prix_acquisition', $produit->prix_acquisition) }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Quantité</label>
                            <input type="number" name="quantite" value="{{ old('quantite', $produit->quantite) }}" class="form-control" required>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label fw-semibold">Date d'expiration</label>
                            <input type="date" name="date_expiration" value="{{ old('date_expiration', $produit->date_expiration) }}" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning me-2 animate__animated animate__pulse animate__infinite">
                            <i class="bi bi-check-circle me-1"></i> Mettre à jour
                        </button>
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle me-1"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
