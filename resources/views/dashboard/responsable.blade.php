<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Espace Responsable') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Gestion des utilisateurs</h5>
                        <p class="card-text">Ajoutez des comptes pour les vendeurs ou gestionnaires.</p>
                        <a href="#" class="btn btn-primary">Gérer les utilisateurs</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-danger">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Suivi global</h5>
                        <p class="card-text">Surveillez l'ensemble des ventes, du stock et des utilisateurs.</p>
                        <a href="#" class="btn btn-danger">Voir le suivi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
