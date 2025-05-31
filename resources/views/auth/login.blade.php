<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-box {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            animation: fadeIn 0.6s ease-in-out;
        }
        .login-box h4 {
            font-weight: 700;
            color: #3730a3;
        }
        .login-box .form-control {
            border-radius: 10px;
        }
        .login-box .btn-outline-dark {
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .login-box .btn-outline-dark:hover {
            background-color: #3730a3;
            color: white;
        }
        .login-box .form-check-label {
            font-size: 0.9rem;
        }
        .input-group-text {
            background-color: #e2e8f0;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-box">
            <div class="text-center mb-4">
                <div class="d-flex justify-content-center mb-3">
                    <x-application-logo style="height: 55px;" />
                </div>
                <h4 class="text-primary mt-2">Bienvenue sur Gestion Stock</h4>
                <p class="text-muted">Connectez-vous pour accéder à votre espace</p>
            </div>

            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <input id="password" type="password" name="password" required
                            class="form-control @error('password') is-invalid @enderror">
                        <span class="input-group-text" id="togglePassword">
                            <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                        </span>
                    </div>
                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none small text-primary" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-outline-dark px-4 py-2 w-100 position-relative" id="loginBtn">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner" role="status" aria-hidden="true"></span>
                        <i class="bi bi-box-arrow-in-right me-1"></i> <span id="btnText">Se connecter</span>
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    // Spinner
                    const form = document.querySelector('form');
                    const btn = document.getElementById('loginBtn');
                    const text = document.getElementById('btnText');
                    const spinner = document.getElementById('spinner');

                    form.addEventListener('submit', () => {
                        btn.disabled = true;
                        spinner.classList.remove('d-none');
                        text.textContent = 'Connexion en cours...';
                    });

                    // Toggle visibility
                    const togglePassword = document.getElementById('togglePassword');
                    const passwordInput = document.getElementById('password');
                    const icon = document.getElementById('togglePasswordIcon');

                    togglePassword.addEventListener('click', () => {
                        const type = passwordInput.type === 'password' ? 'text' : 'password';
                        passwordInput.type = type;
                        icon.classList.toggle('bi-eye');
                        icon.classList.toggle('bi-eye-slash');
                    });
                });
            </script>
        </div>
    </div>
</x-guest-layout>
