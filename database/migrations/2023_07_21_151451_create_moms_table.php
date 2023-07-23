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
        Schema::create('moms', function (Blueprint $table) {
            $table->id('id_moms');
            $table->string('no_moms');
            $table->string('judul_moms');
            $table->datetime('tanggal_mulai_moms');
            $table->datetime('tanggal_selesai_moms');
            $table->string('venue_moms');
            $table->longtext('deskripsi_moms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moms');
    }
};
