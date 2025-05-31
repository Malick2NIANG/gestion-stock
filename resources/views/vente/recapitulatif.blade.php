<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-primary fs-4">
                <i class="bi bi-receipt me-2"></i> Récapitulatif de la vente
            </h2>
            <a href="{{ route('vente.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-arrow-left-circle"></i> Retour
            </a>
        </div>
    </x-slot>

    <div class="container mt-4 animate__animated animate__fadeInUp">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <!-- Tableau du panier -->
        <div class="card shadow-lg mb-4">
            <div class="card-body">
                <h5 class="mb-3 fw-bold">🛒 Produits ajoutés :</h5>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($ventes as $item)
                                @php $total += $item['produit']->prix_unitaire * $item['quantite']; @endphp
                                <tr>
                                    <td>{{ $item['produit']->nom_produit }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-sm btn-outline-secondary me-1 btn-moins" data-id="{{ $item['produit']->id }}">-</button>
                                            <span class="quantite" id="quantite-{{ $item['produit']->id }}">{{ $item['quantite'] }}</span>
                                            <button class="btn btn-sm btn-outline-secondary ms-1 btn-plus" data-id="{{ $item['produit']->id }}">+</button>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item['produit']->prix_unitaire, 0, ',', ' ') }} F CFA</td>
                                    <td id="total-{{ $item['produit']->id }}">{{ number_format($item['total'], 0, ',', ' ') }} F CFA</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalSupprimer{{ $item['produit']->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- Modal suppression produit -->
                                        <div class="modal fade" id="modalSupprimer{{ $item['produit']->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item['produit']->id }}" aria-hidden="true" data-bs-backdrop="false">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="modalLabel{{ $item['produit']->id }}">Confirmation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        Supprimer <strong>{{ $item['produit']->nom_produit }}</strong> du panier ?
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <form action="{{ route('vente.panier.supprimer', $item['produit']->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Total global :</td>
                                <td id="total-global">{{ number_format($total, 0, ',', ' ') }} F CFA</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalViderPanier">
                        <i class="bi bi-x-circle"></i> Vider le panier
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Vider le panier -->
        <div class="modal fade" id="modalViderPanier" tabindex="-1" aria-labelledby="modalViderPanierLabel" aria-hidden="true" data-bs-backdrop="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="modalViderPanierLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body text-center">
                        Êtes-vous sûr de vouloir vider tout le panier ?
                    </div>
                    <div class="modal-footer justify-content-center">
                        <form action="{{ route('vente.panier.vider') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Oui, vider</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire mode de paiement -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('vente.valider') }}" method="POST" id="paiementForm">
                    @csrf

                    <div class="mb-3">
                        <label for="mode_paiement" class="form-label fw-semibold">Sélectionnez le mode de paiement :</label>
                        <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                            <option value="">-- Choisir un mode de paiement --</option>
                            <option value="especes">Espèces</option>
                            <option value="wave">Wave</option>
                            <option value="orange money">Orange Money</option>
                            <option value="carte">Carte</option>
                        </select>
                    </div>

                    <div id="paiementEspeces" style="display: none;">
                        <div class="mb-3">
                            <label for="montant_recu" class="form-label">Montant reçu du client (F CFA) :</label>
                            <input type="number" name="montant_recu" id="montant_recu" class="form-control" min="0" step="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Montant à rendre :</label>
                            <input type="text" id="montant_rendu" class="form-control" readonly>
                        </div>
                    </div>

                    <input type="hidden" name="total_general" value="{{ $total }}">

                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-1"></i> Valider la vente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modeSelect = document.getElementById('mode_paiement');
            const divEspeces = document.getElementById('paiementEspeces');
            const montantRecu = document.getElementById('montant_recu');
            const montantRendu = document.getElementById('montant_rendu');
            const paiementForm = document.getElementById('paiementForm');

            const totalInitial = parseFloat({{ $total }});

            function toggleEspeces() {
                if (modeSelect.value === 'especes') {
                    divEspeces.style.display = 'block';
                    montantRecu.required = true;
                } else {
                    divEspeces.style.display = 'none';
                    montantRecu.required = false;
                    montantRecu.value = '';
                    montantRendu.value = '';
                }
            }

            montantRecu.addEventListener('input', () => {
                const recu = parseFloat(montantRecu.value);
                montantRendu.value = isNaN(recu) || recu < totalInitial ? '0' : (recu - totalInitial).toLocaleString('fr-FR') + ' F CFA';
            });

            modeSelect.addEventListener('change', toggleEspeces);
            toggleEspeces();

            paiementForm.addEventListener('submit', (e) => {
                const recu = parseFloat(montantRecu.value);
                if (modeSelect.value === 'especes' && (isNaN(recu) || recu < totalInitial)) {
                    e.preventDefault();
                    alert("Le montant reçu est insuffisant. Veuillez saisir un montant supérieur ou égal au total à payer.");
                    montantRecu.focus();
                }
            });

            // Ajout de la logique pour les boutons +/-
            const formatter = new Intl.NumberFormat('fr-FR');
            document.querySelectorAll('.btn-plus, .btn-moins').forEach(button => {
                button.addEventListener('click', async function () {
                    const produitId = this.dataset.id;
                    const quantiteSpan = document.getElementById('quantite-' + produitId);
                    let quantite = parseInt(quantiteSpan.textContent);

                    quantite = this.classList.contains('btn-plus') ? quantite + 1 : quantite - 1;
                    if (quantite < 1) return;

                    const response = await fetch("{{ route('vente.panier.mettreAJour') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ produit_id: produitId, quantite: quantite })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        quantiteSpan.textContent = data.quantite;
                        document.getElementById('total-' + produitId).textContent = formatter.format(data.total) + ' F CFA';
                        document.getElementById('total-global').textContent = formatter.format(data.totalGeneral) + ' F CFA';
                    } else {
                        alert(data.message || 'Erreur lors de la mise à jour.');
                    }
                });
            });
        });
    </script>
</x-app-layout>
