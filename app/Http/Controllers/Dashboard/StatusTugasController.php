<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_status_tugas;

class StatusTugasController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_status_tugas = 'status_tugas';
        if(General::hakAkses($link_status_tugas,'lihat') == 'true')
        {
            $data['link_status_tugas']         = $link_status_tugas;
            $data['hasil_kata']                     = '';
            $url_sekarang                           = $request->fullUrl();
        	$data['lihat_status_tugas']    	= Master_status_tugas::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.status_tugas.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_status_tugas = 'status_tugas';
        if(General::hakAkses($link_status_tugas,'lihat') == 'true')
        {
            $data['link_status_tugas']         = $link_status_tugas;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_status_tugas']       = Master_status_tugas::where('nama_status_tugas', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.status_tugas.lihat', $data);
        }
        else
            return redirect('dashboard/status_tugas');
    }

    public function tambah()
    {
        $link_status_tugas = 'status_tugas';
        if(General::hakAkses($link_status_tugas,'tambah') == 'true')
            return view('dashboard.status_tugas.tambah');
        else
            return redirect('dashboard/status_tugas');
    }

    public function prosestambah(Request $request)
    {
        $link_status_tugas = 'status_tugas';
        if(General::hakAkses($link_status_tugas,'tambah') == 'true')
        {
            $aturan = [
                'nama_status_tugas'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_status_tugas'               => $request->nama_status_tugas,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_status_tugas::insert($data);

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
                    $redirect_halaman  = 'dashboard/status_tugas';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/status_tugas');
    }

    public function edit($id_status_tugas=0)
    {
        $link_status_tugas = 'status_tugas';
        if(General::hakAkses($link_status_tugas,'edit') == 'true')
        {
            $cek_status_tugas = Master_status_tugas::where('id_status_tugas',$id_status_tugas)->count();
            if($cek_status_tugas != 0)
            {
                $data['edit_status_tugas']         = Master_status_tugas::where('id_status_tugas',$id_status_tugas)
                                                                                                    ->first();
                return view('dashboard.status_tugas.edit',$data);
            }
            else
                return redirect('dashboard/status_tugas');
        }
        else
            return redirect('dashboard/status_tugas');
    }

    public function prosesedit($id_status_tugas=0, Request $request)
    {
        $link_status_tugas = 'status_tugas';
        if(General::hakAkses($link_status_tugas,'edit') == 'true')
        {
            $cek_status_tugas = Master_status_tugas::where('id_status_tugas',$id_status_tugas)->first();
            if(!empty($cek_status_tugas))
            {
                $aturan = [
                    'nama_status_tugas'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_status_tugas'	=> $request->nama_status_tugas,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_status_tugas::where('id_status_tugas', $id_status_tugas)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/status_tugas';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/status_tugas');
        }
        else
            return redirect('dashboard/status_tugas');
    }

    public function hapus($id_status_tugas=0)
    {
        $link_status_tugas = 'status_tugas';
        if(General::hakAkses($link_status_tugas,'hapus') == 'true')
        {
            $cek_status_tugas = Master_status_tugas::where('id_status_tugas',$id_status_tugas)->first();
            if(!empty($cek_status_tugas))
            {
                Master_status_tugas::where('id_status_tugas',$id_status_tugas)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/status_tugas');
        }
        else
            return redirect('dashboard/status_tugas');
    }

}