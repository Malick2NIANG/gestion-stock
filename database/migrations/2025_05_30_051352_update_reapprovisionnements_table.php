<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reapprovisionnements', function (Blueprint $table) {

            // Supprimer les colonnes inutiles
            $table->dropColumn('quantite_initiale');
            $table->dropColumn('quantite_totale');

            // Renommer date_ajout en date_reappro
            $table->renameColumn('date_ajout', 'date_reappro');

            // Ajouter les nouveaux champs
            $table->decimal('prix_acquisition_unitaire', 10, 2)->after('quantite_ajoutee');
            $table->decimal('prix_acquisition_total', 10, 2)->after('prix_acquisition_unitaire');
        });
    }

    public function down(): void
    {
        Schema::table('reapprovisionnements', function (Blueprint $table) {

            // Pour rollback
            $table->unsignedInteger('quantite_initiale');
            $table->unsignedInteger('quantite_totale');
            $table->renameColumn('date_reappro', 'date_ajout');
            $table->dropColumn('prix_acquisition_unitaire');
            $table->dropColumn('prix_acquisition_total');
        });
    }
};
