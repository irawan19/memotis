<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_unit_kerja;

class UnitKerjaController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'lihat') == 'true')
        {
            $data['link_unit_kerja']            = $link_unit_kerja;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_unit_kerjas']    	    = Master_unit_kerja::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                  => $url_sekarang]);
        	return view('dashboard.unit_kerja.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'lihat') == 'true')
        {
            $data['link_unit_kerja']         = $link_unit_kerja;
            $url_sekarang                    = $request->fullUrl();
            $hasil_kata                      = $request->cari_kata;
            $data['hasil_kata']              = $hasil_kata;
            $data['lihat_unit_kerjas']       = Master_unit_kerja::where('nama_unit_kerjas', 'LIKE', '%'.$hasil_kata.'%')
                                                                ->orWhere('lokasi_unit_kerjas', 'LIKE', '%'.$hasil_kata.'%')
                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.unit_kerja.lihat', $data);
        }
        else
            return redirect('dashboard/unit_kerja');
    }

    public function lokasi($id_unit_kerjas=0) {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'edit') == 'true')
        {
            $cek_unit_kerjas = Master_unit_kerja::where('id_unit_kerjas',$id_unit_kerjas)->first();
            if(!empty($cek_unit_kerjas))
            {
                $lokasi_unit_kerjas = [
                    $cek_unit_kerjas->lokasi_unit_kerjas,
                ];
                return json_encode($lokasi_unit_kerjas);
            }
            else
                return redirect('dashboard/unit_kerja');
        }
        else
            return redirect('dashboard/unit_kerja');
    }

    public function tambah()
    {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'tambah') == 'true')
            return view('dashboard.unit_kerja.tambah');
        else
            return redirect('dashboard/unit_kerja');
    }

    public function prosestambah(Request $request)
    {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'tambah') == 'true')
        {
            $aturan = [
                'nama_unit_kerjas'              => 'required',
                'lokasi_unit_kerjas'            => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_unit_kerjas'               => $request->nama_unit_kerjas,
                'lokasi_unit_kerjas'             => $request->lokasi_unit_kerjas,
                'created_at'                     => date('Y-m-d H:i:s'),
            ];
            Master_unit_kerja::insert($data);

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
                    $redirect_halaman  = 'dashboard/unit_kerja';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/unit_kerja');
    }

    public function edit($id_unit_kerjas=0)
    {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'edit') == 'true')
        {
            $cek_unit_kerjas = Master_unit_kerja::where('id_unit_kerjas',$id_unit_kerjas)->count();
            if($cek_unit_kerjas != 0)
            {
                $data['edit_unit_kerjas']         = Master_unit_kerja::where('id_unit_kerjas',$id_unit_kerjas)
                                                                    ->first();
                return view('dashboard.unit_kerja.edit',$data);
            }
            else
                return redirect('dashboard/unit_kerja');
        }
        else
            return redirect('dashboard/unit_kerja');
    }

    public function prosesedit($id_unit_kerjas=0, Request $request)
    {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'edit') == 'true')
        {
            $cek_unit_kerjas = Master_unit_kerja::where('id_unit_kerjas',$id_unit_kerjas)->first();
            if(!empty($cek_unit_kerjas))
            {
                $aturan = [
                    'nama_unit_kerjas'      => 'required',
                    'lokasi_unit_kerjas'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_unit_kerjas'	        => $request->nama_unit_kerjas,
                    'lokasi_unit_kerjas'        => $request->lokasi_unit_kerjas,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_unit_kerja::where('id_unit_kerjas', $id_unit_kerjas)
                                ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/unit_kerja';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/unit_kerja');
        }
        else
            return redirect('dashboard/unit_kerja');
    }

    public function hapus($id_unit_kerjas=0)
    {
        $link_unit_kerja = 'unit_kerja';
        if(General::hakAkses($link_unit_kerja,'hapus') == 'true')
        {
            $cek_unit_kerjas = Master_unit_kerja::where('id_unit_kerjas',$id_unit_kerjas)->first();
            if(!empty($cek_unit_kerjas))
            {
                Master_unit_kerja::where('id_unit_kerjas',$id_unit_kerjas)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/unit_kerja');
        }
        else
            return redirect('dashboard/unit_kerja');
    }

}