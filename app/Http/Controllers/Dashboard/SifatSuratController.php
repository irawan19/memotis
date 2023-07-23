<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_sifat_surat;

class SifatSuratController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_sifat_surat = 'sifat_surat';
        if(General::hakAkses($link_sifat_surat,'lihat') == 'true')
        {
            $data['link_sifat_surat']         = $link_sifat_surat;
            $data['hasil_kata']                     = '';
            $url_sekarang                           = $request->fullUrl();
        	$data['lihat_sifat_surats']    	= Master_sifat_surat::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.sifat_surat.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_sifat_surat = 'sifat_surat';
        if(General::hakAkses($link_sifat_surat,'lihat') == 'true')
        {
            $data['link_sifat_surat']         = $link_sifat_surat;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_sifat_surats']       = Master_sifat_surat::where('nama_sifat_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.sifat_surat.lihat', $data);
        }
        else
            return redirect('dashboard/sifat_surat');
    }

    public function tambah()
    {
        $link_sifat_surat = 'sifat_surat';
        if(General::hakAkses($link_sifat_surat,'tambah') == 'true')
            return view('dashboard.sifat_surat.tambah');
        else
            return redirect('dashboard/sifat_surat');
    }

    public function prosestambah(Request $request)
    {
        $link_sifat_surat = 'sifat_surat';
        if(General::hakAkses($link_sifat_surat,'tambah') == 'true')
        {
            $aturan = [
                'nama_sifat_surats'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_sifat_surats'               => $request->nama_sifat_surats,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_sifat_surat::insert($data);

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
                    $redirect_halaman  = 'dashboard/sifat_surat';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/sifat_surat');
    }

    public function edit($id_sifat_surats=0)
    {
        $link_sifat_surat = 'sifat_surat';
        if(General::hakAkses($link_sifat_surat,'edit') == 'true')
        {
            $cek_sifat_surats = Master_sifat_surat::where('id_sifat_surats',$id_sifat_surats)->count();
            if($cek_sifat_surats != 0)
            {
                $data['edit_sifat_surats']         = Master_sifat_surat::where('id_sifat_surats',$id_sifat_surats)
                                                                                                    ->first();
                return view('dashboard.sifat_surat.edit',$data);
            }
            else
                return redirect('dashboard/sifat_surat');
        }
        else
            return redirect('dashboard/sifat_surat');
    }

    public function prosesedit($id_sifat_surats=0, Request $request)
    {
        $link_sifat_surat = 'sifat_surat';
        if(General::hakAkses($link_sifat_surat,'edit') == 'true')
        {
            $cek_sifat_surats = Master_sifat_surat::where('id_sifat_surats',$id_sifat_surats)->first();
            if(!empty($cek_sifat_surats))
            {
                $aturan = [
                    'nama_sifat_surats'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_sifat_surats'	=> $request->nama_sifat_surats,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_sifat_surat::where('id_sifat_surats', $id_sifat_surats)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/sifat_surat';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/sifat_surat');
        }
        else
            return redirect('dashboard/sifat_surat');
    }

    public function hapus($id_sifat_surats=0)
    {
        $link_sifat_surat = 'sifat_surat';
        if(General::hakAkses($link_sifat_surat,'hapus') == 'true')
        {
            $cek_sifat_surats = Master_sifat_surat::where('id_sifat_surats',$id_sifat_surats)->first();
            if(!empty($cek_sifat_surats))
            {
                Master_sifat_surat::where('id_sifat_surats',$id_sifat_surats)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/sifat_surat');
        }
        else
            return redirect('dashboard/sifat_surat');
    }

}