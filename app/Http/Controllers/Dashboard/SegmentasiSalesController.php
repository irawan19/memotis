<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_segmentasi_sales;

class SegmentasiSalesController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_segmentasi_sales = 'segmentasi_sales';
        if(General::hakAkses($link_segmentasi_sales,'lihat') == 'true')
        {
            $data['link_segmentasi_sales']      = $link_segmentasi_sales;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_segmentasi_sales']    	= Master_segmentasi_sales::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.segmentasi_sales.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_segmentasi_sales = 'segmentasi_sales';
        if(General::hakAkses($link_segmentasi_sales,'lihat') == 'true')
        {
            $data['link_segmentasi_sales']          = $link_segmentasi_sales;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_segmentasi_sales']         = Master_segmentasi_sales::where('nama_segmentasi_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.segmentasi_sales.lihat', $data);
        }
        else
            return redirect('dashboard/segmentasi_sales');
    }

    public function tambah()
    {
        $link_segmentasi_sales = 'segmentasi_sales';
        if(General::hakAkses($link_segmentasi_sales,'tambah') == 'true')
            return view('dashboard.segmentasi_sales.tambah');
        else
            return redirect('dashboard/segmentasi_sales');
    }

    public function prosestambah(Request $request)
    {
        $link_segmentasi_sales = 'segmentasi_sales';
        if(General::hakAkses($link_segmentasi_sales,'tambah') == 'true')
        {
            $aturan = [
                'nama_segmentasi_sales'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_segmentasi_sales'               => $request->nama_segmentasi_sales,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_segmentasi_sales::insert($data);

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
                    $redirect_halaman  = 'dashboard/segmentasi_sales';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/segmentasi_sales');
    }

    public function edit($id_segmentasi_sales=0)
    {
        $link_segmentasi_sales = 'segmentasi_sales';
        if(General::hakAkses($link_segmentasi_sales,'edit') == 'true')
        {
            $cek_segmentasi_sales = Master_segmentasi_sales::where('id_segmentasi_sales',$id_segmentasi_sales)->count();
            if($cek_segmentasi_sales != 0)
            {
                $data['edit_segmentasi_sales']         = Master_segmentasi_sales::where('id_segmentasi_sales',$id_segmentasi_sales)
                                                                                                    ->first();
                return view('dashboard.segmentasi_sales.edit',$data);
            }
            else
                return redirect('dashboard/segmentasi_sales');
        }
        else
            return redirect('dashboard/segmentasi_sales');
    }

    public function prosesedit($id_segmentasi_sales=0, Request $request)
    {
        $link_segmentasi_sales = 'segmentasi_sales';
        if(General::hakAkses($link_segmentasi_sales,'edit') == 'true')
        {
            $cek_segmentasi_sales = Master_segmentasi_sales::where('id_segmentasi_sales',$id_segmentasi_sales)->first();
            if(!empty($cek_segmentasi_sales))
            {
                $aturan = [
                    'nama_segmentasi_sales'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_segmentasi_sales'	=> $request->nama_segmentasi_sales,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_segmentasi_sales::where('id_segmentasi_sales', $id_segmentasi_sales)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/segmentasi_sales';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/segmentasi_sales');
        }
        else
            return redirect('dashboard/segmentasi_sales');
    }

    public function hapus($id_segmentasi_sales=0)
    {
        $link_segmentasi_sales = 'segmentasi_sales';
        if(General::hakAkses($link_segmentasi_sales,'hapus') == 'true')
        {
            $cek_segmentasi_sales = Master_segmentasi_sales::where('id_segmentasi_sales',$id_segmentasi_sales)->first();
            if(!empty($cek_segmentasi_sales))
            {
                Master_segmentasi_sales::where('id_segmentasi_sales',$id_segmentasi_sales)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/segmentasi_sales');
        }
        else
            return redirect('dashboard/segmentasi_sales');
    }

}