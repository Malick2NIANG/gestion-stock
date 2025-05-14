<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un produit') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produits.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Code produit</label>
                <input type="text" name="code_produit" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nom du produit</label>
                <input type="text" name="nom_produit" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Alimentaire">Alimentaire</option>
                    <option value="Auto">Auto</option>
                    <option value="Non alimentaire">Non alimentaire</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix unitaire (F CFA)</label>
                <input type="number" step="0.01" name="prix_unitaire" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantité</label>
                <input type="number" name="quantite" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date d'expiration (facultative)</label>
                <input type="date" name="date_expiration" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</x-app-layout>
