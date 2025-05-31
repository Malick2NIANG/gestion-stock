<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-check2-circle me-2"></i> Confirmation de la vente
            </h2>
        </div>
    </x-slot>

    <div class="container mt-5 animate__animated animate__fadeInUp">
        <div class="card shadow-lg border-0 rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                </div>
                <h3 class="fw-bold text-success mb-3">Vente enregistrée avec succès !</h3>
                <p class="fs-5 text-muted">Souhaitez-vous imprimer le ticket de cette vente ?</p>

                <div class="d-flex justify-content-center gap-4 mt-5">
                    <button onclick="imprimerEtRediriger()" class="btn btn-lg btn-success shadow-sm px-4">
                        <i class="bi bi-printer-fill me-2"></i> Oui, imprimer
                    </button>
                    <a href="{{ route('vendeur.dashboard') }}" class="btn btn-lg btn-outline-dark shadow-sm px-4">
                        <i class="bi bi-x-circle me-2"></i> Non merci
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function imprimerEtRediriger() {
            window.open("{{ route('vente.ticket.pdf') }}", "_blank");

            // Redirection avec petit délai pour que l'impression se lance correctement
            setTimeout(() => {
                window.location.href = "{{ route('vendeur.dashboard') }}";
            }, 1500);
        }
    </script>

    <style>
        .btn-success:hover {
            background-color: #198754;
            color: white;
        }
        .btn-outline-dark:hover {
            background-color: #333;
            color: white;
        }
    </style>
</x-app-layout>
