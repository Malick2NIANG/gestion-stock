<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-pencil-square me-2"></i> Modifier l'utilisateur
            </h2>
            <a href="{{ route('responsable.utilisateurs') }}" class="btn btn-outline-dark">
                <i class="bi bi-arrow-left-circle"></i> Retour
            </a>
        </div>
    </x-slot>

    <div class="container mt-5 animate__animated animate__fadeInUp">
        @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow border-0">
            <div class="card-body p-4">
                <form action="{{ route('responsable.utilisateurs.update', $utilisateur->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $utilisateur->prenom) }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $utilisateur->nom) }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $utilisateur->email) }}" class="form-control shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label">Rôle</label>
                        <select name="role" id="role" class="form-select shadow-sm" required>
                            <option value="vendeur" {{ old('role', $utilisateur->role) === 'vendeur' ? 'selected' : '' }}>Vendeur</option>
                            <option value="gestionnaire" {{ old('role', $utilisateur->role) === 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('responsable.utilisateurs') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
