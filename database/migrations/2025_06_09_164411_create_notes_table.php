<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('matiere_id')->nullable()->constrained('matieres')->onDelete('set null');
            $table->string('type'); // Contrôle, Devoir, Examen, Participation
            $table->decimal('note', 4, 2); // Note sur 20
            $table->decimal('coefficient', 3, 2)->default(1.00);
            $table->text('commentaire')->nullable();
            $table->boolean('validated')->default(false);
            $table->date('date_evaluation')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
};
