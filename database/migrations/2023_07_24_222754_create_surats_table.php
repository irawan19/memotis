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
        Schema::create('surats', function (Blueprint $table) {
            $table->id('id_surats');
            $table->bigInteger('klasifikasi_surats_id')->unsigned()->index()->nullable();
            $table->foreign('klasifikasi_surats_id')->references('id_klasifikasi_surats')->on('master_klasifikasi_surats')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('derajat_surats_id')->unsigned()->index()->nullable();
            $table->foreign('derajat_surats_id')->references('id_derajat_surats')->on('master_derajat_surats')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('sifat_surats_id')->unsigned()->index()->nullable();
            $table->foreign('sifat_surats_id')->references('id_sifat_surats')->on('master_sifat_surats')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('users_id')->unsigned()->index()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('set null')->onDelete('set null');
            $table->string('no_surats');
            $table->string('no_asal_surats');
            $table->string('asal_surats');
            $table->string('judul_surats');
            $table->date('tanggal_asal_surats')->nullable();
            $table->date('tanggal_mulai_surats')->nullable();
            $table->date('tanggal_selesai_surats')->nullable();
            $table->string('perihal_surats');
            $table->longtext('ringkasan_surats');
            $table->longtext('keterangan_surats');
            $table->double('status_agendakan_surats')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
