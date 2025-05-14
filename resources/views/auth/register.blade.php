<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-lg p-4 animate__animated animate__fadeIn" style="width: 100%; max-width: 550px;">
            <div class="text-center mb-4">
                <x-application-logo style="height: 50px;" class="mb-3" />
                <h4 class="fw-bold text-primary">Créer un compte utilisateur</h4>
                <p class="text-muted small">Veuillez remplir les champs pour ajouter un nouvel utilisateur.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input id="nom" type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required autofocus>
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Prénom -->
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input id="prenom" type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                    @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Rôle -->
                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">-- Sélectionner un rôle --</option>
                        <option value="vendeur" {{ old('role') == 'vendeur' ? 'selected' : '' }}>Vendeur</option>
                        <option value="gestionnaire" {{ old('role') == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                        <option value="responsable" {{ old('role') == 'responsable' ? 'selected' : '' }}>Responsable</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="text-muted small">
                        <i class="bi bi-arrow-left me-1"></i> Déjà inscrit ?
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-person-plus-fill me-1"></i> S'inscrire
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
