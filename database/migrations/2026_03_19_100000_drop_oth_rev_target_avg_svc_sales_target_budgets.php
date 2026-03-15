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
        Schema::table('sales_target_budgets', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('sales_target_budgets', 'oth_rev_target')) {
                $cols[] = 'oth_rev_target';
            }
            if (Schema::hasColumn('sales_target_budgets', 'avg_svc')) {
                $cols[] = 'avg_svc';
            }
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_target_budgets', function (Blueprint $table) {
            $table->double('oth_rev_target')->nullable()->after('fb_rev_target');
            $table->double('avg_svc')->nullable()->after('oth_rev_target');
        });
    }
};
