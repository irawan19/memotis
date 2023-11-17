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
        Schema::create('aktivitas_sales', function (Blueprint $table) {
            $table->id('id_aktivitas_sales');
            $table->bigInteger('users_id')->unsigned()->index()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('kegiatan_sales_id')->unsigned()->index()->nullable();
            $table->foreign('kegiatan_sales_id')->references('id_kegiatan_sales')->on('master_kegiatan_sales')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('segmentasi_sales_id')->unsigned()->index()->nullable();
            $table->foreign('segmentasi_sales_id')->references('id_segmentasi_sales')->on('master_segmentasi_sales')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('status_sales_id')->unsigned()->index()->nullable();
            $table->foreign('status_sales_id')->references('id_status_sales')->on('master_status_sales')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('project_sales_id')->unsigned()->index()->nullable();
            $table->foreign('project_sales_id')->references('id_project_sales')->on('master_project_sales')->onUpdate('set null')->onDelete('set null');
            $table->string('nama_aktivitas_sales');
            $table->longtext('alamat_aktivitas_sales');
            $table->string('pic_aktivitas_sales');
            $table->string('kontak_personal_aktivitas_sales');
            $table->string('periode_aktivitas_sales');
            $table->double('total_aktivitas_sales');
            $table->longtext('komentar_aktivitas_sales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas_sales');
    }
};
