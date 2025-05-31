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
        Schema::create('classe_enseignant_matiere', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classe_id');
            $table->unsignedBigInteger('enseignant_id');
            $table->unsignedBigInteger('matiere_id');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('enseignant_id')->references('id')->on('enseignants')->onDelete('cascade');
            $table->foreign('matiere_id')->references('id')->on('matieres')->onDelete('cascade');

            // Index pour optimiser les requêtes
            $table->index(['classe_id', 'enseignant_id']);
            $table->index(['enseignant_id', 'matiere_id']);
            $table->index(['classe_id', 'matiere_id']);

            // Contrainte d'unicité pour éviter les doublons
            $table->unique(['classe_id', 'enseignant_id', 'matiere_id'], 'unique_classe_enseignant_matiere');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_enseignant_matiere');
    }
};
