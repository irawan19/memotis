<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use App\Helpers\General;
use App\Models\Aktivitas_sales;

class LaporanAktivitasSalesExport implements FromView, ShouldQueue
{
    use Exportable;

    public function view(): View
    {
        $hasil_kata = session('hasil_kata', '');
        $hasil_bulan_mulai = session('hasil_bulan_mulai', date('n'));
        $hasil_tahun_mulai = session('hasil_tahun_mulai', date('Y'));
        $hasil_bulan_selesai = session('hasil_bulan_selesai', date('n'));
        $hasil_tahun_selesai = session('hasil_tahun_selesai', date('Y'));
        $hasil_status_sales = session('hasil_status_sales', '');
        $hasil_unit_kerja = session('hasil_unit_kerja', '');

        $hari_terakhir = General::tanggalTerakhir((int) $hasil_tahun_selesai, (int) $hasil_bulan_selesai);
        $hasil_tanggal_mulai = sprintf('%04d-%02d-01', (int) $hasil_tahun_mulai, (int) $hasil_bulan_mulai);
        $hasil_tanggal_selesai = sprintf('%04d-%02d-%02d', (int) $hasil_tahun_selesai, (int) $hasil_bulan_selesai, $hari_terakhir);

        $lihat_laporan_aktivitas_sales = $this->buildAggregasi($hasil_tanggal_mulai, $hasil_tanggal_selesai, $hasil_kata, $hasil_status_sales, $hasil_unit_kerja);

        $data['lihat_laporan_aktivitas_sales'] = $lihat_laporan_aktivitas_sales;
        $data['hasil_bulan_mulai'] = $hasil_bulan_mulai;
        $data['hasil_tahun_mulai'] = $hasil_tahun_mulai;
        $data['hasil_bulan_selesai'] = $hasil_bulan_selesai;
        $data['hasil_tahun_selesai'] = $hasil_tahun_selesai;
        return view('dashboard.laporan_aktivitas_sales.cetakexcel', $data);
    }

    private function buildAggregasi($tanggal_mulai, $tanggal_selesai, $hasil_kata, $hasil_status_sales, $unit_kerjas_id = '')
    {
        $query = DB::table('aktivitas_sales')
            ->selectRaw("
                users.unit_kerjas_id,
                master_unit_kerjas.nama_unit_kerjas,
                DATE_FORMAT(aktivitas_sales.tanggal_aktivitas_sales, '%Y-%m') AS month_key,
                aktivitas_sales.users_id,
                users.name,
                SUM(aktivitas_sales.total_aktivitas_sales) AS total,
                SUM(COALESCE(aktivitas_sales.room_revenue, 0)) AS room_revenue,
                SUM(COALESCE(aktivitas_sales.banquet_revenue, 0)) AS banquet_revenue,
                SUM(CASE WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 1 AND 7 THEN aktivitas_sales.total_aktivitas_sales ELSE 0 END) AS w1,
                SUM(CASE WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 8 AND 14 THEN aktivitas_sales.total_aktivitas_sales ELSE 0 END) AS w2,
                SUM(CASE WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 15 AND 21 THEN aktivitas_sales.total_aktivitas_sales ELSE 0 END) AS w3,
                SUM(CASE WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 22 AND 31 THEN aktivitas_sales.total_aktivitas_sales ELSE 0 END) AS w4
            ")
            ->join('users', 'aktivitas_sales.users_id', '=', 'users.id')
            ->leftJoin('master_unit_kerjas', function ($j) {
                $j->on('users.unit_kerjas_id', '=', 'master_unit_kerjas.id_unit_kerjas')
                  ->whereNull('master_unit_kerjas.deleted_at');
            })
            ->whereBetween('aktivitas_sales.tanggal_aktivitas_sales', [$tanggal_mulai, $tanggal_selesai])
            ->groupByRaw("users.unit_kerjas_id, master_unit_kerjas.nama_unit_kerjas, DATE_FORMAT(aktivitas_sales.tanggal_aktivitas_sales, '%Y-%m'), aktivitas_sales.users_id, users.name")
            ->orderByRaw('COALESCE(master_unit_kerjas.nama_unit_kerjas, \'zzz\')')
            ->orderBy('month_key')
            ->orderBy('users.name');

        if ($unit_kerjas_id !== '' && $unit_kerjas_id !== null) {
            $query->where('users.unit_kerjas_id', $unit_kerjas_id);
        }
        if ($hasil_status_sales !== '' && $hasil_status_sales !== null) {
            $query->where('aktivitas_sales.status_sales_id', $hasil_status_sales);
        }
        if ($hasil_kata !== '' && $hasil_kata !== null) {
            $hasil_kata = trim((string) $hasil_kata);
            $query->leftJoin('master_segmentasi_sales', 'aktivitas_sales.segmentasi_sales_id', '=', 'master_segmentasi_sales.id_segmentasi_sales')
                ->leftJoin('master_project_sales', 'aktivitas_sales.project_sales_id', '=', 'master_project_sales.id_project_sales');
            $search = '%' . $hasil_kata . '%';
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(aktivitas_sales.nama_aktivitas_sales) LIKE LOWER(?)', [$search])
                    ->orWhereRaw('LOWER(users.name) LIKE LOWER(?)', [$search])
                    ->orWhereRaw('LOWER(COALESCE(master_segmentasi_sales.nama_segmentasi_sales, "")) LIKE LOWER(?)', [$search])
                    ->orWhereRaw('LOWER(COALESCE(master_project_sales.nama_project_sales, "")) LIKE LOWER(?)', [$search]);
            });
        }

        $rows = $query->get();
        $sections = [];
        foreach ($rows as $r) {
            $ukId = $r->unit_kerjas_id ?? '_null';
            $ukName = $r->nama_unit_kerjas ?: 'SALES TARGET';
            if (!isset($sections[$ukId])) {
                $sections[$ukId] = ['unit_name' => $ukName, 'rows' => []];
            }
            $monthLabel = General::ubahDBKeBulan((int) substr($r->month_key, 5, 2)) . ' ' . substr($r->month_key, 0, 4);
            $sections[$ukId]['rows'][] = [
                'month_key'       => $r->month_key,
                'month_label'     => $monthLabel,
                'name'            => $r->name,
                'total'           => (float) $r->total,
                'room_revenue'    => (float) ($r->room_revenue ?? 0),
                'banquet_revenue' => (float) ($r->banquet_revenue ?? 0),
                'w1'              => (float) ($r->w1 ?? 0),
                'w2'              => (float) ($r->w2 ?? 0),
                'w3'              => (float) ($r->w3 ?? 0),
                'w4'              => (float) ($r->w4 ?? 0),
            ];
        }
        return array_values($sections);
    }
}
