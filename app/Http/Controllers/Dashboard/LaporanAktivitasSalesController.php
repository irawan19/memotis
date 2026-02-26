<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\General;
use App\Models\Aktivitas_sales;
use App\Models\Master_kegiatan_sales;
use App\Models\Master_segmentasi_sales;
use App\Models\Master_status_sales;
use App\Models\Master_project_sales;
use App\Models\User;
use App\Models\Master_unit_kerja;
use Auth;
use App\Exports\LaporanAktivitasSalesExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanAktivitasSalesController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_laporan_aktivitas_sales = 'laporan_aktivitas_sales';
        if(General::hakAkses($link_laporan_aktivitas_sales,'lihat') == 'true')
        {
            $data['link_laporan_aktivitas_sales']       = $link_laporan_aktivitas_sales;
            $url_sekarang                               = $request->fullUrl();
            $data['hasil_kata']                         = '';
            $hasil_bulan_mulai                          = date('m');
            $data['hasil_bulan_mulai']                  = $hasil_bulan_mulai;
            $hasil_tahun_mulai                          = date('Y');
            $data['hasil_tahun_mulai']                  = $hasil_tahun_mulai;
            $hasil_bulan_selesai                        = date('m');
            $data['hasil_bulan_selesai']                = $hasil_bulan_selesai;
            $hasil_tahun_selesai                        = date('Y');
            $data['hasil_tahun_selesai']                = $hasil_tahun_selesai;
            $data['lihat_status_sales']                 = Master_status_sales::orderBy('nama_status_sales')->get();
            $data['lihat_unit_kerjas']                  = Master_unit_kerja::orderBy('nama_unit_kerjas')->get();
            $data['hasil_status_sales']                 = '';
            $data['hasil_unit_kerja']                   = '';
            $hari_terakhir                               = General::tanggalTerakhir((int) $hasil_tahun_selesai, (int) $hasil_bulan_selesai);
            $hasil_tanggal_mulai                        = sprintf('%04d-%02d-01', (int) $hasil_tahun_mulai, (int) $hasil_bulan_mulai);
            $hasil_tanggal_selesai                      = sprintf('%04d-%02d-%02d', (int) $hasil_tahun_selesai, (int) $hasil_bulan_selesai, $hari_terakhir);
            $data['lihat_laporan_aktivitas_sales']      = $this->getLaporanAggregasi($hasil_tanggal_mulai, $hasil_tanggal_selesai, '', '', '');
            $data['sales_achievement']                  = $this->getSalesAchievement($hasil_tanggal_mulai, $hasil_tanggal_selesai, '', '', '');
            $data['sales_achievement_dashboard']        = $this->getSalesAchievementDashboard($hasil_tanggal_mulai, $hasil_tanggal_selesai, '', '', '', $data['lihat_laporan_aktivitas_sales']);
            $data['hasil_tanggal_mulai']                = $hasil_tanggal_mulai;
            $data['hasil_tanggal_selesai']              = $hasil_tanggal_selesai;
            session()->forget('halaman');
            session()->forget('hasil_bulan_mulai');
            session()->forget('hasil_tahun_mulai');
            session()->forget('hasil_bulan_selesai');
            session()->forget('hasil_tahun_selesai');
            session()->forget('hasil_status_sales');
            session()->forget('hasil_unit_kerja');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.laporan_aktivitas_sales.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_laporan_aktivitas_sales = 'laporan_aktivitas_sales';
        if(General::hakAkses($link_laporan_aktivitas_sales,'lihat') == 'true')
        {
            $data['link_laporan_aktivitas_sales']   = $link_laporan_aktivitas_sales;
            $url_sekarang                           = $request->fullUrl();
            $data['hasil_kata']                     = '';
            $hasil_kata                             = trim((string) $request->get('cari_kata', ''));
            $data['hasil_kata']                     = $hasil_kata;
            $hasil_bulan_mulai                      = (int) $request->get('cari_bulan_mulai') ?: (int) date('n');
            $data['hasil_bulan_mulai']              = $hasil_bulan_mulai;
            $hasil_tahun_mulai                      = (int) $request->get('cari_tahun_mulai') ?: (int) date('Y');
            $data['hasil_tahun_mulai']              = $hasil_tahun_mulai;
            $hasil_bulan_selesai                    = (int) $request->get('cari_bulan_selesai') ?: (int) date('n');
            $data['hasil_bulan_selesai']            = $hasil_bulan_selesai;
            $hasil_tahun_selesai                    = (int) $request->get('cari_tahun_selesai') ?: (int) date('Y');
            $data['hasil_tahun_selesai']            = $hasil_tahun_selesai;
            $data['lihat_status_sales']             = Master_status_sales::orderBy('nama_status_sales')->get();
            $data['lihat_unit_kerjas']              = Master_unit_kerja::orderBy('nama_unit_kerjas')->get();
            $hasil_status_sales                     = $request->get('cari_status_sales', '');
            $hasil_unit_kerja                       = $request->get('cari_unit_kerja', '');
            $data['hasil_status_sales']             = $hasil_status_sales;
            $data['hasil_unit_kerja']               = $hasil_unit_kerja;

            $hari_terakhir_selesai = General::tanggalTerakhir($hasil_tahun_selesai, $hasil_bulan_selesai);
            $hasil_tanggal_mulai   = sprintf('%04d-%02d-01', $hasil_tahun_mulai, $hasil_bulan_mulai);
            $hasil_tanggal_selesai = sprintf('%04d-%02d-%02d', $hasil_tahun_selesai, $hasil_bulan_selesai, $hari_terakhir_selesai);

            $data['lihat_laporan_aktivitas_sales']  = $this->getLaporanAggregasi($hasil_tanggal_mulai, $hasil_tanggal_selesai, $hasil_kata, $hasil_status_sales, $hasil_unit_kerja);
            $data['sales_achievement']              = $this->getSalesAchievement($hasil_tanggal_mulai, $hasil_tanggal_selesai, $hasil_kata, $hasil_status_sales, $hasil_unit_kerja);
            $data['sales_achievement_dashboard']    = $this->getSalesAchievementDashboard($hasil_tanggal_mulai, $hasil_tanggal_selesai, $hasil_kata, $hasil_status_sales, $hasil_unit_kerja, $data['lihat_laporan_aktivitas_sales']);
            $data['hasil_tanggal_mulai']            = $hasil_tanggal_mulai;
            $data['hasil_tanggal_selesai']          = $hasil_tanggal_selesai;
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            session(['hasil_bulan_mulai'    => $hasil_bulan_mulai]);
            session(['hasil_tahun_mulai'    => $hasil_tahun_mulai]);
            session(['hasil_bulan_selesai'  => $hasil_bulan_selesai]);
            session(['hasil_tahun_selesai'  => $hasil_tahun_selesai]);
            session(['hasil_status_sales'   => $hasil_status_sales]);
            session(['hasil_unit_kerja'     => $hasil_unit_kerja]);
        	return view('dashboard.laporan_aktivitas_sales.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    /**
     * Agregasi aktivitas sales per unit, per bulan, per user, plus result per minggu (w1-w4).
     * Return: [ ['unit_name' => '...', 'rows' => [ ['month_key', 'month_label', 'name', 'total', 'w1','w2','w3','w4'], ... ] ], ... ]
     */
    private function getLaporanAggregasi($tanggal_mulai, $tanggal_selesai, $hasil_kata = '', $hasil_status_sales = '', $unit_kerjas_id = '')
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
            $query->leftJoin('master_segmentasi_sales', 'aktivitas_sales.segmentasi_sales_id', '=', 'master_segmentasi_sales.id_segmentasi_sales')
                ->leftJoin('master_project_sales', 'aktivitas_sales.project_sales_id', '=', 'master_project_sales.id_project_sales');
            $this->applyLaporanKeywordFilter($query, $hasil_kata);
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

    /**
     * Filter pencarian kata kunci (company, user, segmentation, project) - case insensitive.
     * Pakai leftJoin untuk segmentasi/project agar baris dengan FK null tetap ikut.
     */
    private function applyLaporanKeywordFilter($query, $hasil_kata)
    {
        $search = '%' . $hasil_kata . '%';
        $query->where(function ($q) use ($search) {
            $q->whereRaw('LOWER(aktivitas_sales.nama_aktivitas_sales) LIKE LOWER(?)', [$search])
                ->orWhereRaw('LOWER(users.name) LIKE LOWER(?)', [$search])
                ->orWhereRaw('LOWER(COALESCE(master_segmentasi_sales.nama_segmentasi_sales, "")) LIKE LOWER(?)', [$search])
                ->orWhereRaw('LOWER(COALESCE(master_project_sales.nama_project_sales, "")) LIKE LOWER(?)', [$search]);
        });
    }

    /**
     * Achievement = total result >= total target → achieved; else not achieved.
     * Persen dari akumulasi 4 minggu (W1+W2+W3+W4) per bulan: (total_result / total_target) * 100.
     * Total result = SUM(total_aktivitas_sales). Target: belum ada kolom, pakai total_result sebagai target (100%).
     * Return: [ 'cards' => [...], 'months' => [...], 'grid' => [ users_id => [ 'Y-m' => [ achieved_pct, not_achieved_pct, achieved, total_result, total_target ] ] ] ]
     */
    private function getSalesAchievement($tanggal_mulai, $tanggal_selesai, $hasil_kata = '', $hasil_status_sales = '', $unit_kerjas_id = '')
    {
        $baseQuery = DB::table('aktivitas_sales')
            ->join('users', 'aktivitas_sales.users_id', '=', 'users.id')
            ->whereBetween('aktivitas_sales.tanggal_aktivitas_sales', [$tanggal_mulai, $tanggal_selesai]);

        if ($unit_kerjas_id !== '' && $unit_kerjas_id !== null) {
            $baseQuery->where('users.unit_kerjas_id', $unit_kerjas_id);
        }
        if ($hasil_status_sales !== '' && $hasil_status_sales !== null) {
            $baseQuery->where('aktivitas_sales.status_sales_id', $hasil_status_sales);
        }
        if ($hasil_kata !== '' && $hasil_kata !== null) {
            $baseQuery->leftJoin('master_segmentasi_sales', 'aktivitas_sales.segmentasi_sales_id', '=', 'master_segmentasi_sales.id_segmentasi_sales')
                ->leftJoin('master_project_sales', 'aktivitas_sales.project_sales_id', '=', 'master_project_sales.id_project_sales');
            $this->applyLaporanKeywordFilter($baseQuery, $hasil_kata);
        }

        // Per user: total result (revenue) = akumulasi semua aktivitas. Target = total result (belum ada kolom target).
        $summary = (clone $baseQuery)
            ->selectRaw('
                aktivitas_sales.users_id,
                users.name,
                SUM(aktivitas_sales.total_aktivitas_sales) AS total_result
            ')
            ->groupBy('aktivitas_sales.users_id', 'users.name')
            ->orderBy('users.name')
            ->get();

        $cards = [];
        $cardColors = ['#6b4423', '#e67e22', '#27ae60', '#2980b9', '#8e44ad', '#c0392b'];
        $idx = 0;
        foreach ($summary as $r) {
            $totalResult = (float) $r->total_result;
            $totalTarget = $totalResult; // placeholder: tidak ada kolom target, pakai result = 100%
            $achieved = $totalResult >= $totalTarget;
            $achievementPct = $totalTarget > 0 ? (int) round(min(100, ($totalResult / $totalTarget) * 100)) : 0;
            $cards[] = [
                'users_id' => $r->users_id,
                'name' => $r->name,
                'total_result' => $totalResult,
                'total_target' => $totalTarget,
                'achieved' => $achieved,
                'achievement_pct' => $achievementPct,
                'color' => $cardColors[$idx % count($cardColors)],
            ];
            $idx++;
        }

        // Per user per bulan: 4 minggu (W1: 1-7, W2: 8-14, W3: 15-21, W4: 22-31). Persen = akumulasi 4 week result / target.
        $weekly = (clone $baseQuery)
            ->selectRaw('
                aktivitas_sales.users_id,
                DATE_FORMAT(aktivitas_sales.tanggal_aktivitas_sales, "%Y-%m") AS month_key,
                CASE
                    WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 1 AND 7 THEN 1
                    WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 8 AND 14 THEN 2
                    WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 15 AND 21 THEN 3
                    ELSE 4
                END AS week_num,
                SUM(aktivitas_sales.total_aktivitas_sales) AS week_result
            ')
            ->groupByRaw('aktivitas_sales.users_id, DATE_FORMAT(aktivitas_sales.tanggal_aktivitas_sales, "%Y-%m"), CASE WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 1 AND 7 THEN 1 WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 8 AND 14 THEN 2 WHEN DAY(aktivitas_sales.tanggal_aktivitas_sales) BETWEEN 15 AND 21 THEN 3 ELSE 4 END')
            ->get();

        $grid = [];
        $monthsList = [];
        $start = new \DateTime($tanggal_mulai);
        $end = new \DateTime($tanggal_selesai);
        $end->modify('last day of this month');
        for ($d = clone $start; $d <= $end; $d->modify('+1 month')) {
            $monthsList[] = [
                'key' => $d->format('Y-m'),
                'label' => strtoupper(substr(General::ubahDBKeBulan((int) $d->format('n')), 0, 3)),
            ];
        }
        $byUserMonth = [];
        foreach ($weekly as $w) {
            $key = $w->users_id . '-' . $w->month_key;
            if (!isset($byUserMonth[$key])) {
                $byUserMonth[$key] = ['users_id' => $w->users_id, 'month_key' => $w->month_key, 'total_result' => 0];
            }
            $byUserMonth[$key]['total_result'] += (float) $w->week_result;
        }
        foreach ($byUserMonth as $row) {
            $uid = $row['users_id'];
            $totalResult = (float) $row['total_result'];
            $totalTarget = $totalResult; // target = result (100%) kalau belum ada kolom target
            $achieved = $totalResult >= $totalTarget;
            $achievementPct = $totalTarget > 0 ? (int) round(min(100, ($totalResult / $totalTarget) * 100)) : 0;
            $notAchievedPct = 100 - $achievementPct;
            if (!isset($grid[$uid])) {
                $grid[$uid] = [];
            }
            $grid[$uid][$row['month_key']] = [
                'achieved_pct' => $achievementPct,
                'not_achieved_pct' => $notAchievedPct,
                'achieved' => $achieved,
                'total_result' => $totalResult,
                'total_target' => $totalTarget,
            ];
        }

        return [
            'cards' => $cards,
            'months' => $monthsList,
            'grid' => $grid,
        ];
    }

    /**
     * Dashboard evaluasi per unit per bulan: satu baris per (bulan, sales).
     * Return: [ 'units' => [ { id, name, rows: [ { month_key, month_label, name, rank, achievement_pct, visit_count, activities, definitive, cancellation, lost, w1_achieved..w4_achieved } ] } ] ]
     */
    private function getSalesAchievementDashboard($tanggal_mulai, $tanggal_selesai, $hasil_kata = '', $hasil_status_sales = '', $unit_kerjas_id = '', $laporanSections = [])
    {
        $base = DB::table('aktivitas_sales')
            ->join('users', 'aktivitas_sales.users_id', '=', 'users.id')
            ->leftJoin('master_unit_kerjas', function ($j) {
                $j->on('users.unit_kerjas_id', '=', 'master_unit_kerjas.id_unit_kerjas')
                  ->whereNull('master_unit_kerjas.deleted_at');
            })
            ->leftJoin('master_kegiatan_sales', 'aktivitas_sales.kegiatan_sales_id', '=', 'master_kegiatan_sales.id_kegiatan_sales')
            ->leftJoin('master_status_sales', 'aktivitas_sales.status_sales_id', '=', 'master_status_sales.id_status_sales')
            ->whereBetween('aktivitas_sales.tanggal_aktivitas_sales', [$tanggal_mulai, $tanggal_selesai]);

        if ($unit_kerjas_id !== '' && $unit_kerjas_id !== null) {
            $base->where('users.unit_kerjas_id', $unit_kerjas_id);
        }
        $base = $base
            ->select(
                'aktivitas_sales.users_id',
                'users.name',
                'users.unit_kerjas_id',
                'master_unit_kerjas.nama_unit_kerjas',
                'master_kegiatan_sales.nama_kegiatan_sales',
                'master_status_sales.nama_status_sales',
                'aktivitas_sales.tanggal_aktivitas_sales',
                'aktivitas_sales.total_aktivitas_sales'
            );

        if ($hasil_status_sales !== '' && $hasil_status_sales !== null) {
            $base->where('aktivitas_sales.status_sales_id', $hasil_status_sales);
        }
        if ($hasil_kata !== '' && $hasil_kata !== null) {
            $base->leftJoin('master_segmentasi_sales', 'aktivitas_sales.segmentasi_sales_id', '=', 'master_segmentasi_sales.id_segmentasi_sales')
                ->leftJoin('master_project_sales', 'aktivitas_sales.project_sales_id', '=', 'master_project_sales.id_project_sales');
            $this->applyLaporanKeywordFilter($base, $hasil_kata);
        }

        $rows = $base->get();
        $byUnit = [];
        foreach ($rows as $r) {
            $ukId = $r->unit_kerjas_id ?? '_null';
            $ukName = $r->nama_unit_kerjas ?: 'Lainnya';
            if (!isset($byUnit[$ukId])) {
                $byUnit[$ukId] = ['id' => $ukId, 'name' => $ukName, 'users' => []];
            }
            $uid = $r->users_id;
            if (!isset($byUnit[$ukId]['users'][$uid])) {
                $byUnit[$ukId]['users'][$uid] = [
                    'user_id' => $uid,
                    'name' => $r->name,
                    'visit_count' => 0,
                    'activities' => [],
                    'statuses' => [],
                    'months' => [],
                    'total_result' => 0,
                ];
            }
            $u = &$byUnit[$ukId]['users'][$uid];
            $u['visit_count']++;
            $u['total_result'] += (float) $r->total_aktivitas_sales;
            $keg = $r->nama_kegiatan_sales ?? 'Lainnya';
            $u['activities'][$keg] = ($u['activities'][$keg] ?? 0) + 1;
            $st = $r->nama_status_sales ?? 'Tanpa status';
            $u['statuses'][$st] = ($u['statuses'][$st] ?? 0) + 1;

            $tgl = $r->tanggal_aktivitas_sales;
            $monthKey = substr($tgl, 0, 7);
            $day = (int) substr($tgl, 8, 2);
            $week = $day <= 7 ? 1 : ($day <= 14 ? 2 : ($day <= 21 ? 3 : 4));
            if (!isset($u['months'][$monthKey])) {
                $u['months'][$monthKey] = [
                    'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0,
                    'visit' => 0, 'activities' => [], 'statuses' => [],
                ];
            }
            $u['months'][$monthKey]['w'.$week] += (float) $r->total_aktivitas_sales;
            $u['months'][$monthKey]['visit']++;
            $u['months'][$monthKey]['activities'][$keg] = ($u['months'][$monthKey]['activities'][$keg] ?? 0) + 1;
            $u['months'][$monthKey]['statuses'][$st] = ($u['months'][$monthKey]['statuses'][$st] ?? 0) + 1;
        }

        // Lookup dari laporan: (unit_name, month_key, name) -> total, w1, w2, w3, w4. Persen pakai data ini agar sama dengan tabel.
        $laporanLookup = [];
        foreach ($laporanSections as $sec) {
            $uName = $sec['unit_name'] ?? '';
            foreach ($sec['rows'] ?? [] as $lr) {
                $key = $uName . '|' . ($lr['month_key'] ?? '') . '|' . ($lr['name'] ?? '');
                $laporanLookup[$key] = [
                    'total' => (float)($lr['total'] ?? 0),
                    'w1' => (float)($lr['w1'] ?? 0),
                    'w2' => (float)($lr['w2'] ?? 0),
                    'w3' => (float)($lr['w3'] ?? 0),
                    'w4' => (float)($lr['w4'] ?? 0),
                ];
            }
        }

        $unitsOut = [];
        foreach ($byUnit as $ukId => $unit) {
            $rows = []; // flat: satu baris per (bulan, sales)
            foreach ($unit['users'] as $u) {
                foreach ($u['months'] as $mk => $w) {
                    $totalMonth = ($w['w1'] ?? 0) + ($w['w2'] ?? 0) + ($w['w3'] ?? 0) + ($w['w4'] ?? 0);
                    $targetWeek = $totalMonth > 0 ? $totalMonth / 4 : 0;
                    $monthLabel = General::ubahDBKeBulan((int) substr($mk, 5, 2)) . ' ' . substr($mk, 0, 4);
                    $def = 0; $cancel = 0; $lost = 0;
                    foreach ($w['statuses'] ?? [] as $stName => $cnt) {
                        $lower = strtolower($stName);
                        if (strpos($lower, 'definitive') !== false) $def += $cnt;
                        elseif (strpos($lower, 'cancel') !== false) $cancel += $cnt;
                        elseif (strpos($lower, 'lost') !== false) $lost += $cnt;
                    }
                    // Persen W1–W4 = (value minggu / total target) * 100. Pakai data LAPORAN agar sama persis dengan tabel.
                    $unitNameForKey = $unit['name'] === 'Lainnya' ? 'SALES TARGET' : $unit['name'];
                    $key = $unitNameForKey . '|' . $mk . '|' . $u['name'];
                    $laporanRow = $laporanLookup[$key] ?? $laporanLookup[$unit['name'] . '|' . $mk . '|' . $u['name']] ?? null;
                    // % Achieve = (result / total target) * 100, max 100%. Result = target → 100%.
                    $totalTarget = ($laporanRow && $laporanRow['total'] > 0) ? $laporanRow['total'] : $totalMonth;
                    $achievementPct = $totalTarget > 0 ? min(100, (int) round(($totalMonth / $totalTarget) * 100)) : 0;
                    if ($laporanRow && $laporanRow['total'] > 0) {
                        $tot = $laporanRow['total'];
                        $w1_pct = round(($laporanRow['w1'] / $tot) * 100, 2);
                        $w2_pct = round(($laporanRow['w2'] / $tot) * 100, 2);
                        $w3_pct = round(($laporanRow['w3'] / $tot) * 100, 2);
                        $w4_pct = round(($laporanRow['w4'] / $tot) * 100, 2);
                    } else {
                        $w1Val = (float)($w['w1'] ?? 0);
                        $w2Val = (float)($w['w2'] ?? 0);
                        $w3Val = (float)($w['w3'] ?? 0);
                        $w4Val = (float)($w['w4'] ?? 0);
                        $totalMonthF = (float) $totalMonth;
                        $w1_pct = $totalMonthF > 0 ? round(($w1Val / $totalMonthF) * 100, 2) : 0;
                        $w2_pct = $totalMonthF > 0 ? round(($w2Val / $totalMonthF) * 100, 2) : 0;
                        $w3_pct = $totalMonthF > 0 ? round(($w3Val / $totalMonthF) * 100, 2) : 0;
                        $w4_pct = $totalMonthF > 0 ? round(($w4Val / $totalMonthF) * 100, 2) : 0;
                    }
                    $rows[] = [
                        'month_key' => $mk,
                        'month_label' => $monthLabel,
                        'name' => $u['name'],
                        'user_id' => $u['user_id'],
                        'achievement_pct' => $achievementPct,
                        'visit_count' => $w['visit'] ?? 0,
                        'activities' => $w['activities'] ?? [],
                        'definitive' => $def,
                        'cancellation' => $cancel,
                        'lost' => $lost,
                        'w1_pct' => $w1_pct,
                        'w2_pct' => $w2_pct,
                        'w3_pct' => $w3_pct,
                        'w4_pct' => $w4_pct,
                        'total_month' => $totalMonth,
                    ];
                }
            }
            // Urut: bulan, lalu per bulan urut total_month tertinggi dulu (peringkat #1 = terbaik)
            usort($rows, function ($a, $b) {
                $c = strcmp($a['month_key'], $b['month_key']);
                if ($c !== 0) return $c;
                return (int)($b['total_month'] ?? 0) <=> (int)($a['total_month'] ?? 0);
            });
            $rank = 1;
            for ($i = 0; $i < count($rows); $i++) {
                if ($i === 0 || $rows[$i]['month_key'] !== $rows[$i - 1]['month_key']) {
                    $rank = 1;
                }
                $rows[$i]['rank'] = $rank++;
            }
            $unitsOut[] = [
                'id' => $unit['id'],
                'name' => $unit['name'],
                'rows' => $rows,
            ];
        }
        usort($unitsOut, function ($a, $b) { return strcmp($a['name'], $b['name']); });
        return ['units' => $unitsOut];
    }

    public function cetakexcel()
    {
        $link_laporan_aktivitas_sales = 'laporan_aktivitas_sales';
        if(General::hakAkses($link_laporan_aktivitas_sales,'cetak') == 'true')
        {
            $bulan_mulai        = date('m');
            if(session('hasil_bulan_mulai') != '')
                $bulan_mulai    = session('hasil_bulan_mulai');

            $tahun_mulai        = date('Y');
            if(session('hasil_tahun_mulai') != '')
                $tahun_mulai    = session('hasil_tahun_mulai');
            
            $bulan_selesai      = date('m');
            if(session('hasil_bulan_selesai') != '')
                $bulan_selesai  = session('hasil_bulan_selesai');

            $tahun_selesai      = date('Y');
            if(session('hasil_tahun_selesai') != '')
                $tahun_selesai  = session('hasil_tahun_selesai');

            $nama_file = 'laporan_aktivitas_sales-'.General::ubahDBKeBulan($bulan_mulai).' '.$tahun_mulai.' sampai '.General::ubahDBKeBulan($bulan_selesai).' '.$tahun_selesai.'.xlsx';
            return Excel::download(new LaporanAktivitasSalesExport, $nama_file);
        }
        else
            return redirect('dashboard/laporan_aktivitas_sales');
    }

}