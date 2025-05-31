<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm animate__animated animate__fadeInDown" style="position: relative; z-index: 1050;">
    <div class="container-fluid">
        <!-- Bouton menu burger -->
        <button class="btn btn-outline-primary me-3" id="toggleSidebar" style="border-radius: 50%;">
            <i class="bi bi-list fs-5"></i>
        </button>

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center"
            href="{{
                Auth::user()->role === 'vendeur' ? route('vendeur.dashboard') :
                (Auth::user()->role === 'responsable' ? route('responsable.dashboard') :
                route('gestionnaire.dashboard'))
            }}">
                <x-application-logo class="me-2" style="height: 30px; width: auto;" />
                <span class="fw-bold text-primary fs-5">Gestion Stock</span>
        </a>


        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->


            <!-- Right Side -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="z-index: 2000;">
                        <li class="px-3 pb-2 text-center">
                            <form method="POST" action="{{ route('logout') }}" onsubmit="handleLogout(this)">
                                @csrf
                                <button id="logout-btn" type="submit" class="btn btn-outline-dark w-100 d-flex justify-content-center align-items-center gap-2">
                                    <span id="logout-text">Déconnexion</span>
                                    <div id="logout-spinner" class="spinner-border spinner-border-sm text-black d-none" role="status"></div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <!-- SIDEBAR LATERAL GAUCHE -->
    <div id="sidebarMenu" class="position-fixed top-0 start-0 vh-100 bg-white shadow-lg border-end p-4 animate__animated animate__fadeInLeft"
         style="width: 260px; display: none; z-index: 2001;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="text-primary fw-bold mb-0"><i class="bi bi-grid-fill me-2"></i>Menu</h5>
            <button class="btn btn-sm btn-close" onclick="toggleSidebar()" aria-label="Fermer"></button>
        </div>

    <ul class="nav flex-column fw-semibold">
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('redirect') }}">
                <i class="bi bi-house-door me-2 text-primary"></i>Accueil
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('produits.index') }}">
                <i class="bi bi-box-seam me-2 text-info"></i>Liste des produits
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('produits.alertes') }}">
                <i class="bi bi-bell-fill me-2 text-warning"></i>Alertes de stock
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('produits.rapports') }}">
                <i class="bi bi-bar-chart-fill me-2 text-secondary"></i>Rapports
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('modifications-stock.index') }}">
                <i class="bi bi-clock-history me-2 text-dark"></i>Historique stock
            </a>
        </li>
        <li class="nav-item mt-3">
            <a class="nav-link text-dark" href="{{ route('produits.create') }}">
                <i class="bi bi-plus-circle-fill me-2 text-success"></i>Ajouter produit
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="{{ route('reapprovisionnement.liste_produits') }}">
                <i class="bi bi-truck me-2 text-primary"></i> Réapprovisionnement
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

    <!-- SCRIPTS JS -->
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
