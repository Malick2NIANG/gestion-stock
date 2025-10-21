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
    Schema::table('produits', function (Blueprint $table) {
        $table->decimal('prix_acquisition', 8, 2)->nullable()->after('prix_unitaire');
    });
}

public function down()
{
    Schema::table('produits', function (Blueprint $table) {
        $table->dropColumn('prix_acquisition');
    });
}
};
