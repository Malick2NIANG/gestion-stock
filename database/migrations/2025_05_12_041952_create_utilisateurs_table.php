<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->enum('role', ['vendeur', 'gestionnaire', 'responsable']);
            $table->string('adresse')->nullable();             // ✅ Nouvelle colonne
            $table->string('cni')->nullable();                 // ✅ Nouvelle colonne
            $table->string('password');
            $table->boolean('password_modifie')->default(false);  // ✅ Nouvelle colonne
            $table->string('password_defaut')->nullable();        // ✅ Nouvelle colonne
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
