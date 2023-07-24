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
        Schema::create('surat_users', function (Blueprint $table) {
            $table->id('id_surat_users');
            $table->bigInteger('surats_id')->unsigned()->index()->nullable();
            $table->foreign('surats_id')->references('id_surats')->on('surats')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('users_id')->unsigned()->index()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('set null')->onDelete('set null');
            $table->boolean('status_baca_surat_users')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_users');
    }
};
