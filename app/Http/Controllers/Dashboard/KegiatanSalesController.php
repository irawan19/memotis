<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_kegiatan_sales;

class KegiatanSalesController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_kegiatan_sales = 'kegiatan_sales';
        if(General::hakAkses($link_kegiatan_sales,'lihat') == 'true')
        {
            $data['link_kegiatan_sales']      = $link_kegiatan_sales;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_kegiatan_sales']    	= Master_kegiatan_sales::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.kegiatan_sales.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_kegiatan_sales = 'kegiatan_sales';
        if(General::hakAkses($link_kegiatan_sales,'lihat') == 'true')
        {
            $data['link_kegiatan_sales']          = $link_kegiatan_sales;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_kegiatan_sales']         = Master_kegiatan_sales::where('nama_kegiatan_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.kegiatan_sales.lihat', $data);
        }
        else
            return redirect('dashboard/kegiatan_sales');
    }

    public function tambah()
    {
        $link_kegiatan_sales = 'kegiatan_sales';
        if(General::hakAkses($link_kegiatan_sales,'tambah') == 'true')
            return view('dashboard.kegiatan_sales.tambah');
        else
            return redirect('dashboard/kegiatan_sales');
    }

    public function prosestambah(Request $request)
    {
        $link_kegiatan_sales = 'kegiatan_sales';
        if(General::hakAkses($link_kegiatan_sales,'tambah') == 'true')
        {
            $aturan = [
                'nama_kegiatan_sales'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_kegiatan_sales'               => $request->nama_kegiatan_sales,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_kegiatan_sales::insert($data);

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
                    $redirect_halaman  = 'dashboard/kegiatan_sales';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/kegiatan_sales');
    }

    public function edit($id_kegiatan_sales=0)
    {
        $link_kegiatan_sales = 'kegiatan_sales';
        if(General::hakAkses($link_kegiatan_sales,'edit') == 'true')
        {
            $cek_kegiatan_sales = Master_kegiatan_sales::where('id_kegiatan_sales',$id_kegiatan_sales)->count();
            if($cek_kegiatan_sales != 0)
            {
                $data['edit_kegiatan_sales']         = Master_kegiatan_sales::where('id_kegiatan_sales',$id_kegiatan_sales)
                                                                                                    ->first();
                return view('dashboard.kegiatan_sales.edit',$data);
            }
            else
                return redirect('dashboard/kegiatan_sales');
        }
        else
            return redirect('dashboard/kegiatan_sales');
    }

    public function prosesedit($id_kegiatan_sales=0, Request $request)
    {
        $link_kegiatan_sales = 'kegiatan_sales';
        if(General::hakAkses($link_kegiatan_sales,'edit') == 'true')
        {
            $cek_kegiatan_sales = Master_kegiatan_sales::where('id_kegiatan_sales',$id_kegiatan_sales)->first();
            if(!empty($cek_kegiatan_sales))
            {
                $aturan = [
                    'nama_kegiatan_sales'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_kegiatan_sales'	=> $request->nama_kegiatan_sales,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_kegiatan_sales::where('id_kegiatan_sales', $id_kegiatan_sales)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/kegiatan_sales';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/kegiatan_sales');
        }
        else
            return redirect('dashboard/kegiatan_sales');
    }

    public function hapus($id_kegiatan_sales=0)
    {
        $link_kegiatan_sales = 'kegiatan_sales';
        if(General::hakAkses($link_kegiatan_sales,'hapus') == 'true')
        {
            $cek_kegiatan_sales = Master_kegiatan_sales::where('id_kegiatan_sales',$id_kegiatan_sales)->first();
            if(!empty($cek_kegiatan_sales))
            {
                Master_kegiatan_sales::where('id_kegiatan_sales',$id_kegiatan_sales)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/kegiatan_sales');
        }
        else
            return redirect('dashboard/kegiatan_sales');
    }

}