<x-app-layout>
    <div class="container py-5 animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-header bg-primary text-white fs-5 fw-bold rounded-top-4">
                        <i class="bi bi-lock-fill me-2"></i>Modifier mon mot de passe
                    </div>

                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf

                            <!-- Mot de passe actuel -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">Mot de passe actuel</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password" class="form-control rounded-start @error('current_password') is-invalid @enderror" required>
                                    <button class="btn btn-outline-secondary rounded-end toggle-password" type="button" data-target="current_password">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nouveau mot de passe -->
                            <div class="mb-3">
                                <label for="new_password" class="form-label fw-semibold">Nouveau mot de passe</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" class="form-control rounded-start @error('new_password') is-invalid @enderror" required>
                                    <button class="btn btn-outline-secondary rounded-end toggle-password" type="button" data-target="new_password">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label fw-semibold">Confirmer le nouveau mot de passe</label>
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control rounded-start" required>
                                    <button class="btn btn-outline-secondary rounded-end toggle-password" type="button" data-target="new_password_confirmation">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Bouton -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm">
                                    <i class="bi bi-shield-lock me-1"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour voir/masquer les mots de passe -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = button.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            });
        });
    </script>
</x-app-layout>
