<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_klasifikasi_surat;

class KlasifikasiSuratController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_klasifikasi_surat = 'klasifikasi_surat';
        if(General::hakAkses($link_klasifikasi_surat,'lihat') == 'true')
        {
            $data['link_klasifikasi_surat']         = $link_klasifikasi_surat;
            $data['hasil_kata']                     = '';
            $url_sekarang                           = $request->fullUrl();
        	$data['lihat_klasifikasi_surats']    	= Master_klasifikasi_surat::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.klasifikasi_surat.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_klasifikasi_surat = 'klasifikasi_surat';
        if(General::hakAkses($link_klasifikasi_surat,'lihat') == 'true')
        {
            $data['link_klasifikasi_surat']         = $link_klasifikasi_surat;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_klasifikasi_surats']       = Master_klasifikasi_surat::where('nama_klasifikasi_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.klasifikasi_surat.lihat', $data);
        }
        else
            return redirect('dashboard/klasifikasi_surat');
    }

    public function tambah()
    {
        $link_klasifikasi_surat = 'klasifikasi_surat';
        if(General::hakAkses($link_klasifikasi_surat,'tambah') == 'true')
            return view('dashboard.klasifikasi_surat.tambah');
        else
            return redirect('dashboard/klasifikasi_surat');
    }

    public function prosestambah(Request $request)
    {
        $link_klasifikasi_surat = 'klasifikasi_surat';
        if(General::hakAkses($link_klasifikasi_surat,'tambah') == 'true')
        {
            $aturan = [
                'nama_klasifikasi_surats'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_klasifikasi_surats'               => $request->nama_klasifikasi_surats,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_klasifikasi_surat::insert($data);

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
                    $redirect_halaman  = 'dashboard/klasifikasi_surat';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/klasifikasi_surat');
    }

    public function edit($id_klasifikasi_surats=0)
    {
        $link_klasifikasi_surat = 'klasifikasi_surat';
        if(General::hakAkses($link_klasifikasi_surat,'edit') == 'true')
        {
            $cek_klasifikasi_surats = Master_klasifikasi_surat::where('id_klasifikasi_surats',$id_klasifikasi_surats)->count();
            if($cek_klasifikasi_surats != 0)
            {
                $data['edit_klasifikasi_surats']         = Master_klasifikasi_surat::where('id_klasifikasi_surats',$id_klasifikasi_surats)
                                                                                                    ->first();
                return view('dashboard.klasifikasi_surat.edit',$data);
            }
            else
                return redirect('dashboard/klasifikasi_surat');
        }
        else
            return redirect('dashboard/klasifikasi_surat');
    }

    public function prosesedit($id_klasifikasi_surats=0, Request $request)
    {
        $link_klasifikasi_surat = 'klasifikasi_surat';
        if(General::hakAkses($link_klasifikasi_surat,'edit') == 'true')
        {
            $cek_klasifikasi_surats = Master_klasifikasi_surat::where('id_klasifikasi_surats',$id_klasifikasi_surats)->first();
            if(!empty($cek_klasifikasi_surats))
            {
                $aturan = [
                    'nama_klasifikasi_surats'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_klasifikasi_surats'	=> $request->nama_klasifikasi_surats,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_klasifikasi_surat::where('id_klasifikasi_surats', $id_klasifikasi_surats)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/klasifikasi_surat';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/klasifikasi_surat');
        }
        else
            return redirect('dashboard/klasifikasi_surat');
    }

    public function hapus($id_klasifikasi_surats=0)
    {
        $link_klasifikasi_surat = 'klasifikasi_surat';
        if(General::hakAkses($link_klasifikasi_surat,'hapus') == 'true')
        {
            $cek_klasifikasi_surats = Master_klasifikasi_surat::where('id_klasifikasi_surats',$id_klasifikasi_surats)->first();
            if(!empty($cek_klasifikasi_surats))
            {
                Master_klasifikasi_surat::where('id_klasifikasi_surats',$id_klasifikasi_surats)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/klasifikasi_surat');
        }
        else
            return redirect('dashboard/klasifikasi_surat');
    }

}