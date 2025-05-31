<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm animate__animated animate__fadeInDown" style="position: relative; z-index: 1050;">
    <div class="container-fluid">
        <!-- Bouton menu burger -->
        <button class="btn btn-outline-primary me-3" id="toggleSidebar" style="border-radius: 50%;">
            <i class="bi bi-list fs-5"></i>
        </button>

        <!-- Logo + Titre -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('vendeur.dashboard') }}">
            <x-application-logo class="me-2" style="height: 30px;" />
            <span class="fw-bold text-primary fs-5">Gestion Stock</span>
        </a>

        <!-- Bouton responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVendeur">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Droite : utilisateur -->
        <div class="collapse navbar-collapse" id="navbarVendeur">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold text-dark" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="px-3 pb-2 text-center">
                            <form method="POST" action="{{ route('logout') }}" onsubmit="handleLogout(this)">
                                @csrf
                                <button id="logout-btn" type="submit" class="btn btn-outline-dark w-100 d-flex justify-content-center align-items-center gap-2">
                                    <span id="logout-text">Déconnexion</span>
                                    <div id="logout-spinner" class="spinner-border spinner-border-sm d-none" role="status"></div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <!-- SIDEBAR LATÉRAL GAUCHE -->
    <div id="sidebarMenu" class="position-fixed top-0 start-0 vh-100 bg-white shadow-lg border-end p-4 animate__animated animate__fadeInLeft"
         style="width: 260px; display: none; z-index: 2001;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="text-primary fw-bold mb-0"><i class="bi bi-grid-fill me-2"></i>Menu</h5>
            <button class="btn btn-sm btn-close" onclick="toggleSidebar()" aria-label="Fermer"></button>
        </div>

        <ul class="nav flex-column fw-semibold">
            <li class="nav-item mb-2">
                <a class="nav-link text-dark" href="{{ route('vendeur.dashboard') }}">
                    <i class="bi bi-house-door me-2 text-primary"></i>Accueil
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-dark" href="{{ route('vente.create') }}">
                    <i class="bi bi-plus-circle me-2 text-success"></i>Effectuer une vente
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-dark" href="{{ route('vente.historique') }}">
                    <i class="bi bi-clock-history me-2 text-warning"></i>Historique des ventes
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-dark" href="{{ route('profile.password.edit') }}">
                    <i class="bi bi-key-fill me-2 text-secondary"></i> Modifier mon mot de passe
                </a>
            </li>

        </ul>

        <hr class="my-4">
        <p class="text-muted small text-center">&copy; {{ now()->year }} Gestion Stock</p>
    </div>

    <!-- Scripts -->
    <script>
        function handleLogout(form) {
            event.preventDefault();
            const text = form.querySelector('#logout-text');
            const spinner = form.querySelector('#logout-spinner');
            const button = form.querySelector('#logout-btn');

            text.textContent = 'Déconnexion...';
            spinner.classList.remove('d-none');
            button.disabled = true;

            setTimeout(() => {
                form.submit();
            }, 800);
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            sidebar.style.display = (sidebar.style.display === 'none') ? 'block' : 'none';
        }

        document.getElementById('toggleSidebar').addEventListener('click', toggleSidebar);
    </script>
</nav>
