<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">Ajouter un nouveau produit</h2>
            <div>
                <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                <a href="{{ route('gestionnaire.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-house-door"></i> Retour à l'accueil
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
                <form action="{{ route('produits.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Code produit</label>
                            <input type="text" name="code_produit" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom du produit</label>
                            <input type="text" name="nom_produit" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Catégorie</label>
                            <select name="categorie" class="form-select" required>
                                <option value="">-- Choisir --</option>
                                <option value="Alimentaire">Alimentaire</option>
                                <option value="Auto">Auto</option>
                                <option value="Non alimentaire">Non alimentaire</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Prix unitaire de vente (F CFA)</label>
                            <input type="number" step="0.01" name="prix_unitaire" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Prix unitaire d'acquisition (F CFA)</label>
                            <input type="number" step="0.01" name="prix_acquisition" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Quantité</label>
                            <input type="number" name="quantite" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date d'expiration (facultative)</label>
                            <input type="date" name="date_expiration" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-check-circle me-1"></i> Enregistrer
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
