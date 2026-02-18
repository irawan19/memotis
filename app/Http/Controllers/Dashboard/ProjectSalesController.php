<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Master_project_sales;

class ProjectSalesController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_project_sales = 'project_sales';
        if(General::hakAkses($link_project_sales,'lihat') == 'true')
        {
            $data['link_project_sales']      = $link_project_sales;
            $data['hasil_kata']                 = '';
            $url_sekarang                       = $request->fullUrl();
        	$data['lihat_project_sales']    	= Master_project_sales::get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.project_sales.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_project_sales = 'project_sales';
        if(General::hakAkses($link_project_sales,'lihat') == 'true')
        {
            $data['link_project_sales']          = $link_project_sales;
            $url_sekarang                           = $request->fullUrl();
            $hasil_kata                             = $request->cari_kata;
            $data['hasil_kata']                     = $hasil_kata;
            $data['lihat_project_sales']         = Master_project_sales::where('nama_project_sales', 'LIKE', '%'.$hasil_kata.'%')
                                                                                ->get();
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.project_sales.lihat', $data);
        }
        else
            return redirect('dashboard/project_sales');
    }

    public function tambah()
    {
        $link_project_sales = 'project_sales';
        if(General::hakAkses($link_project_sales,'tambah') == 'true')
            return view('dashboard.project_sales.tambah');
        else
            return redirect('dashboard/project_sales');
    }

    public function prosestambah(Request $request)
    {
        $link_project_sales = 'project_sales';
        if(General::hakAkses($link_project_sales,'tambah') == 'true')
        {
            $aturan = [
                'nama_project_sales'               => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_project_sales'               => $request->nama_project_sales,
                'created_at'                            => date('Y-m-d H:i:s'),
            ];
            Master_project_sales::insert($data);

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
                    $redirect_halaman  = 'dashboard/project_sales';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/project_sales');
    }

    public function edit($id_project_sales=0)
    {
        $link_project_sales = 'project_sales';
        if(General::hakAkses($link_project_sales,'edit') == 'true')
        {
            $cek_project_sales = Master_project_sales::where('id_project_sales',$id_project_sales)->count();
            if($cek_project_sales != 0)
            {
                $data['edit_project_sales']         = Master_project_sales::where('id_project_sales',$id_project_sales)
                                                                                                    ->first();
                return view('dashboard.project_sales.edit',$data);
            }
            else
                return redirect('dashboard/project_sales');
        }
        else
            return redirect('dashboard/project_sales');
    }

    public function prosesedit($id_project_sales=0, Request $request)
    {
        $link_project_sales = 'project_sales';
        if(General::hakAkses($link_project_sales,'edit') == 'true')
        {
            $cek_project_sales = Master_project_sales::where('id_project_sales',$id_project_sales)->first();
            if(!empty($cek_project_sales))
            {
                $aturan = [
                    'nama_project_sales'    => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
		        	'nama_project_sales'	=> $request->nama_project_sales,
                    'updated_at'                => date('Y-m-d H:i:s')
                ];
                Master_project_sales::where('id_project_sales', $id_project_sales)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/project_sales';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/project_sales');
        }
        else
            return redirect('dashboard/project_sales');
    }

    public function hapus($id_project_sales=0)
    {
        $link_project_sales = 'project_sales';
        if(General::hakAkses($link_project_sales,'hapus') == 'true')
        {
            $cek_project_sales = Master_project_sales::where('id_project_sales',$id_project_sales)->first();
            if(!empty($cek_project_sales))
            {
                Master_project_sales::where('id_project_sales',$id_project_sales)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/project_sales');
        }
        else
            return redirect('dashboard/project_sales');
    }

}