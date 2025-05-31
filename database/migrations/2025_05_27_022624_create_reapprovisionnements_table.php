<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reapprovisionnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('gestionnaire_id')->constrained('users')->onDelete('cascade');
            $table->unsignedInteger('quantite_initiale');
            $table->unsignedInteger('quantite_ajoutee');
            $table->unsignedInteger('quantite_totale');
            $table->timestamp('date_ajout')->useCurrent(); // Date de l'ajout
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reapprovisionnements');
    }
};
