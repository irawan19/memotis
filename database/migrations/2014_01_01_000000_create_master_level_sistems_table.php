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
        Schema::create('master_level_sistems', function (Blueprint $table) {
            $table->id('id_level_sistems');
            $table->string('nama_level_sistems');
            $table->bigInteger('divisis_id')->unsigned()->index()->nullable();
            $table->foreign('divisis_id')->references('id_divisis')->on('master_divisis')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('level_sistems_id')->unsigned()->index()->nullable();
            $table->foreign('level_sistems_id')->references('id_level_sistems')->on('master_level_sistems')->onUpdate('set null')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_level_sistems');
    }
};
