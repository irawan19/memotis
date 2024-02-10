<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\General;
use App\Models\Aktivitas_sales;
use App\Models\Master_kegiatan_sales;
use App\Models\Master_segmentasi_sales;
use App\Models\Master_status_sales;
use App\Models\Master_project_sales;
use App\Models\User;

class LaporanAktivitasSalesExport implements FromView, ShouldQueue
{
    use Exportable;
    public function view(): View
    {
        $hasil_kata = '';
        if(session('hasil_kata') != '')
            $hasil_kata = session('hasil_kata');

        $hasil_bulan_mulai = date('m');
        if(session('hasil_bulan_mulai') != '')
            $hasil_bulan_mulai = session('hasil_bulan_mulai');
        
        $hasil_tahun_mulai = date('Y');
        if(session('hasil_tahun_mulai') != '')
            $hasil_tahun_mulai = session('hasil_tahun_mulai');

        $hasil_bulan_selesai = date('m');
        if(session('hasil_bulan_selesai') != '')
            $hasil_bulan_selesai = session('hasil_bulan_selesai');

        $hasil_tahun_selesai = date('m');
        if(session('hasil_tahun_selesai') != '')
            $hasil_tahun_selesai = session('hasil_tahun_selesai');

        $hasil_status_sales = '';
        if(session('hasil_status_sales') != '')
            $hasil_status_sales = session('hasil_status_sales');

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
        $data['hasil_bulan_mulai']  = $hasil_bulan_mulai;
        $data['hasil_tahun_mulai']  = $hasil_tahun_mulai;
        $data['hasil_bulan_selesai']= $hasil_bulan_selesai;
        $data['hasil_tahun_selesai']= $hasil_tahun_selesai;
        return view('dashboard.laporan_aktivitas_sales.cetakexcel', $data);
    }
}
