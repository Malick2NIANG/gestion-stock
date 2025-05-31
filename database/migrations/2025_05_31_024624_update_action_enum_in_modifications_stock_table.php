<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateActionEnumInModificationsStockTable extends Migration
{
    public function up(): void
    {
        // ATTENTION : nécessite Doctrine/DBAL pour modifier ENUM
        Schema::table('modifications_stock', function (Blueprint $table) {
            $table->enum('action', ['ajout', 'modification', 'suppression', 'réapprovisionnement'])
                  ->change();
        });
    }

    public function down(): void
    {
        // Optionnel : si on veut revenir en arrière
        Schema::table('modifications_stock', function (Blueprint $table) {
            $table->enum('action', ['ajout', 'modification', 'suppression'])
                  ->change();
        });
    }
}
