<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('adresse')->nullable();
            $table->string('cni')->nullable();
            $table->boolean('password_modifie')->default(false);
            $table->string('password_defaut')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['adresse', 'cni', 'password_modifie', 'password_defaut']);
        });
    }
};
