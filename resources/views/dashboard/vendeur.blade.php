<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord - Vendeur') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Nouvelle vente</h5>
                        <p class="card-text">Saisissez une vente en sélectionnant un produit et la quantité vendue.</p>
                        <a href="#" class="btn btn-primary">Effectuer une vente</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Historique des ventes</h5>
                        <p class="card-text">Consultez la liste de vos ventes précédentes.</p>
                        <a href="#" class="btn btn-outline-secondary">Voir l'historique</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
