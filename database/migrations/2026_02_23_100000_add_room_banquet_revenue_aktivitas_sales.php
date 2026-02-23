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
        Schema::table('aktivitas_sales', function (Blueprint $table) {
            $table->double('room_revenue')->nullable()->default(0)->after('total_aktivitas_sales');
            $table->double('banquet_revenue')->nullable()->default(0)->after('room_revenue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aktivitas_sales', function (Blueprint $table) {
            $table->dropColumn(['room_revenue', 'banquet_revenue']);
        });
    }
};
