<x-app-layout>
    <style>
        body {
            background: linear-gradient(135deg, #dbeafe, #eef2ff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 0;
        }

        .register-box {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.07);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.6s ease-in-out;
        }

        .register-box h4 {
            font-weight: 700;
            color: #1d4ed8;
        }

        .register-box p {
            font-size: 0.95rem;
        }

        .register-box .form-control,
        .register-box .form-select {
            border-radius: 10px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            background-color: #1d4ed8;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-return {
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="register-wrapper">
        <div class="register-box">
            <!-- Logo et titre -->
            <div class="text-center mb-4">
                <div class="d-flex justify-content-center mb-3">
                    <x-application-logo style="height: 55px;" />
                </div>
                <h4 class="mt-3">Gestion Stock</h4>
                <p class="text-muted">Ajouter un nouvel utilisateur</p>
            </div>

            <form method="POST" action="{{ route('responsable.utilisateurs.store') }}">
                @csrf

                <!-- Nom -->
                <div class="mb-3">
                    <label for="nom" class="form-label fw-semibold">Nom</label>
                    <input id="nom" type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Prénom -->
                <div class="mb-3">
                    <label for="prenom" class="form-label fw-semibold">Prénom</label>
                    <input id="prenom" type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                    @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Rôle -->
                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Rôle</label>
                    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">-- Choisir un rôle --</option>
                        <option value="vendeur" {{ old('role') == 'vendeur' ? 'selected' : '' }}>Vendeur</option>
                        <option value="gestionnaire" {{ old('role') == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Info mot de passe -->
                <p class="text-muted small mb-4">
                    🔐 Un mot de passe temporaire sera généré automatiquement et envoyé à l'utilisateur par e-mail.
                </p>

                <!-- Boutons -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('responsable.utilisateurs') }}" class="btn-return text-muted">
                        <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-person-plus me-1"></i> Créer le compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
