<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_derajat_surat;

class DerajatSuratController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_derajat_surat = 'derajat_surat';
        if(General::hakAkses($link_derajat_surat,'lihat') == 'true')
        {
            $data['link_derajat_surat']         = $link_derajat_surat;
            $data['hasil_kata']                     = '';
            $url_sekarang                           = $request->fullUrl();
        	$data['lihat_derajat_surats']    	= Master_derajat_surat::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.derajat_surat.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_derajat_surat = 'derajat_surat';
        if(General::hakAkses($link_derajat_surat,'lihat') == 'true')
        {
            $data['link_derajat_surat']         = $link_derajat_surat;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_derajat_surats']       = Master_derajat_surat::where('nama_derajat_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.derajat_surat.lihat', $data);
        }
        else
            return redirect('dashboard/derajat_surat');
    }

    public function tambah()
    {
        $link_derajat_surat = 'derajat_surat';
        if(General::hakAkses($link_derajat_surat,'tambah') == 'true')
            return view('dashboard.derajat_surat.tambah');
        else
            return redirect('dashboard/derajat_surat');
    }

    public function prosestambah(Request $request)
    {
        $link_derajat_surat = 'derajat_surat';
        if(General::hakAkses($link_derajat_surat,'tambah') == 'true')
        {
            $aturan = [
                'nama_derajat_surats'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_derajat_surats'               => $request->nama_derajat_surats,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_derajat_surat::insert($data);

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
                    $redirect_halaman  = 'dashboard/derajat_surat';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/derajat_surat');
    }

    public function edit($id_derajat_surats=0)
    {
        $link_derajat_surat = 'derajat_surat';
        if(General::hakAkses($link_derajat_surat,'edit') == 'true')
        {
            $cek_derajat_surats = Master_derajat_surat::where('id_derajat_surats',$id_derajat_surats)->count();
            if($cek_derajat_surats != 0)
            {
                $data['edit_derajat_surats']         = Master_derajat_surat::where('id_derajat_surats',$id_derajat_surats)
                                                                                                    ->first();
                return view('dashboard.derajat_surat.edit',$data);
            }
            else
                return redirect('dashboard/derajat_surat');
        }
        else
            return redirect('dashboard/derajat_surat');
    }

    public function prosesedit($id_derajat_surats=0, Request $request)
    {
        $link_derajat_surat = 'derajat_surat';
        if(General::hakAkses($link_derajat_surat,'edit') == 'true')
        {
            $cek_derajat_surats = Master_derajat_surat::where('id_derajat_surats',$id_derajat_surats)->first();
            if(!empty($cek_derajat_surats))
            {
                $aturan = [
                    'nama_derajat_surats'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_derajat_surats'	=> $request->nama_derajat_surats,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_derajat_surat::where('id_derajat_surats', $id_derajat_surats)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/derajat_surat';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/derajat_surat');
        }
        else
            return redirect('dashboard/derajat_surat');
    }

    public function hapus($id_derajat_surats=0)
    {
        $link_derajat_surat = 'derajat_surat';
        if(General::hakAkses($link_derajat_surat,'hapus') == 'true')
        {
            $cek_derajat_surats = Master_derajat_surat::where('id_derajat_surats',$id_derajat_surats)->first();
            if(!empty($cek_derajat_surats))
            {
                Master_derajat_surat::where('id_derajat_surats',$id_derajat_surats)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/derajat_surat');
        }
        else
            return redirect('dashboard/derajat_surat');
    }

}