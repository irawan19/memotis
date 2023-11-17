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
        Schema::create('surat_disposisis', function (Blueprint $table) {
            $table->id('id_surat_disposisis');
            $table->bigInteger('surat_users_id')->unsigned()->index()->nullable();
            $table->foreign('surat_users_id')->references('id_surat_users')->on('surat_users')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('surat_disposisis_id')->unsigned()->index()->nullable();
            $table->foreign('surat_disposisis_id')->references('id_disposisi_surats')->on('master_disposisi_surats')->onUpdate('set null')->onDelete('set null');
            $table->longtext('keterangan_surat_disposisis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_disposisis');
    }
};
