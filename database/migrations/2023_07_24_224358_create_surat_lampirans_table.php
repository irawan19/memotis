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
        Schema::create('surat_lampirans', function (Blueprint $table) {
            $table->id('id_surat_lampirans');
            $table->bigInteger('surats_id')->unsigned()->index()->nullable();
            $table->foreign('surats_id')->references('id_surats')->on('surats')->onUpdate('set null')->onDelete('set null');
            $table->string('file_surat_lampirans');
            $table->string('nama_file_surat_lampirans');
            $table->string('ukuran_file_surat_lampirans');
            $table->string('type_file_surat_lampirans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_lampirans');
    }
};
