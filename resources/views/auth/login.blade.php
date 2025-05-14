<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        }
        .login-box {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 430px;
            animation: fadeIn 0.6s ease-in-out;
        }
        .login-box h4 {
            font-weight: 700;
        }
        .login-box .form-control {
            border-radius: 8px;
        }
        .login-box .btn-primary {
            background-color: #4f46e5;
            border: none;
            border-radius: 8px;
            padding: 10px 0;
        }
        .login-box .btn-primary:hover {
            background-color: #4338ca;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-box">
            <div class="text-center mb-4">
                <div class="d-flex justify-content-center mb-3">
                    <x-application-logo style="height: 60px;" />
                </div>
                <h4 class="text-primary mt-2">Connexion à votre compte</h4>
                <p class="text-muted">Bienvenue, veuillez entrer vos identifiants.</p>
            </div>


            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="current-password">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Remember -->
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none text-primary" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <div class="text-center mt-4">
    <button type="submit" class="btn btn-outline-dark px-4 py-2 position-relative fw-semibold" id="loginBtn">
        <span class="spinner-border spinner-border-sm me-2 d-none" id="spinner" role="status" aria-hidden="true"></span>
        <i class="bi bi-box-arrow-in-right me-1"></i> <span id="btnText">Se connecter</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        const btn = document.getElementById('loginBtn');
        const text = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', () => {
            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Connexion en cours...';
        });
    });
</script>

            </form>
        </div>
    </div>
</x-guest-layout>
