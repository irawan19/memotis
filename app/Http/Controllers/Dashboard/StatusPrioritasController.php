<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_status_prioritas;

class StatusPrioritasController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_status_prioritas = 'status_prioritas';
        if(General::hakAkses($link_status_prioritas,'lihat') == 'true')
        {
            $data['link_status_prioritas']      = $link_status_prioritas;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_status_prioritas']    	= Master_status_prioritas::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                  => $url_sekarang]);
        	return view('dashboard.status_prioritas.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_status_prioritas = 'status_prioritas';
        if(General::hakAkses($link_status_prioritas,'lihat') == 'true')
        {
            $data['link_status_prioritas']         = $link_status_prioritas;
            $url_sekarang                    = $request->fullUrl();
            $hasil_kata                      = $request->cari_kata;
            $data['hasil_kata']              = $hasil_kata;
            $data['lihat_status_prioritas']       = Master_status_prioritas::where('nama_status_prioritas', 'LIKE', '%'.$hasil_kata.'%')
                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.status_prioritas.lihat', $data);
        }
        else
            return redirect('dashboard/status_prioritas');
    }

    public function tambah()
    {
        $link_status_prioritas = 'status_prioritas';
        if(General::hakAkses($link_status_prioritas,'tambah') == 'true')
            return view('dashboard.status_prioritas.tambah');
        else
            return redirect('dashboard/status_prioritas');
    }

    public function prosestambah(Request $request)
    {
        $link_status_prioritas = 'status_prioritas';
        if(General::hakAkses($link_status_prioritas,'tambah') == 'true')
        {
            $aturan = [
                'nama_status_prioritas'              => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_status_prioritas'               => $request->nama_status_prioritas,
                'created_at'                     => date('Y-m-d H:i:s'),
            ];
            Master_status_prioritas::insert($data);

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
                    $redirect_halaman  = 'dashboard/status_prioritas';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/status_prioritas');
    }

    public function edit($id_status_prioritas=0)
    {
        $link_status_prioritas = 'status_prioritas';
        if(General::hakAkses($link_status_prioritas,'edit') == 'true')
        {
            $cek_status_prioritas = Master_status_prioritas::where('id_status_prioritas',$id_status_prioritas)->count();
            if($cek_status_prioritas != 0)
            {
                $data['edit_status_prioritas']         = Master_status_prioritas::where('id_status_prioritas',$id_status_prioritas)
                                                                    ->first();
                return view('dashboard.status_prioritas.edit',$data);
            }
            else
                return redirect('dashboard/status_prioritas');
        }
        else
            return redirect('dashboard/status_prioritas');
    }

    public function prosesedit($id_status_prioritas=0, Request $request)
    {
        $link_status_prioritas = 'status_prioritas';
        if(General::hakAkses($link_status_prioritas,'edit') == 'true')
        {
            $cek_status_prioritas = Master_status_prioritas::where('id_status_prioritas',$id_status_prioritas)->first();
            if(!empty($cek_status_prioritas))
            {
                $aturan = [
                    'nama_status_prioritas'      => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_status_prioritas'	        => $request->nama_status_prioritas,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_status_prioritas::where('id_status_prioritas', $id_status_prioritas)
                                ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/status_prioritas';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/status_prioritas');
        }
        else
            return redirect('dashboard/status_prioritas');
    }

    public function hapus($id_status_prioritas=0)
    {
        $link_status_prioritas = 'status_prioritas';
        if(General::hakAkses($link_status_prioritas,'hapus') == 'true')
        {
            $cek_status_prioritas = Master_status_prioritas::where('id_status_prioritas',$id_status_prioritas)->first();
            if(!empty($cek_status_prioritas))
            {
                Master_status_prioritas::where('id_status_prioritas',$id_status_prioritas)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/status_prioritas');
        }
        else
            return redirect('dashboard/status_prioritas');
    }

}