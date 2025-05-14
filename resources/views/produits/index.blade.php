<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des produits') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Barre de recherche -->
        <form method="GET" action="{{ route('produits.index') }}" class="mb-4 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par nom ou code..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix (F CFA)</th>
                    <th>Quantité</th>
                    <th>Expiration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produits as $produit)
                    <tr>
                        <td>{{ $produit->code_produit }}</td>
                        <td>{{ $produit->nom_produit }}</td>
                        <td>{{ $produit->categorie }}</td>
                        <td>{{ number_format($produit->prix_unitaire, 2) }}</td>
                        <td>{{ $produit->quantite }}</td>
                        <td>{{ $produit->date_expiration ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('produits.edit', $produit) }}" class="btn btn-sm btn-warning">Modifier</a>

                            <!-- Bouton qui déclenche la modale -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $produit->id }}">
                                Supprimer
                            </button>

                            <!-- Modale Bootstrap -->
                            <div class="modal fade" id="confirmDeleteModal{{ $produit->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $produit->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="confirmDeleteLabel{{ $produit->id }}">Confirmation de suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer le produit <strong>{{ $produit->nom_produit }}</strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                                            <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- JS Bootstrap (si ce n'est pas déjà dans le layout principal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
