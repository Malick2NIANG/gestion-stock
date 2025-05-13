<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id(); // id auto-incrémenté (clé primaire)
            $table->string('code_produit')->unique(); // identifiant unique (ex : COC123)
            $table->string('nom_produit');
            $table->enum('categorie', ['Alimentaire', 'Auto', 'Non alimentaire']);
            $table->decimal('prix_unitaire', 10, 2)->check('prix_unitaire > 0');
            $table->date('date_expiration')->nullable();
            $table->unsignedInteger('quantite');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
