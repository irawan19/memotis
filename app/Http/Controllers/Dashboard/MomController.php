<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Mom;

class MomController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'lihat') == 'true')
        {
            $data['link_mom']           = $link_mom;
            $data['hasil_kata']         = '';
            $url_sekarang               = $request->fullUrl();
        	$data['lihat_moms']    	    = Mom::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.mom.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'lihat') == 'true')
        {
            $data['link_mom']           = $link_mom;
            $url_sekarang               = $request->fullUrl();
            $hasil_kata                 = $request->cari_kata;
            $data['hasil_kata']         = $hasil_kata;
            $data['lihat_moms']         = Mom::where('judul_moms', 'LIKE', '%'.$hasil_kata.'%')
                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.mom.lihat', $data);
        }
        else
            return redirect('dashboard/mom');
    }

    public function tambah()
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true')
            return view('dashboard.mom.tambah');
        else
            return redirect('dashboard/mom');
    }

    public function prosestambah(Request $request)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true')
        {
            $aturan = [
                'judul_moms'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'judul_moms'               => $request->judul_moms,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Mom::insert($data);

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
                    $redirect_halaman  = 'dashboard/mom';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/mom');
    }

    public function edit($id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'edit') == 'true')
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->count();
            if($cek_moms != 0)
            {
                $data['edit_moms']         = Mom::where('id_moms',$id_moms)
                                                ->first();
                return view('dashboard.mom.edit',$data);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

    public function prosesedit($id_moms=0, Request $request)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'edit') == 'true')
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->first();
            if(!empty($cek_moms))
            {
                $aturan = [
                    'judul_moms'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'judul_moms'	=> $request->judul_moms,
                    'updated_at'    => date('Y-m-d H:i:s')
                ];
                Mom::where('id_moms', $id_moms)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/mom';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

    public function hapus($id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'hapus') == 'true')
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->first();
            if(!empty($cek_moms))
            {
                Mom::where('id_moms',$id_moms)
                    ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

}