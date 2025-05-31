<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('modifications_stock', function (Blueprint $table) {
            $table->string('nom_produit')->nullable()->after('produit_id');
        });
    }

    public function down(): void
    {
        Schema::table('modifications_stock', function (Blueprint $table) {
            $table->dropColumn('nom_produit');
        });
    }
};
