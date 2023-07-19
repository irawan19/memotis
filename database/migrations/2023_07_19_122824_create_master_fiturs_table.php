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
        Schema::create('master_fiturs', function (Blueprint $table) {
            $table->id('id_fiturs');
            $table->bigInteger('menus_id')->unsigned()->index();
            $table->foreign('menus_id')->references('id_menus')->on('master_menus')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_fiturs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_fiturs');
    }
};
