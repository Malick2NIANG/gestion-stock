<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-people me-2"></i> Gestion des utilisateurs
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('responsable.utilisateurs.create') }}" class="btn btn-outline-success">
                    <i class="bi bi-person-plus-fill me-1"></i> Ajouter un utilisateur
                </a>
                <a href="{{ route('responsable.dashboard') }}" class="btn btn-outline-dark">
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

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-4 fw-bold text-secondary">Liste des gestionnaires et vendeurs</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($utilisateurs as $utilisateur)
                                <tr>
                                    <td>{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</td>
                                    <td>{{ $utilisateur->email }}</td>
                                    <td class="text-capitalize text-center">{{ $utilisateur->role }}</td>
                                    <td class="text-center">
                                        <!-- Redirection vers edit.blade -->
                                        <a href="{{ route('responsable.utilisateurs.edit', $utilisateur->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Réinitialiser mot de passe -->
                                        <form action="{{ route('responsable.utilisateurs.resetPassword', $utilisateur->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Réinitialiser le mot de passe"
                                                onclick="return confirm('Êtes-vous sûr de vouloir réinitialiser le mot de passe de {{ $utilisateur->prenom }} ?')">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>

                                        <!-- Supprimer -->
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $utilisateur->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- Modal suppression -->
                                        <div class="modal fade" id="deleteModal{{ $utilisateur->id }}" tabindex="-1" aria-labelledby="deleteLabel{{ $utilisateur->id }}" data-bs-backdrop="false">
                                            <div class="modal-dialog modal-dialog-centered animate__animated animate__fadeInDown">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteLabel{{ $utilisateur->id }}">Confirmation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p>Voulez-vous vraiment supprimer <strong>{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</strong> ?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <form action="{{ route('responsable.utilisateurs.destroy', $utilisateur->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
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
            </div>
        </div>
    </div>
</x-app-layout>
