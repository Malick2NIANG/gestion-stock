<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modifications_stock', function (Blueprint $table) {
            // Supprimer la contrainte existante
            $table->dropForeign(['produit_id']);
        });

        Schema::table('modifications_stock', function (Blueprint $table) {
            // Rendre nullable
            $table->unsignedBigInteger('produit_id')->nullable()->change();

            // Recréer la contrainte avec ON DELETE SET NULL
            $table->foreign('produit_id')
                  ->references('id')->on('produits')
                  ->onDelete('set null');
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
                  ->onDelete('cascade');
        });
    }
};

