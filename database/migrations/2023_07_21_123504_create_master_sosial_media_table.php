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
        Schema::create('master_sosial_medias', function (Blueprint $table) {
            $table->id('id_sosial_medias');
            $table->string('icon_sosial_medias');
            $table->string('nama_sosial_medias');
            $table->string('url_sosial_medias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_sosial_medias');
    }
};
