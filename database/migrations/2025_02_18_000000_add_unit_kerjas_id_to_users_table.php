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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_kerjas_id')->nullable()->after('level_sistems_id');
            $table->foreign('unit_kerjas_id')->references('id_unit_kerjas')->on('master_unit_kerjas')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['unit_kerjas_id']);
            $table->dropColumn('unit_kerjas_id');
        });
    }
};
