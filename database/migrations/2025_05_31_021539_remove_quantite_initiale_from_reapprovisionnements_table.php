<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('reapprovisionnements', function (Blueprint $table) {
        $table->dropColumn('quantite_initiale');
    });
}

public function down()
{
    Schema::table('reapprovisionnements', function (Blueprint $table) {
        $table->unsignedInteger('quantite_initiale'); // tu peux lui mettre nullable() si tu veux.
    });
}

};
