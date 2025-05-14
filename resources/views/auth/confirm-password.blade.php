<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 animate__animated animate__fadeIn" style="width: 100%; max-width: 450px;">
            <div class="text-center mb-4">
                <x-application-logo style="height: 50px;" class="mb-3" />
                <h4 class="fw-bold text-primary">Confirmation du mot de passe</h4>
                <p class="text-muted small">
                    Cette opération est sécurisée. Merci de confirmer votre mot de passe pour continuer.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-lock-fill me-1"></i> Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
