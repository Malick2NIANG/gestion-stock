<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le produit') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('produits.update', $produit) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Code produit</label>
                <input type="text" name="code_produit" value="{{ old('code_produit', $produit->code_produit) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nom du produit</label>
                <input type="text" name="nom_produit" value="{{ old('nom_produit', $produit->nom_produit) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie" class="form-control" required>
                    <option value="Alimentaire" {{ $produit->categorie == 'Alimentaire' ? 'selected' : '' }}>Alimentaire</option>
                    <option value="Auto" {{ $produit->categorie == 'Auto' ? 'selected' : '' }}>Auto</option>
                    <option value="Non alimentaire" {{ $produit->categorie == 'Non alimentaire' ? 'selected' : '' }}>Non alimentaire</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix unitaire (F CFA)</label>
                <input type="number" step="0.01" name="prix_unitaire" value="{{ old('prix_unitaire', $produit->prix_unitaire) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantité</label>
                <input type="number" name="quantite" value="{{ old('quantite', $produit->quantite) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date d'expiration</label>
                <input type="date" name="date_expiration" value="{{ old('date_expiration', $produit->date_expiration) }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</x-app-layout>
