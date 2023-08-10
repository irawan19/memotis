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
        Schema::create('mom_user_externals', function (Blueprint $table) {
            $table->id('id_mom_user_externals');
            $table->bigInteger('moms_id')->unsigned()->index()->nullable();
            $table->foreign('moms_id')->references('id_moms')->on('moms')->onUpdate('set null')->onDelete('set null');
            $table->string('nama_user_externals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_user_externals');
    }
};
