<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 animate__animated animate__fadeIn" style="width: 100%; max-width: 500px;">
            <div class="text-center mb-4">
                <x-application-logo style="height: 50px;" class="mb-3" />
                <h4 class="fw-bold text-primary">Réinitialiser le mot de passe</h4>
                <p class="text-muted small">Veuillez définir un nouveau mot de passe sécurisé.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token de réinitialisation -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $request->email) }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-lock-fill me-2"></i> Réinitialiser le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
