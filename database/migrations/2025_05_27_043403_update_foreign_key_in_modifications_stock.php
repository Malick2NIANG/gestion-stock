<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modifications_stock', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte
            $table->dropForeign(['produit_id']);
        });

        Schema::table('modifications_stock', function (Blueprint $table) {
            // Rendre nullable et ajouter une nouvelle contrainte avec nullOnDelete
            $table->unsignedBigInteger('produit_id')->nullable()->change();
            $table->foreign('produit_id')
                  ->references('id')->on('produits')
                  ->nullOnDelete(); // ✅ remplace cascade par null
        });
    }

    public function down(): void
    {
        Schema::table('modifications_stock', function (Blueprint $table) {
            $table->dropForeign(['produit_id']);
        });

        Schema::table('modifications_stock', function (Blueprint $table) {
            $table->unsignedBigInteger('produit_id')->nullable(false)->change();
            $table->foreign('produit_id')
                  ->references('id')->on('produits')
                  ->onDelete('cascade'); // on remet cascade dans down()
        });
    }
};

