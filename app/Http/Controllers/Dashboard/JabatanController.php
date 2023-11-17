<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_jabatan;

class JabatanController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_jabatan = 'jabatan';
        if(General::hakAkses($link_jabatan,'lihat') == 'true')
        {
            $data['link_jabatan']         = $link_jabatan;
            $data['hasil_kata']                     = '';
            $url_sekarang                           = $request->fullUrl();
        	$data['lihat_jabatans']    	= Master_jabatan::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.jabatan.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_jabatan = 'jabatan';
        if(General::hakAkses($link_jabatan,'lihat') == 'true')
        {
            $data['link_jabatan']         = $link_jabatan;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_jabatans']       = Master_jabatan::where('nama_jabatans', 'LIKE', '%'.$hasil_kata.'%')
                                                                            ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.jabatan.lihat', $data);
        }
        else
            return redirect('dashboard/jabatan');
    }

    public function tambah()
    {
        $link_jabatan = 'jabatan';
        if(General::hakAkses($link_jabatan,'tambah') == 'true')
            return view('dashboard.jabatan.tambah');
        else
            return redirect('dashboard/jabatan');
    }

    public function prosestambah(Request $request)
    {
        $link_jabatan = 'jabatan';
        if(General::hakAkses($link_jabatan,'tambah') == 'true')
        {
            $aturan = [
                'nama_jabatans'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_jabatans'               => $request->nama_jabatans,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_jabatan::insert($data);

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
                    $redirect_halaman  = 'dashboard/jabatan';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/jabatan');
    }

    public function edit($id_jabatans=0)
    {
        $link_jabatan = 'jabatan';
        if(General::hakAkses($link_jabatan,'edit') == 'true')
        {
            $cek_jabatans = Master_jabatan::where('id_jabatans',$id_jabatans)->count();
            if($cek_jabatans != 0)
            {
                $data['edit_jabatans']         = Master_jabatan::where('id_jabatans',$id_jabatans)
                                                            ->first();
                return view('dashboard.jabatan.edit',$data);
            }
            else
                return redirect('dashboard/jabatan');
        }
        else
            return redirect('dashboard/jabatan');
    }

    public function prosesedit($id_jabatans=0, Request $request)
    {
        $link_jabatan = 'jabatan';
        if(General::hakAkses($link_jabatan,'edit') == 'true')
        {
            $cek_jabatans = Master_jabatan::where('id_jabatans',$id_jabatans)->first();
            if(!empty($cek_jabatans))
            {
                $aturan = [
                    'nama_jabatans'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_jabatans'	=> $request->nama_jabatans,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_jabatan::where('id_jabatans', $id_jabatans)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/jabatan';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/jabatan');
        }
        else
            return redirect('dashboard/jabatan');
    }

    public function hapus($id_jabatans=0)
    {
        $link_jabatan = 'jabatan';
        if(General::hakAkses($link_jabatan,'hapus') == 'true')
        {
            $cek_jabatans = Master_jabatan::where('id_jabatans',$id_jabatans)->first();
            if(!empty($cek_jabatans))
            {
                Master_jabatan::where('id_jabatans',$id_jabatans)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/jabatan');
        }
        else
            return redirect('dashboard/jabatan');
    }

}