<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Karyawan;

class KaryawanExport implements FromView, ShouldQueue
{
    use Exportable;
    public function view(): View
    {
        $hasil_unit_kerja = '';
        if (!empty(session('hasil_unit_kerja')))
            $hasil_unit_kerja = session('hasil_unit_kerja');

        $hasil_kata = '';
        if (!empty(session('hasil_kata')))
            $hasil_kata = session('hasil_kata');

        if ($hasil_unit_kerja == '') {
            $data['lihat_karyawans'] = Karyawan::join('master_jabatans', 'karyawans.jabatans_id', '=', 'master_jabatans.id_jabatans')
                ->join('master_unit_kerjas', 'karyawans.unit_kerjas_id', '=', 'master_unit_kerjas.id_unit_kerjas')
                ->join('master_jenis_kelamins', 'karyawans.jenis_kelamins_id', '=', 'master_jenis_kelamins.id_jenis_kelamins')
                ->join('master_agamas', 'karyawans.agamas_id', '=', 'master_agamas.id_agamas')
                ->join('master_status_kawins', 'karyawans.status_kawins_id', '=', 'master_status_kawins.id_status_kawins')
                ->join('master_pendidikans', 'karyawans.pendidikans_id', '=', 'master_pendidikans.id_pendidikans')
                ->where('nama_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('nik_gys_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('nik_tg_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('band_posisi_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('ktp_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('tempat_lahir_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('nama_jenis_kelamins', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('nama_agamas', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('alamat_rumah_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('nama_status_kawins', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('nama_pendidikans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('institusi_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('hobi_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('keahlian_khusus_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('no_hp_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('email_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orderBy('nama_karyawans')
                ->get();
        } else {
            $data['lihat_karyawans'] = Karyawan::join('master_jabatans', 'karyawans.jabatans_id', '=', 'master_jabatans.id_jabatans')
                ->join('master_unit_kerjas', 'karyawans.unit_kerjas_id', '=', 'master_unit_kerjas.id_unit_kerjas')
                ->join('master_jenis_kelamins', 'karyawans.jenis_kelamins_id', '=', 'master_jenis_kelamins.id_jenis_kelamins')
                ->join('master_agamas', 'karyawans.agamas_id', '=', 'master_agamas.id_agamas')
                ->join('master_status_kawins', 'karyawans.status_kawins_id', '=', 'master_status_kawins.id_status_kawins')
                ->join('master_pendidikans', 'karyawans.pendidikans_id', '=', 'master_pendidikans.id_pendidikans')
                ->where('nama_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('nik_gys_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('nik_tg_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('band_posisi_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->orWhere('ktp_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('tempat_lahir_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('nama_jenis_kelamins', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('nama_agamas', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('alamat_rumah_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('nama_status_kawins', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('nama_pendidikans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('institusi_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('hobi_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('keahlian_khusus_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('no_hp_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orWhere('email_karyawans', 'LIKE', '%' . $hasil_kata . '%')
                ->where('unit_kerjas_id', $hasil_unit_kerja)
                ->orderBy('nama_karyawans')
                ->get();
        }
        return view('dashboard.karyawan.cetakexcel', $data);
    }
}