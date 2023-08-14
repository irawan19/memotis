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
        Schema::create('surat_selesais', function (Blueprint $table) {
            $table->id('id_surat_selesais');
            $table->bigInteger('surat_users_id')->unsigned()->index()->nullable();
            $table->foreign('surat_users_id')->references('id_surat_users')->on('surat_users')->onUpdate('set null')->onDelete('set null');
            $table->string('file_surat_selesais');
            $table->string('nama_file_surat_selesais');
            $table->string('ukuran_file_surat_selesais');
            $table->string('type_file_surat_selesais');
            $table->longtext('keterangan_surat_selesais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_selesais');
    }
};
