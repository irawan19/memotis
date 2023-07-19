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
        Schema::create('master_akses', function (Blueprint $table) {
            $table->id('id_akses');
            $table->bigInteger('level_sistems_id')->unsigned()->index();
            $table->foreign('level_sistems_id')->references('id_level_sistems')->on('master_level_sistems')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('fiturs_id')->unsigned()->index();
            $table->foreign('fiturs_id')->references('id_fiturs')->on('master_fiturs')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_akses');
    }
};
