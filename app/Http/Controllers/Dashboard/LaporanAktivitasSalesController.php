<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
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
            $hasil_tanggal_mulai                        = $hasil_tahun_mulai.'-'.$hasil_bulan_mulai.'-01';
            $hasil_tanggal_selesai                      = $hasil_tahun_selesai.'-'.$hasil_bulan_selesai.'-'.General::tanggalTerakhir($hasil_tahun_selesai, $hasil_bulan_selesai);
            $data['lihat_laporan_aktivitas_sales']    	= Aktivitas_sales::selectRaw('*,
                                                                                    SUM(total_aktivitas_sales) AS total')
                                                                        ->join('master_kegiatan_sales','kegiatan_sales_id','=','master_kegiatan_sales.id_kegiatan_sales')
                                                                        ->join('master_segmentasi_sales','segmentasi_sales_id','=','master_segmentasi_sales.id_segmentasi_sales')
                                                                        ->join('master_project_sales','project_sales_id','=','master_project_sales.id_project_sales')
                                                                        ->join('master_status_sales','status_sales_id','=','master_status_sales.id_status_sales')
                                                                        ->join('users','users_id','=','users.id')
                                                                        ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                                        ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                        ->whereRaw('tanggal_aktivitas_sales >= "'.$hasil_tanggal_mulai.'" AND tanggal_aktivitas_sales <= "'.$hasil_tanggal_selesai.'"')
                                                                        ->groupByRaw('users_id, segmentasi_sales_id, project_sales_id, status_sales_id')
                                                                        ->orderBy('tanggal_aktivitas_sales','desc')
                                                                        ->get();
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
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $hasil_bulan_mulai                      = $request->cari_bulan_mulai;
            $data['hasil_bulan_mulai']              = $hasil_bulan_mulai;
            $hasil_tahun_mulai                      = $request->cari_tahun_mulai;
            $data['hasil_tahun_mulai']              = $hasil_tahun_mulai;
            $hasil_bulan_selesai                    = $request->cari_bulan_selesai;
            $data['hasil_bulan_selesai']            = $hasil_bulan_selesai;
            $hasil_tahun_selesai                    = $request->cari_tahun_selesai;
            $data['hasil_tahun_selesai']            = $hasil_tahun_selesai;
            $data['lihat_status_sales']             = Master_status_sales::orderBy('nama_status_sales')->get();
            $hasil_status_sales                     = $request->cari_status_sales;
            $data['hasil_status_sales']             = $hasil_status_sales;
            $hasil_tanggal_mulai                    = $hasil_tahun_mulai.'-'.$hasil_bulan_mulai.'-01';
            $hasil_tanggal_selesai                  = $hasil_tahun_selesai.'-'.$hasil_bulan_selesai.'-'.General::tanggalTerakhir($hasil_tahun_selesai, $hasil_bulan_selesai);
            if($hasil_status_sales == '')
            {
                $data['lihat_laporan_aktivitas_sales']  = Aktivitas_sales::selectRaw('*,
                                                                                    SUM(total_aktivitas_sales) AS total')
                                                                        ->join('master_kegiatan_sales','kegiatan_sales_id','=','master_kegiatan_sales.id_kegiatan_sales')
                                                                        ->join('master_segmentasi_sales','segmentasi_sales_id','=','master_segmentasi_sales.id_segmentasi_sales')
                                                                        ->join('master_project_sales','project_sales_id','=','master_project_sales.id_project_sales')
                                                                        ->join('master_status_sales','status_sales_id','=','master_status_sales.id_status_sales')
                                                                        ->join('users','users_id','=','users.id')
                                                                        ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                                        ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                        ->where('users.name', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->whereRaw('tanggal_aktivitas_sales >= "'.$hasil_tanggal_mulai.'" AND tanggal_aktivitas_sales <= "'.$hasil_tanggal_selesai.'"')
                                                                        ->orWhere('nama_segmentasi_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->whereRaw('tanggal_aktivitas_sales >= "'.$hasil_tanggal_mulai.'" AND tanggal_aktivitas_sales <= "'.$hasil_tanggal_selesai.'"')
                                                                        ->orWhere('nama_project_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->whereRaw('tanggal_aktivitas_sales >= "'.$hasil_tanggal_mulai.'" AND tanggal_aktivitas_sales <= "'.$hasil_tanggal_selesai.'"')
                                                                        ->groupByRaw('users_id, segmentasi_sales_id, project_sales_id, status_sales_id')
                                                                        ->orderBy('tanggal_aktivitas_sales','desc')
                                                                        ->get();
            } else {
                $data['lihat_laporan_aktivitas_sales']  = Aktivitas_sales::selectRaw('*,
                                                                                    SUM(total_aktivitas_sales) AS total')
                                                                        ->join('master_kegiatan_sales','kegiatan_sales_id','=','master_kegiatan_sales.id_kegiatan_sales')
                                                                        ->join('master_segmentasi_sales','segmentasi_sales_id','=','master_segmentasi_sales.id_segmentasi_sales')
                                                                        ->join('master_project_sales','project_sales_id','=','master_project_sales.id_project_sales')
                                                                        ->join('master_status_sales','status_sales_id','=','master_status_sales.id_status_sales')
                                                                        ->join('users','users_id','=','users.id')
                                                                        ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                                        ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                        ->where('users.name', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->whereRaw('tanggal_aktivitas_sales >= "'.$hasil_tanggal_mulai.'" AND tanggal_aktivitas_sales <= "'.$hasil_tanggal_selesai.'"')
                                                                        ->where('status_sales_id','=',$hasil_status_sales)
                                                                        ->orWhere('nama_segmentasi_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->whereRaw('tanggal_aktivitas_sales >= "'.$hasil_tanggal_mulai.'" AND tanggal_aktivitas_sales <= "'.$hasil_tanggal_selesai.'"')
                                                                        ->where('status_sales_id','=',$hasil_status_sales)
                                                                        ->orWhere('nama_project_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                        ->whereRaw('tanggal_aktivitas_sales >= "'.$hasil_tanggal_mulai.'" AND tanggal_aktivitas_sales <= "'.$hasil_tanggal_selesai.'"')
                                                                        ->where('status_sales_id','=',$hasil_status_sales)
                                                                        ->groupByRaw('users_id, segmentasi_sales_id, project_sales_id, status_sales_id')
                                                                        ->orderBy('tanggal_aktivitas_sales','desc')
                                                                        ->get();
            }
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
                $tahun_selesai  = session('hasil_tahun_selesai');
            
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