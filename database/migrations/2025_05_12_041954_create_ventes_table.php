<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // 👤 Vendeur (user)
            $table->unsignedInteger('quantite');                                     // 🧮 Quantité vendue
            $table->decimal('prix_total', 10, 2);                                    // 💰 Montant total
            $table->enum('mode_paiement', ['espèces', 'wave', 'orange money', 'carte']); // 💳 Paiement
            $table->dateTime('date_vente')->default(now());                         // 📅 Date de la vente
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
