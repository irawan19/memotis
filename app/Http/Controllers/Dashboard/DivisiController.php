<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_divisi;

class DivisiController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_divisi = 'divisi';
        if(General::hakAkses($link_divisi,'lihat') == 'true')
        {
            $data['link_divisi']         = $link_divisi;
            $data['hasil_kata']                     = '';
            $url_sekarang                           = $request->fullUrl();
        	$data['lihat_divisis']    	= Master_divisi::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.divisi.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_divisi = 'divisi';
        if(General::hakAkses($link_divisi,'lihat') == 'true')
        {
            $data['link_divisi']         = $link_divisi;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_divisis']       = Master_divisi::where('nama_divisis', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.divisi.lihat', $data);
        }
        else
            return redirect('dashboard/divisi');
    }

    public function tambah()
    {
        $link_divisi = 'divisi';
        if(General::hakAkses($link_divisi,'tambah') == 'true')
            return view('dashboard.divisi.tambah');
        else
            return redirect('dashboard/divisi');
    }

    public function prosestambah(Request $request)
    {
        $link_divisi = 'divisi';
        if(General::hakAkses($link_divisi,'tambah') == 'true')
        {
            $aturan = [
                'nama_divisis'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_divisis'               => $request->nama_divisis,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_divisi::insert($data);

            $simpan           = $request->simpan;
            $simpan_kembali   = $request->simpan_kembali;
            if($simpan)
            {
                $setelah_simpan = [
                    'alert'  => 'sukses',
                    'text'   => 'Data berhasil ditambahkan',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            }
            if($simpan_kembali)
            {
                if(request()->session()->get('halaman') != '')
                    $redirect_halaman  = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/divisi';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/divisi');
    }

    public function edit($id_divisis=0)
    {
        $link_divisi = 'divisi';
        if(General::hakAkses($link_divisi,'edit') == 'true')
        {
            $cek_divisis = Master_divisi::where('id_divisis',$id_divisis)->count();
            if($cek_divisis != 0)
            {
                $data['edit_divisis']         = Master_divisi::where('id_divisis',$id_divisis)
                                                                                                    ->first();
                return view('dashboard.divisi.edit',$data);
            }
            else
                return redirect('dashboard/divisi');
        }
        else
            return redirect('dashboard/divisi');
    }

    public function prosesedit($id_divisis=0, Request $request)
    {
        $link_divisi = 'divisi';
        if(General::hakAkses($link_divisi,'edit') == 'true')
        {
            $cek_divisis = Master_divisi::where('id_divisis',$id_divisis)->first();
            if(!empty($cek_divisis))
            {
                $aturan = [
                    'nama_divisis'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_divisis'	=> $request->nama_divisis,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_divisi::where('id_divisis', $id_divisis)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/divisi';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/divisi');
        }
        else
            return redirect('dashboard/divisi');
    }

    public function hapus($id_divisis=0)
    {
        $link_divisi = 'divisi';
        if(General::hakAkses($link_divisi,'hapus') == 'true')
        {
            $cek_divisis = Master_divisi::where('id_divisis',$id_divisis)->first();
            if(!empty($cek_divisis))
            {
                Master_divisi::where('id_divisis',$id_divisis)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/divisi');
        }
        else
            return redirect('dashboard/divisi');
    }

}