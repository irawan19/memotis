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
        Schema::create('mom_users', function (Blueprint $table) {
            $table->id('id_mom_users');
            $table->bigInteger('moms_id')->unsigned()->index()->nullable();
            $table->foreign('moms_id')->references('id_moms')->on('moms')->onUpdate('set null')->onDelete('set null');
            $table->bigInteger('users_id')->unsigned()->index()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('set null')->onDelete('set null');
            $table->boolean('status_baca_mom_users')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_users');
    }
};
