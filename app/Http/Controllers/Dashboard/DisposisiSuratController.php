<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_disposisi_surat;

class DisposisiSuratController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_disposisi_surat = 'disposisi_surat';
        if(General::hakAkses($link_disposisi_surat,'lihat') == 'true')
        {
            $data['link_disposisi_surat']         = $link_disposisi_surat;
            $data['hasil_kata']                     = '';
            $url_sekarang                           = $request->fullUrl();
        	$data['lihat_disposisi_surats']    	= Master_disposisi_surat::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.disposisi_surat.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_disposisi_surat = 'disposisi_surat';
        if(General::hakAkses($link_disposisi_surat,'lihat') == 'true')
        {
            $data['link_disposisi_surat']         = $link_disposisi_surat;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_disposisi_surats']       = Master_disposisi_surat::where('nama_disposisi_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.disposisi_surat.lihat', $data);
        }
        else
            return redirect('dashboard/disposisi_surat');
    }

    public function tambah()
    {
        $link_disposisi_surat = 'disposisi_surat';
        if(General::hakAkses($link_disposisi_surat,'tambah') == 'true')
            return view('dashboard.disposisi_surat.tambah');
        else
            return redirect('dashboard/disposisi_surat');
    }

    public function prosestambah(Request $request)
    {
        $link_disposisi_surat = 'disposisi_surat';
        if(General::hakAkses($link_disposisi_surat,'tambah') == 'true')
        {
            $aturan = [
                'nama_disposisi_surats'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_disposisi_surats'               => $request->nama_disposisi_surats,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_disposisi_surat::insert($data);

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
                    $redirect_halaman  = 'dashboard/disposisi_surat';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/disposisi_surat');
    }

    public function edit($id_disposisi_surats=0)
    {
        $link_disposisi_surat = 'disposisi_surat';
        if(General::hakAkses($link_disposisi_surat,'edit') == 'true')
        {
            $cek_disposisi_surats = Master_disposisi_surat::where('id_disposisi_surats',$id_disposisi_surats)->count();
            if($cek_disposisi_surats != 0)
            {
                $data['edit_disposisi_surats']         = Master_disposisi_surat::where('id_disposisi_surats',$id_disposisi_surats)
                                                                                                    ->first();
                return view('dashboard.disposisi_surat.edit',$data);
            }
            else
                return redirect('dashboard/disposisi_surat');
        }
        else
            return redirect('dashboard/disposisi_surat');
    }

    public function prosesedit($id_disposisi_surats=0, Request $request)
    {
        $link_disposisi_surat = 'disposisi_surat';
        if(General::hakAkses($link_disposisi_surat,'edit') == 'true')
        {
            $cek_disposisi_surats = Master_disposisi_surat::where('id_disposisi_surats',$id_disposisi_surats)->first();
            if(!empty($cek_disposisi_surats))
            {
                $aturan = [
                    'nama_disposisi_surats'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_disposisi_surats'	=> $request->nama_disposisi_surats,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_disposisi_surat::where('id_disposisi_surats', $id_disposisi_surats)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/disposisi_surat';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/disposisi_surat');
        }
        else
            return redirect('dashboard/disposisi_surat');
    }

    public function hapus($id_disposisi_surats=0)
    {
        $link_disposisi_surat = 'disposisi_surat';
        if(General::hakAkses($link_disposisi_surat,'hapus') == 'true')
        {
            $cek_disposisi_surats = Master_disposisi_surat::where('id_disposisi_surats',$id_disposisi_surats)->first();
            if(!empty($cek_disposisi_surats))
            {
                Master_disposisi_surat::where('id_disposisi_surats',$id_disposisi_surats)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/disposisi_surat');
        }
        else
            return redirect('dashboard/disposisi_surat');
    }

}