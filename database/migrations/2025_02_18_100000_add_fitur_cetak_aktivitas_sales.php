<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambah fitur "cetak" (export Excel) untuk menu aktivitas_sales di master_fiturs.
     */
    public function up(): void
    {
        $menusId = DB::table('master_menus')
            ->where('link_menus', 'aktivitas_sales')
            ->value('id_menus');

        if ($menusId === null) {
            return;
        }

        $exists = DB::table('master_fiturs')
            ->where('menus_id', $menusId)
            ->where('nama_fiturs', 'cetak')
            ->exists();

        if (!$exists) {
            DB::table('master_fiturs')->insert([
                'menus_id'   => $menusId,
                'nama_fiturs' => 'cetak',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $menusId = DB::table('master_menus')
            ->where('link_menus', 'aktivitas_sales')
            ->value('id_menus');

        if ($menusId !== null) {
            $fiturIds = DB::table('master_fiturs')
                ->where('menus_id', $menusId)
                ->where('nama_fiturs', 'cetak')
                ->pluck('id_fiturs');

            if ($fiturIds->isNotEmpty()) {
                DB::table('master_akses')->whereIn('fiturs_id', $fiturIds)->delete();
            }

            DB::table('master_fiturs')
                ->where('menus_id', $menusId)
                ->where('nama_fiturs', 'cetak')
                ->delete();
        }
    }
};
