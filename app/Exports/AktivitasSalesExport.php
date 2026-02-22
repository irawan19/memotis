<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Helpers\General;
use App\Models\Aktivitas_sales;
use Illuminate\Support\Facades\Auth;

class AktivitasSalesExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $hasil_kata  = session('hasil_kata', '');
        $hasil_bulan = session('hasil_bulan', '');
        $hasil_tahun = session('hasil_tahun', '');

        $query = Aktivitas_sales::join('master_kegiatan_sales', 'aktivitas_sales.kegiatan_sales_id', '=', 'master_kegiatan_sales.id_kegiatan_sales')
            ->join('master_segmentasi_sales', 'aktivitas_sales.segmentasi_sales_id', '=', 'master_segmentasi_sales.id_segmentasi_sales')
            ->join('master_project_sales', 'aktivitas_sales.project_sales_id', '=', 'master_project_sales.id_project_sales')
            ->join('master_status_sales', 'aktivitas_sales.status_sales_id', '=', 'master_status_sales.id_status_sales')
            ->join('users', 'aktivitas_sales.users_id', '=', 'users.id')
            ->join('master_level_sistems', 'users.level_sistems_id', '=', 'master_level_sistems.id_level_sistems')
            ->leftJoin('master_divisis', 'master_level_sistems.divisis_id', '=', 'master_divisis.id_divisis')
            ->select(
                'aktivitas_sales.*',
                'master_kegiatan_sales.nama_kegiatan_sales',
                'master_segmentasi_sales.nama_segmentasi_sales',
                'master_project_sales.nama_project_sales',
                'master_status_sales.nama_status_sales',
                'users.name',
                'master_level_sistems.nama_level_sistems',
                'master_divisis.nama_divisis',
                'master_divisis.id_divisis'
            );

        if (Auth::user()->level_sistems_id != 1) {
            $query->where('aktivitas_sales.users_id', Auth::user()->id);
        }
        if ($hasil_kata !== '') {
            $query->where(function ($q) use ($hasil_kata) {
                $q->where('master_kegiatan_sales.nama_kegiatan_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('master_segmentasi_sales.nama_segmentasi_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('aktivitas_sales.nama_aktivitas_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('aktivitas_sales.pic_aktivitas_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('aktivitas_sales.kontak_personal_aktivitas_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('master_project_sales.nama_project_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('master_status_sales.nama_status_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('aktivitas_sales.jangka_waktu_aktivitas_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('aktivitas_sales.total_aktivitas_sales', 'LIKE', '%' . $hasil_kata . '%')
                    ->orWhere('aktivitas_sales.catatan_aktivitas_sales', 'LIKE', '%' . $hasil_kata . '%');
            });
        }
        if ($hasil_bulan !== '' && $hasil_tahun !== '') {
            $query->whereMonth('aktivitas_sales.tanggal_aktivitas_sales', (int) $hasil_bulan)
                ->whereYear('aktivitas_sales.tanggal_aktivitas_sales', (int) $hasil_tahun);
        }

        $data['lihat_aktivitas_sales'] = $query->orderBy('aktivitas_sales.tanggal_aktivitas_sales', 'desc')->get();
        $data['is_admin'] = (Auth::user()->level_sistems_id == 1);

        return view('dashboard.aktivitas_sales.cetakexcel', $data);
    }
}
