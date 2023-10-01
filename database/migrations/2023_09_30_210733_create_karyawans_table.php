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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id('id_karyawans');
            $table->bigInteger('users_id')->unsigned()->index()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('jabatans_id')->unsigned()->index()->nullable();
            $table->foreign('jabatans_id')->references('id_jabatans')->on('master_jabatans')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('unit_kerjas_id')->unsigned()->index()->nullable();
            $table->foreign('unit_kerjas_id')->references('id_unit_kerjas')->on('master_unit_kerjas')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('jenis_kelamins_id')->unsigned()->index()->nullable();
            $table->foreign('jenis_kelamins_id')->references('id_jenis_kelamins')->on('master_jenis_kelamins')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('agamas_id')->unsigned()->index()->nullable();
            $table->foreign('agamas_id')->references('id_agamas')->on('master_agamas')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('status_kawins_id')->unsigned()->index()->nullable();
            $table->foreign('status_kawins_id')->references('id_status_kawins')->on('master_status_kawins')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('pendidikans_id')->unsigned()->index()->nullable();
            $table->foreign('pendidikans_id')->references('id_pendidikans')->on('master_pendidikans')->onUpdate('set null')->onDelete('set null');
            $table->string('foto_karyawans');
            $table->string('nama_karyawans');
            $table->string('nik_gys_karyawans');
            $table->string('nik_tg_karyawans');
            $table->string('band_posisi_karyawans');
            $table->date('tanggal_bergabung_karyawans')->nullable();
            $table->date('tanggal_keluar_karyawans')->nullable();
            $table->date('tanggal_lahir_karyawans');
            $table->string('tempat_lahir_karyawans');
            $table->longtext('alamat_rumah_karyawans');
            $table->longtext('institusi_karyawans');
            $table->longtext('hobi_karyawans');
            $table->longtext('keahlian_khusus_karyawans');
            $table->string('no_hp_karyawans');
            $table->string('email_karyawans');
            $table->string('ktp_karyawans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
