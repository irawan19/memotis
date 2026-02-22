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
            $data['hasil_status_sales']                 = '';
            $hari_terakhir                               = General::tanggalTerakhir((int) $hasil_tahun_selesai, (int) $hasil_bulan_selesai);
            $hasil_tanggal_mulai                        = sprintf('%04d-%02d-01', (int) $hasil_tahun_mulai, (int) $hasil_bulan_mulai);
            $hasil_tanggal_selesai                      = sprintf('%04d-%02d-%02d', (int) $hasil_tahun_selesai, (int) $hasil_bulan_selesai, $hari_terakhir);
            $data['lihat_laporan_aktivitas_sales']      = $this->getLaporanAggregasi($hasil_tanggal_mulai, $hasil_tanggal_selesai, '', '');
            $data['hasil_tanggal_mulai']                = $hasil_tanggal_mulai;
            $data['hasil_tanggal_selesai']              = $hasil_tanggal_selesai;
            session()->forget('halaman');
            session()->forget('hasil_bulan_mulai');
            session()->forget('hasil_tahun_mulai');
            session()->forget('hasil_bulan_selesai');
            session()->forget('hasil_tahun_selesai');
            session()->forget('hasil_status_sales');
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
            $hasil_kata                             = $request->get('cari_kata', '');
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
            $hasil_status_sales                     = $request->get('cari_status_sales', '');
            $data['hasil_status_sales']             = $hasil_status_sales;

            $hari_terakhir_selesai = General::tanggalTerakhir($hasil_tahun_selesai, $hasil_bulan_selesai);
            $hasil_tanggal_mulai   = sprintf('%04d-%02d-01', $hasil_tahun_mulai, $hasil_bulan_mulai);
            $hasil_tanggal_selesai = sprintf('%04d-%02d-%02d', $hasil_tahun_selesai, $hasil_bulan_selesai, $hari_terakhir_selesai);

            $data['lihat_laporan_aktivitas_sales']  = $this->getLaporanAggregasi($hasil_tanggal_mulai, $hasil_tanggal_selesai, $hasil_kata, $hasil_status_sales);
            $data['hasil_tanggal_mulai']            = $hasil_tanggal_mulai;
            $data['hasil_tanggal_selesai']          = $hasil_tanggal_selesai;
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            session(['hasil_bulan_mulai'    => $hasil_bulan_mulai]);
            session(['hasil_tahun_mulai'    => $hasil_tahun_mulai]);
            session(['hasil_bulan_selesai'  => $hasil_bulan_selesai]);
            session(['hasil_tahun_selesai'  => $hasil_tahun_selesai]);
            session(['hasil_status_sales'   => $hasil_status_sales]);
        	return view('dashboard.laporan_aktivitas_sales.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    /**
     * Agregasi aktivitas sales per user (dan per unit kerja untuk section).
     * Return: [ ['unit_name' => '...', 'rows' => [ ['name' => '...', 'total' => ...], ... ] ], ... ]
     */
    private function getLaporanAggregasi($tanggal_mulai, $tanggal_selesai, $hasil_kata = '', $hasil_status_sales = '')
    {
        $query = DB::table('aktivitas_sales')
            ->selectRaw('
                users.unit_kerjas_id,
                master_unit_kerjas.nama_unit_kerjas,
                aktivitas_sales.users_id,
                users.name,
                SUM(aktivitas_sales.total_aktivitas_sales) AS total
            ')
            ->join('users', 'aktivitas_sales.users_id', '=', 'users.id')
            ->leftJoin('master_unit_kerjas', function ($j) {
                $j->on('users.unit_kerjas_id', '=', 'master_unit_kerjas.id_unit_kerjas')
                  ->whereNull('master_unit_kerjas.deleted_at');
            })
            ->whereBetween('aktivitas_sales.tanggal_aktivitas_sales', [$tanggal_mulai, $tanggal_selesai])
            ->groupBy('users.unit_kerjas_id', 'master_unit_kerjas.nama_unit_kerjas', 'aktivitas_sales.users_id', 'users.name')
            ->orderByRaw('COALESCE(master_unit_kerjas.nama_unit_kerjas, \'zzz\')')
            ->orderBy('users.name');

        if ($hasil_status_sales !== '' && $hasil_status_sales !== null) {
            $query->where('aktivitas_sales.status_sales_id', $hasil_status_sales);
        }
        if ($hasil_kata !== '' && $hasil_kata !== null) {
            $query->join('master_segmentasi_sales', 'aktivitas_sales.segmentasi_sales_id', '=', 'master_segmentasi_sales.id_segmentasi_sales')
                ->join('master_project_sales', 'aktivitas_sales.project_sales_id', '=', 'master_project_sales.id_project_sales')
                ->where(function ($q) use ($hasil_kata) {
                    $q->where('users.name', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_segmentasi_sales.nama_segmentasi_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_project_sales.nama_project_sales', 'LIKE', '%'.$hasil_kata.'%');
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
            $sections[$ukId]['rows'][] = ['name' => $r->name, 'total' => (float) $r->total];
        }
        return array_values($sections);
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

            return Excel::download(new LaporanAktivitasSalesExport, 'laporan_aktivitas_sales-'.General::ubahDBKeBulan($bulan_mulai).' '.$tahun_mulai.' sampai '.General::ubahDBKeBulan($bulan_mulai).' '.$tahun_selesai.'.xlsx');
        }
        else
            return redirect('dashboard/laporan_aktivitas_sales');
    }

}