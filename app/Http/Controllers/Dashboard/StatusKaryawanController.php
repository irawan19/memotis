<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_status_karyawan;

class StatusKaryawanController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_status_karyawan = 'status_karyawan';
        if(General::hakAkses($link_status_karyawan,'lihat') == 'true')
        {
            $data['link_status_karyawan']            = $link_status_karyawan;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_status_karyawans']    	    = Master_status_karyawan::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                  => $url_sekarang]);
        	return view('dashboard.status_karyawan.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_status_karyawan = 'status_karyawan';
        if(General::hakAkses($link_status_karyawan,'lihat') == 'true')
        {
            $data['link_status_karyawan']         = $link_status_karyawan;
            $url_sekarang                    = $request->fullUrl();
            $hasil_kata                      = $request->cari_kata;
            $data['hasil_kata']              = $hasil_kata;
            $data['lihat_status_karyawans']       = Master_status_karyawan::where('nama_status_karyawans', 'LIKE', '%'.$hasil_kata.'%')
                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.status_karyawan.lihat', $data);
        }
        else
            return redirect('dashboard/status_karyawan');
    }

    public function tambah()
    {
        $link_status_karyawan = 'status_karyawan';
        if(General::hakAkses($link_status_karyawan,'tambah') == 'true')
            return view('dashboard.status_karyawan.tambah');
        else
            return redirect('dashboard/status_karyawan');
    }

    public function prosestambah(Request $request)
    {
        $link_status_karyawan = 'status_karyawan';
        if(General::hakAkses($link_status_karyawan,'tambah') == 'true')
        {
            $aturan = [
                'nama_status_karyawans'              => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_status_karyawans'               => $request->nama_status_karyawans,
                'created_at'                     => date('Y-m-d H:i:s'),
            ];
            Master_status_karyawan::insert($data);

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
                    $redirect_halaman  = 'dashboard/status_karyawan';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/status_karyawan');
    }

    public function edit($id_status_karyawans=0)
    {
        $link_status_karyawan = 'status_karyawan';
        if(General::hakAkses($link_status_karyawan,'edit') == 'true')
        {
            $cek_status_karyawans = Master_status_karyawan::where('id_status_karyawans',$id_status_karyawans)->count();
            if($cek_status_karyawans != 0)
            {
                $data['edit_status_karyawans']         = Master_status_karyawan::where('id_status_karyawans',$id_status_karyawans)
                                                                    ->first();
                return view('dashboard.status_karyawan.edit',$data);
            }
            else
                return redirect('dashboard/status_karyawan');
        }
        else
            return redirect('dashboard/status_karyawan');
    }

    public function prosesedit($id_status_karyawans=0, Request $request)
    {
        $link_status_karyawan = 'status_karyawan';
        if(General::hakAkses($link_status_karyawan,'edit') == 'true')
        {
            $cek_status_karyawans = Master_status_karyawan::where('id_status_karyawans',$id_status_karyawans)->first();
            if(!empty($cek_status_karyawans))
            {
                $aturan = [
                    'nama_status_karyawans'      => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_status_karyawans'	        => $request->nama_status_karyawans,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_status_karyawan::where('id_status_karyawans', $id_status_karyawans)
                                ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/status_karyawan';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/status_karyawan');
        }
        else
            return redirect('dashboard/status_karyawan');
    }

    public function hapus($id_status_karyawans=0)
    {
        $link_status_karyawan = 'status_karyawan';
        if(General::hakAkses($link_status_karyawan,'hapus') == 'true')
        {
            $cek_status_karyawans = Master_status_karyawan::where('id_status_karyawans',$id_status_karyawans)->first();
            if(!empty($cek_status_karyawans))
            {
                Master_status_karyawan::where('id_status_karyawans',$id_status_karyawans)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/status_karyawan');
        }
        else
            return redirect('dashboard/status_karyawan');
    }

}