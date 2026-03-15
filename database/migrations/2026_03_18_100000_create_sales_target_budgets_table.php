<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Budget/target sales per user per bulan (untuk laporan % W1–W4 dan % result).
     */
    public function up(): void
    {
        Schema::create('sales_target_budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id')->index();
            $table->string('period', 7)->comment('Y-m, contoh: 2026-02');
            $table->double('total_sales_target')->default(0)->comment('Total Sales Target');
            $table->double('room_rev_target')->nullable()->comment('ROOM Rev Target');
            $table->double('fb_rev_target')->nullable()->comment('FB Rev Target');
            $table->double('budget_w1')->default(0)->comment('Budget minggu 1');
            $table->double('budget_w2')->default(0)->comment('Budget minggu 2');
            $table->double('budget_w3')->default(0)->comment('Budget minggu 3');
            $table->double('budget_w4')->default(0)->comment('Budget minggu 4');
            $table->timestamps();
            $table->unique(['users_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_target_budgets');
    }
};
