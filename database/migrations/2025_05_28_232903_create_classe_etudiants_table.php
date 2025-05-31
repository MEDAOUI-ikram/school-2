<?php
// database/migrations/xxxx_create_classe_etudiants_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classe_etudiants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->string('nom_groupe');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classe_etudiants');
    }
};
