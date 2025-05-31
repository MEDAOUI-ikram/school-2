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
        Schema::table('matieres', function (Blueprint $table) {
            $table->unsignedBigInteger('niveau_id')->nullable()->after('coefficient');
            $table->text('description')->nullable()->after('niveau_id');
            $table->foreign('niveau_id')->references('id')->on('niveaux')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matieres', function (Blueprint $table) {
            $table->dropForeign(['niveau_id']);
            $table->dropColumn(['niveau_id', 'description']);
        });
    }
};
