<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Étend l'enum de la colonne 'action' pour inclure 'suppression'.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE modifications_stock
            MODIFY action ENUM('ajout', 'modification', 'suppression') NOT NULL");
    }

    /**
     * Revenir à l’état précédent (sans 'suppression' si besoin).
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE modifications_stock
            MODIFY action ENUM('ajout', 'modification') NOT NULL");
    }
};
