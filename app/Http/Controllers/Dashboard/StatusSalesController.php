<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_status_sales;

class StatusSalesController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_status_sales = 'status_sales';
        if(General::hakAkses($link_status_sales,'lihat') == 'true')
        {
            $data['link_status_sales']      = $link_status_sales;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_status_sales']    	= Master_status_sales::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.status_sales.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_status_sales = 'status_sales';
        if(General::hakAkses($link_status_sales,'lihat') == 'true')
        {
            $data['link_status_sales']          = $link_status_sales;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_status_sales']         = Master_status_sales::where('nama_status_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.status_sales.lihat', $data);
        }
        else
            return redirect('dashboard/status_sales');
    }

    public function tambah()
    {
        $link_status_sales = 'status_sales';
        if(General::hakAkses($link_status_sales,'tambah') == 'true')
            return view('dashboard.status_sales.tambah');
        else
            return redirect('dashboard/status_sales');
    }

    public function prosestambah(Request $request)
    {
        $link_status_sales = 'status_sales';
        if(General::hakAkses($link_status_sales,'tambah') == 'true')
        {
            $aturan = [
                'nama_status_sales'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_status_sales'               => $request->nama_status_sales,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_status_sales::insert($data);

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
                    $redirect_halaman  = 'dashboard/status_sales';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/status_sales');
    }

    public function edit($id_status_sales=0)
    {
        $link_status_sales = 'status_sales';
        if(General::hakAkses($link_status_sales,'edit') == 'true')
        {
            $cek_status_sales = Master_status_sales::where('id_status_sales',$id_status_sales)->count();
            if($cek_status_sales != 0)
            {
                $data['edit_status_sales']         = Master_status_sales::where('id_status_sales',$id_status_sales)
                                                                                                    ->first();
                return view('dashboard.status_sales.edit',$data);
            }
            else
                return redirect('dashboard/status_sales');
        }
        else
            return redirect('dashboard/status_sales');
    }

    public function prosesedit($id_status_sales=0, Request $request)
    {
        $link_status_sales = 'status_sales';
        if(General::hakAkses($link_status_sales,'edit') == 'true')
        {
            $cek_status_sales = Master_status_sales::where('id_status_sales',$id_status_sales)->first();
            if(!empty($cek_status_sales))
            {
                $aturan = [
                    'nama_status_sales'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_status_sales'	=> $request->nama_status_sales,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_status_sales::where('id_status_sales', $id_status_sales)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/status_sales';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/status_sales');
        }
        else
            return redirect('dashboard/status_sales');
    }

    public function hapus($id_status_sales=0)
    {
        $link_status_sales = 'status_sales';
        if(General::hakAkses($link_status_sales,'hapus') == 'true')
        {
            $cek_status_sales = Master_status_sales::where('id_status_sales',$id_status_sales)->first();
            if(!empty($cek_status_sales))
            {
                Master_status_sales::where('id_status_sales',$id_status_sales)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/status_sales');
        }
        else
            return redirect('dashboard/status_sales');
    }

}