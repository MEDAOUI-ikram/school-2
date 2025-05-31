<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classe_etudiant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classe_id');
            $table->unsignedBigInteger('etudiant_id');
            $table->string('nom_groupe')->nullable(); // Groupe A, B, C, etc.
            $table->date('date_inscription')->default(now());
            $table->timestamps();

            // Clés étrangères
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');

            // Index pour optimiser les requêtes
            $table->index(['classe_id', 'etudiant_id']);
            $table->index('nom_groupe');

            // Contrainte d'unicité pour éviter qu'un étudiant soit dans la même classe plusieurs fois
            $table->unique(['classe_id', 'etudiant_id'], 'unique_classe_etudiant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_etudiant');
    }
};
