<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\Master_status_karyawan;
use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Karyawan;
use App\Models\Master_jabatan;
use App\Models\Master_unit_kerja;
use App\Models\Master_jenis_kelamin;
use App\Models\Master_agama;
use App\Models\Master_status_kawin;
use App\Models\Master_pendidikan;
use Storage;
use Auth;
use App\Exports\KaryawanExport;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'lihat') == 'true')
        {
            $data['link_karyawan']          = $link_karyawan;
            $data['hasil_kata']             = '';
            $data['hasil_unit_kerja']       = '';
            $url_sekarang                   = $request->fullUrl();
            $data['lihat_unit_kerjas']      = Master_unit_kerja::orderBy('nama_unit_kerjas','asc')->get();
        	$data['lihat_karyawans']    	= Karyawan::join('master_jabatans','karyawans.jabatans_id','=','master_jabatans.id_jabatans')
                                                        ->join('master_unit_kerjas','karyawans.unit_kerjas_id','=','master_unit_kerjas.id_unit_kerjas')
                                                        ->join('master_jenis_kelamins','karyawans.jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                        ->join('master_agamas','karyawans.agamas_id','=','master_agamas.id_agamas')
                                                        ->join('master_status_kawins','karyawans.status_kawins_id','=','master_status_kawins.id_status_kawins')
                                                        ->join('master_pendidikans','karyawans.pendidikans_id','=','master_pendidikans.id_pendidikans')
                                                        ->join('master_status_karyawans','karyawans.status_karyawans_id','=','master_status_karyawans.id_status_karyawans')
                                                        ->orderBy('nama_karyawans')
                                                        ->paginate(25);
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session()->forget('hasil_unit_kerja');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.karyawan.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'lihat') == 'true')
        {
            $data['link_karyawan']          = $link_karyawan;
            $url_sekarang                   = $request->fullUrl();
            $hasil_kata                     = $request->cari_kata;
            $data['hasil_kata']             = $hasil_kata;
            $data['lihat_unit_kerjas']      = Master_unit_kerja::orderBy('nama_unit_kerjas','asc')->get();
            $hasil_unit_kerja               = $request->cari_unit_kerja;
            $data['hasil_unit_kerja']       = $hasil_unit_kerja;
            if($hasil_unit_kerja == '')
            {
                $data['lihat_karyawans']    	= Karyawan::join('master_jabatans','karyawans.jabatans_id','=','master_jabatans.id_jabatans')
                                                            ->join('master_unit_kerjas','karyawans.unit_kerjas_id','=','master_unit_kerjas.id_unit_kerjas')
                                                            ->join('master_jenis_kelamins','karyawans.jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                            ->join('master_agamas','karyawans.agamas_id','=','master_agamas.id_agamas')
                                                            ->join('master_status_kawins','karyawans.status_kawins_id','=','master_status_kawins.id_status_kawins')
                                                            ->join('master_pendidikans','karyawans.pendidikans_id','=','master_pendidikans.id_pendidikans')
                                                            ->join('master_status_karyawans','karyawans.status_karyawans_id','=','master_status_karyawans.id_status_karyawans')
                                                            ->where('nama_jabatans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('nama_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('nik_gys_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('nik_tg_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('band_posisi_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('npwp_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('ktp_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('tempat_lahir_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('nama_jenis_kelamins', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('nama_agamas', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('alamat_domisili_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('nama_status_kawins', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('nama_pendidikans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('institusi_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('hobi_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('keahlian_khusus_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('no_hp_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orWhere('email_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->orderBy('nama_karyawans')
                                                            ->paginate(25);
            }
            else
            {
                $data['lihat_karyawans']    	= Karyawan::join('master_jabatans','karyawans.jabatans_id','=','master_jabatans.id_jabatans')
                                                            ->join('master_unit_kerjas','karyawans.unit_kerjas_id','=','master_unit_kerjas.id_unit_kerjas')
                                                            ->join('master_jenis_kelamins','karyawans.jenis_kelamins_id','=','master_jenis_kelamins.id_jenis_kelamins')
                                                            ->join('master_agamas','karyawans.agamas_id','=','master_agamas.id_agamas')
                                                            ->join('master_status_kawins','karyawans.status_kawins_id','=','master_status_kawins.id_status_kawins')
                                                            ->join('master_pendidikans','karyawans.pendidikans_id','=','master_pendidikans.id_pendidikans')
                                                            ->join('master_status_karyawans','karyawans.status_karyawans_id','=','master_status_karyawans.id_status_karyawans')
                                                            
                                                            ->where('nama_jabatans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('nama_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('nik_gys_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('nik_tg_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('band_posisi_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('npwp_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('ktp_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('tempat_lahir_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('nama_jenis_kelamins', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('nama_agamas', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('alamat_domisili_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('nama_status_kawins', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('nama_pendidikans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('institusi_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('hobi_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('keahlian_khusus_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('no_hp_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)
                                                            
                                                            ->orWhere('email_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                            ->where('id_unit_kerjas',$hasil_unit_kerja)

                                                            ->orderBy('nama_karyawans')
                                                            ->paginate(25);
            }
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            session(['hasil_unit_kerja'     => $hasil_unit_kerja]);
            return view('dashboard.karyawan.lihat', $data);
        }
        else
            return redirect('dashboard/karyawan');
    }

    public function tambah()
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'tambah') == 'true')
        {
            $data['tambah_jabatans']        = Master_jabatan::orderBy('nama_jabatans')->get();
            $data['tambah_unit_kerjas']     = Master_unit_kerja::orderBy('nama_unit_kerjas')->get();
            $data['tambah_jenis_kelamins']  = Master_jenis_kelamin::orderBy('nama_jenis_kelamins')->get();
            $data['tambah_agamas']          = Master_agama::orderBy('nama_agamas')->get();
            $data['tambah_status_kawins']   = Master_status_kawin::orderBy('nama_status_kawins')->get();
            $data['tambah_pendidikans']     = Master_pendidikan::orderBy('nama_pendidikans')->get();
            $data['tambah_status_karyawans']= Master_status_karyawan::orderBy('nama_status_karyawans')->get();
            return view('dashboard.karyawan.tambah',$data);
        }
        else
            return redirect('dashboard/karyawan');
    }

    public function prosestambah(Request $request)
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'tambah') == 'true')
        {
            $aturan = [
                'jabatans_id'                   => 'required',
                'unit_kerjas_id'                => 'required',
                'jenis_kelamins_id'             => 'required',
                'agamas_id'                     => 'required',
                'status_kawins_id'              => 'required',
                'pendidikans_id'                => 'required',
                'status_karyawans_id'           => 'required', 
                'nama_karyawans'                => 'required',
                'ktp_karyawans'                 => 'required',
                'tanggal_bergabung_karyawans'   => 'required',
            ];
            $this->validate($request, $aturan);

            $nik_gys_karyawans = '';
            if(!empty($request->nik_gys_karyawans))
                $nik_gys_karyawans = $request->nik_gys_karyawans;

            $nik_tg_karyawans = '';
            if(!empty($request->nik_tg_karyawans))
                $nik_tg_karyawans = $request->nik_tg_karyawans;

            $band_posisi_karyawans = '';
            if(!empty($request->band_posisi_karyawans))
                $band_posisi_karyawans = $request->band_posisi_karyawans;

            $tanggal_keluar_karyawans = null;
            if(!empty($request->tanggal_keluar_karyawans))
                $tanggal_keluar_karyawans = General::ubahTanggalKeDB($request->tanggal_keluar_karyawans);

            $tanggal_lahir_karyawans = null;
            if(!empty($request->tanggal_lahir_karyawans))
                $tanggal_lahir_karyawans = General::ubahTanggalKeDB($request->tanggal_lahir_karyawans);

            $tempat_lahir_karyawans = '';
            if(!empty($request->tempat_lahir_karyawans))
                $tempat_lahir_karyawans = $request->tempat_lahir_karyawans;

            $alamat_domisili_karyawans = '';
            if(!empty($request->alamat_domisili_karyawans))
                $alamat_domisili_karyawans = $request->alamat_domisili_karyawans;

            $institusi_karyawans = '';
            if(!empty($request->institusi_karyawans))
                $institusi_karyawans = $request->institusi_karyawans;

            $hobi_karyawans = '';
            if(!empty($request->hobi_karyawans))
                $hobi_karyawans = $request->hobi_karyawans;

            $keahlian_khusus_karyawans = '';
            if(!empty($request->keahlian_khusus_karyawans))
                $keahlian_khusus_karyawans = $request->keahlian_khusus_karyawans;
            
            $no_hp_karyawans = '';
            if(!empty($request->no_hp_karyawans))
                $no_hp_karyawans = $request->no_hp_karyawans;

            $email_karyawans = '';
            if(!empty($request->email_karyawans))
                $email_karyawans = $request->email_karyawans;

            $npwp_karyawans = '';
            if(!empty($request->npwp_karyawans))
                $npwp_karyawans = $request->npwp_karyawans;

            if(!empty($request->userfile_foto_karyawan))
            {
                $aturan = [
                    'userfile_foto_karyawan'    => 'required|mimes:png,jpg,jpeg',
                ];
                $this->validate($request, $aturan);

                $nama_foto_karyawan = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_foto_karyawan')->getClientOriginalName())));
                $path_foto_karyawan = 'karyawan/';
                Storage::disk('public')->put($path_foto_karyawan.$nama_foto_karyawan, file_get_contents($request->file('userfile_foto_karyawan')));

                $data = [
                    'users_id'                      => Auth::user()->id,
                    'jabatans_id'                   => $request->jabatans_id,
                    'unit_kerjas_id'                => $request->unit_kerjas_id,
                    'jenis_kelamins_id'             => $request->jenis_kelamins_id,
                    'agamas_id'                     => $request->agamas_id,
                    'status_kawins_id'              => $request->status_kawins_id,
                    'pendidikans_id'                => $request->pendidikans_id,
                    'status_karyawans_id'           => $request->status_karyawans_id,
                    'nama_karyawans'                => $request->nama_karyawans,
                    'foto_karyawans'                => $path_foto_karyawan.$nama_foto_karyawan,
                    'nik_gys_karyawans'             => $nik_gys_karyawans,
                    'nik_tg_karyawans'              => $nik_tg_karyawans,
                    'band_posisi_karyawans'         => $band_posisi_karyawans,
                    'tanggal_bergabung_karyawans'   => General::ubahTanggalKeDB($request->tanggal_bergabung_karyawans),
                    'tanggal_keluar_karyawans'      => $tanggal_keluar_karyawans,
                    'tanggal_lahir_karyawans'       => $tanggal_lahir_karyawans,
                    'tempat_lahir_karyawans'        => $tempat_lahir_karyawans,
                    'alamat_domisili_karyawans'        => $alamat_domisili_karyawans,
                    'institusi_karyawans'           => $institusi_karyawans,
                    'hobi_karyawans'                => $hobi_karyawans,
                    'keahlian_khusus_karyawans'     => $keahlian_khusus_karyawans,
                    'no_hp_karyawans'               => $no_hp_karyawans,
                    'email_karyawans'               => $email_karyawans,
                    'ktp_karyawans'                 => $request->ktp_karyawans,
                    'npwp_karyawans'                => $npwp_karyawans,
                    'created_at'                    => date('Y-m-d H:i:s'),
                ];
            }
            else
            {
                $data = [
                    'users_id'                      => Auth::user()->id,
                    'jabatans_id'                   => $request->jabatans_id,
                    'unit_kerjas_id'                => $request->unit_kerjas_id,
                    'jenis_kelamins_id'             => $request->jenis_kelamins_id,
                    'agamas_id'                     => $request->agamas_id,
                    'status_kawins_id'              => $request->status_kawins_id,
                    'pendidikans_id'                => $request->pendidikans_id,
                    'status_karyawans_id'           => $request->status_karyawans_id,
                    'nama_karyawans'                => $request->nama_karyawans,
                    'foto_karyawans'                => 'karyawan/default/default.png',
                    'nik_gys_karyawans'             => $nik_gys_karyawans,
                    'nik_tg_karyawans'              => $nik_tg_karyawans,
                    'band_posisi_karyawans'         => $band_posisi_karyawans,
                    'tanggal_bergabung_karyawans'   => General::ubahTanggalKeDB($request->tanggal_bergabung_karyawans),
                    'tanggal_keluar_karyawans'      => $tanggal_keluar_karyawans,
                    'tanggal_lahir_karyawans'       => $tanggal_lahir_karyawans,
                    'tempat_lahir_karyawans'        => $tempat_lahir_karyawans,
                    'alamat_domisili_karyawans'        => $alamat_domisili_karyawans,
                    'institusi_karyawans'           => $institusi_karyawans,
                    'hobi_karyawans'                => $hobi_karyawans,
                    'keahlian_khusus_karyawans'     => $keahlian_khusus_karyawans,
                    'no_hp_karyawans'               => $no_hp_karyawans,
                    'email_karyawans'               => $email_karyawans,
                    'ktp_karyawans'                 => $request->ktp_karyawans,
                    'npwp_karyawans'                => $npwp_karyawans,
                    'created_at'                    => date('Y-m-d H:i:s'),
                ];
            }
            Karyawan::insert($data);

            $simpan           = $request->simpan;
            $simpan_kembali   = $request->simpan_kembali;
            if($simpan)
            {
                $setelah_simpan = [
                    'alert'  => 'sukses',
                    'text'   => 'Data berhasil ditambahkan',
                ];
    	    	return redirect()->back()->with('setelah_simpan', $setelah_simpan)->withInput($request->all());
            }
            if($simpan_kembali)
            {
                if(request()->session()->get('halaman') != '')
                    $redirect_halaman  = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/karyawan';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/karyawan');
    }

    public function edit($id_karyawans=0)
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'edit') == 'true')
        {
            $cek_karyawans = Karyawan::where('id_karyawans',$id_karyawans)->count();
            if($cek_karyawans != 0)
            {
                $data['edit_jabatans']          = Master_jabatan::orderBy('nama_jabatans')->get();
                $data['edit_unit_kerjas']       = Master_unit_kerja::orderBy('nama_unit_kerjas')->get();
                $data['edit_jenis_kelamins']    = Master_jenis_kelamin::orderBy('nama_jenis_kelamins')->get();
                $data['edit_agamas']            = Master_agama::orderBy('nama_agamas')->get();
                $data['edit_status_kawins']     = Master_status_kawin::orderBy('nama_status_kawins')->get();
                $data['edit_pendidikans']       = Master_pendidikan::orderBy('nama_pendidikans')->get();
                $data['edit_status_karyawans']  = Master_status_karyawan::orderBy('nama_status_karyawans')->get();
                $data['edit_karyawans']         = Karyawan::where('id_karyawans',$id_karyawans)
                                                            ->first();
                return view('dashboard.karyawan.edit',$data);
            }
            else
                return redirect('dashboard/karyawan');
        }
        else
            return redirect('dashboard/karyawan');
    }

    public function prosesedit($id_karyawans=0, Request $request)
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'edit') == 'true')
        {
            $cek_karyawans = Karyawan::where('id_karyawans',$id_karyawans)->first();
            if(!empty($cek_karyawans))
            {
                $aturan = [
                    'jabatans_id'                   => 'required',
                    'unit_kerjas_id'                => 'required',
                    'jenis_kelamins_id'             => 'required',
                    'agamas_id'                     => 'required',
                    'status_kawins_id'              => 'required',
                    'pendidikans_id'                => 'required',
                    'status_karyawans_id'           => 'required', 
                    'nama_karyawans'                => 'required',
                    'ktp_karyawans'                 => 'required',
                    'tanggal_bergabung_karyawans'   => 'required',
                ];
                $this->validate($request, $aturan);
    
                $nik_gys_karyawans = '';
                if(!empty($request->nik_gys_karyawans))
                    $nik_gys_karyawans = $request->nik_gys_karyawans;
    
                $nik_tg_karyawans = '';
                if(!empty($request->nik_tg_karyawans))
                    $nik_tg_karyawans = $request->nik_tg_karyawans;
    
                $band_posisi_karyawans = '';
                if(!empty($request->band_posisi_karyawans))
                    $band_posisi_karyawans = $request->band_posisi_karyawans;
    
                $tanggal_keluar_karyawans = null;
                if(!empty($request->tanggal_keluar_karyawans))
                    $tanggal_keluar_karyawans = General::ubahTanggalKeDB($request->tanggal_keluar_karyawans);
    
                $tanggal_lahir_karyawans = null;
                if(!empty($request->tanggal_lahir_karyawans))
                    $tanggal_lahir_karyawans = General::ubahTanggalKeDB($request->tanggal_lahir_karyawans);
    
                $tempat_lahir_karyawans = '';
                if(!empty($request->tempat_lahir_karyawans))
                    $tempat_lahir_karyawans = $request->tempat_lahir_karyawans;
    
                $alamat_domisili_karyawans = '';
                if(!empty($request->alamat_domisili_karyawans))
                    $alamat_domisili_karyawans = $request->alamat_domisili_karyawans;
    
                $institusi_karyawans = '';
                if(!empty($request->institusi_karyawans))
                    $institusi_karyawans = $request->institusi_karyawans;
    
                $hobi_karyawans = '';
                if(!empty($request->hobi_karyawans))
                    $hobi_karyawans = $request->hobi_karyawans;
    
                $keahlian_khusus_karyawans = '';
                if(!empty($request->keahlian_khusus_karyawans))
                    $keahlian_khusus_karyawans = $request->keahlian_khusus_karyawans;
                
                $no_hp_karyawans = '';
                if(!empty($request->no_hp_karyawans))
                    $no_hp_karyawans = $request->no_hp_karyawans;
    
                $email_karyawans = '';
                if(!empty($request->email_karyawans))
                    $email_karyawans = $request->email_karyawans;
    
                $npwp_karyawans = '';
                if(!empty($request->npwp_karyawans))
                    $npwp_karyawans = $request->npwp_karyawans;
    
                if(!empty($request->userfile_foto_karyawan))
                {
                    $aturan = [
                        'userfile_foto_karyawan'    => 'required|mimes:png,jpg,jpeg',
                    ];
                    $this->validate($request, $aturan);
    
                    $nama_foto_karyawan = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('userfile_foto_karyawan')->getClientOriginalName())));
                    $path_foto_karyawan = 'karyawan/';
                    Storage::disk('public')->put($path_foto_karyawan.$nama_foto_karyawan, file_get_contents($request->file('userfile_foto_karyawan')));
    
                    $data = [
                        'users_id'                      => Auth::user()->id,
                        'jabatans_id'                   => $request->jabatans_id,
                        'unit_kerjas_id'                => $request->unit_kerjas_id,
                        'jenis_kelamins_id'             => $request->jenis_kelamins_id,
                        'agamas_id'                     => $request->agamas_id,
                        'status_kawins_id'              => $request->status_kawins_id,
                        'pendidikans_id'                => $request->pendidikans_id,
                        'status_karyawans_id'           => $request->status_karyawans_id,
                        'nama_karyawans'                => $request->nama_karyawans,
                        'foto_karyawans'                => $path_foto_karyawan.$nama_foto_karyawan,
                        'nik_gys_karyawans'             => $nik_gys_karyawans,
                        'nik_tg_karyawans'              => $nik_tg_karyawans,
                        'band_posisi_karyawans'         => $band_posisi_karyawans,
                        'tanggal_bergabung_karyawans'   => General::ubahTanggalKeDB($request->tanggal_bergabung_karyawans),
                        'tanggal_keluar_karyawans'      => $tanggal_keluar_karyawans,
                        'tanggal_lahir_karyawans'       => $tanggal_lahir_karyawans,
                        'tempat_lahir_karyawans'        => $tempat_lahir_karyawans,
                        'alamat_domisili_karyawans'        => $alamat_domisili_karyawans,
                        'institusi_karyawans'           => $institusi_karyawans,
                        'hobi_karyawans'                => $hobi_karyawans,
                        'keahlian_khusus_karyawans'     => $keahlian_khusus_karyawans,
                        'no_hp_karyawans'               => $no_hp_karyawans,
                        'email_karyawans'               => $email_karyawans,
                        'ktp_karyawans'                 => $request->ktp_karyawans,
                        'npwp_karyawans'                => $npwp_karyawans,
                        'created_at'                    => date('Y-m-d H:i:s'),
                    ];
                }
                else
                {
                    $data = [
                        'users_id'                      => Auth::user()->id,
                        'jabatans_id'                   => $request->jabatans_id,
                        'unit_kerjas_id'                => $request->unit_kerjas_id,
                        'jenis_kelamins_id'             => $request->jenis_kelamins_id,
                        'agamas_id'                     => $request->agamas_id,
                        'status_kawins_id'              => $request->status_kawins_id,
                        'pendidikans_id'                => $request->pendidikans_id,
                        'status_karyawans_id'           => $request->status_karyawans_id,
                        'nama_karyawans'                => $request->nama_karyawans,
                        'foto_karyawans'                => 'karyawan/default/default.png',
                        'nik_gys_karyawans'             => $nik_gys_karyawans,
                        'nik_tg_karyawans'              => $nik_tg_karyawans,
                        'band_posisi_karyawans'         => $band_posisi_karyawans,
                        'tanggal_bergabung_karyawans'   => General::ubahTanggalKeDB($request->tanggal_bergabung_karyawans),
                        'tanggal_keluar_karyawans'      => $tanggal_keluar_karyawans,
                        'tanggal_lahir_karyawans'       => $tanggal_lahir_karyawans,
                        'tempat_lahir_karyawans'        => $tempat_lahir_karyawans,
                        'alamat_domisili_karyawans'        => $alamat_domisili_karyawans,
                        'institusi_karyawans'           => $institusi_karyawans,
                        'hobi_karyawans'                => $hobi_karyawans,
                        'keahlian_khusus_karyawans'     => $keahlian_khusus_karyawans,
                        'no_hp_karyawans'               => $no_hp_karyawans,
                        'email_karyawans'               => $email_karyawans,
                        'ktp_karyawans'                 => $request->ktp_karyawans,
                        'npwp_karyawans'                => $npwp_karyawans,
                        'created_at'                    => date('Y-m-d H:i:s'),
                    ];
                }
                Karyawan::where('id_karyawans', $id_karyawans)
                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/karyawan';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/karyawan');
        }
        else
            return redirect('dashboard/karyawan');
    }

    public function hapus($id_karyawans=0)
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'hapus') == 'true')
        {
            $cek_karyawans = Karyawan::where('id_karyawans',$id_karyawans)->first();
            if(!empty($cek_karyawans))
            {
                if($cek_karyawans->foto_karyawans != 'karyawan/default/default.png')
                {
                    Storage::disk('public')->delete($cek_karyawans->foto_karyawans);
                }
                Karyawan::where('id_karyawans',$id_karyawans)
                        ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/karyawan');
        }
        else
            return redirect('dashboard/karyawan');
    }

    public function cetakexcel()
    {
        $link_karyawan = 'karyawan';
        if(General::hakAkses($link_karyawan,'cetak') == 'true')
        {
            $tanggal = date('Y-m-d H:i:s');
            $hasil_unit_kerja = 'semua';
            if(!empty(session('hasil_unit_kerja')))
            {
                $ambil_unit_kerja = Master_unit_kerja::where('id_unit_kerjas',session('hasil_unit_kerja'))
                                                    ->first();
                $hasil_unit_kerja = $ambil_unit_kerja->nama_unit_kerjas;
            }

            
            return Excel::download(new KaryawanExport, 'karyawan_'.$hasil_unit_kerja.'-'.General::ubahDBKeTanggalWaktu($tanggal).'.xlsx');
        }
        else
            return redirect('dashboard/karyawan');
    }

}