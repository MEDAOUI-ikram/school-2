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
    Schema::table('etudiants', function (Blueprint $table) {
        $table->foreignId('classe_id')->nullable()->constrained()->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('etudiants', function (Blueprint $table) {
        $table->dropForeign(['classe_id']);
        $table->dropColumn('classe_id');
    });
}
};