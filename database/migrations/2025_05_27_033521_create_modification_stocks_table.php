<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('modifications_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('gestionnaire_id')->constrained('users')->onDelete('cascade');
            $table->enum('action', ['ajout', 'modification', 'suppression']);
            $table->unsignedInteger('ancienne_quantite')->nullable();
            $table->unsignedInteger('nouvelle_quantite');
            $table->unsignedInteger('quantite_totale');
            $table->timestamp('date_modification')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modifications_stock');
    }
};
