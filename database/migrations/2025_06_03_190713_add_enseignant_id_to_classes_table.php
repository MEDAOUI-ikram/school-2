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
    Schema::table('classes', function (Blueprint $table) {
        $table->unsignedBigInteger('enseignant_id')->nullable()->after('id');
        $table->foreign('enseignant_id')->references('id')->on('enseignants')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('classes', function (Blueprint $table) {
        $table->dropForeign(['enseignant_id']);
        $table->dropColumn('enseignant_id');
    });
    }
};
