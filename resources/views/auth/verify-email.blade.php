<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-lg p-4 animate__animated animate__fadeIn" style="width: 100%; max-width: 500px;">
            <div class="text-center mb-4">
                <x-application-logo style="height: 50px;" class="mb-3" />
                <h4 class="fw-bold text-primary">Vérification de l'adresse email</h4>
                <p class="text-muted">
                    Merci de vous être inscrit ! Avant de continuer, veuillez cliquer sur le lien de vérification que nous venons d’envoyer à votre adresse email.
                    <br>
                    Si vous n’avez pas reçu l’email, nous pouvons vous en renvoyer un.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <!-- Resend Verification Email -->
            <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                @csrf
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-check me-2"></i> Renvoyer l’email de vérification
                    </button>
                </div>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-left me-2"></i> Se déconnecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
