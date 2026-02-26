<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Aktivitas_sales;
use App\Models\Master_kegiatan_sales;
use App\Models\Master_segmentasi_sales;
use App\Models\Master_status_sales;
use App\Models\Master_project_sales;
use App\Models\User;
use Auth;

class AktivitasSalesController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if(General::hakAkses($link_aktivitas_sales,'lihat') == 'true')
        {
            $data['link_aktivitas_sales'] = $link_aktivitas_sales;
            $data['hasil_kata']            = $request->get('cari_kata', '');
            $data['hasil_bulan']          = $request->get('cari_bulan', '');
            $data['hasil_tahun']          = $request->get('cari_tahun', '');
            $url_sekarang                  = $request->fullUrl();
            $hasil_kata                    = $data['hasil_kata'];

            $query = Aktivitas_sales::join('master_kegiatan_sales','aktivitas_sales.kegiatan_sales_id','=','master_kegiatan_sales.id_kegiatan_sales')
                ->join('master_segmentasi_sales','aktivitas_sales.segmentasi_sales_id','=','master_segmentasi_sales.id_segmentasi_sales')
                ->join('master_project_sales','aktivitas_sales.project_sales_id','=','master_project_sales.id_project_sales')
                ->leftJoin('master_status_sales','aktivitas_sales.status_sales_id','=','master_status_sales.id_status_sales')
                ->join('users','aktivitas_sales.users_id','=','users.id')
                ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                ->leftJoin('master_divisis','master_level_sistems.divisis_id','=','master_divisis.id_divisis');

            if(Auth::user()->level_sistems_id != 1) {
                $query->where('aktivitas_sales.users_id', Auth::user()->id);
            }
            if($hasil_kata !== '') {
                $query->where(function($q) use ($hasil_kata) {
                    $q->where('master_kegiatan_sales.nama_kegiatan_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_segmentasi_sales.nama_segmentasi_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.nama_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.pic_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.kontak_personal_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_project_sales.nama_project_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_status_sales.nama_status_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.jangka_waktu_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhereRaw('CAST(aktivitas_sales.total_aktivitas_sales AS CHAR) LIKE ?', ['%'.$hasil_kata.'%'])
                        ->orWhere('aktivitas_sales.catatan_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%');
                });
            }
            if($data['hasil_bulan'] !== '' && $data['hasil_tahun'] !== '') {
                $query->whereMonth('aktivitas_sales.tanggal_aktivitas_sales', (int)$data['hasil_bulan'])
                    ->whereYear('aktivitas_sales.tanggal_aktivitas_sales', (int)$data['hasil_tahun']);
            }
            $data['lihat_aktivitas_sales'] = $query->orderBy('aktivitas_sales.tanggal_aktivitas_sales','desc')->paginate(20)->withQueryString();

            session()->forget('halaman');
            session(['halaman' => $url_sekarang]);
            session(['hasil_kata' => $data['hasil_kata'], 'hasil_bulan' => $data['hasil_bulan'], 'hasil_tahun' => $data['hasil_tahun']]);
            return view('dashboard.aktivitas_sales.lihat', $data);
        }
        return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if(General::hakAkses($link_aktivitas_sales,'lihat') == 'true')
        {
            $data['link_aktivitas_sales'] = $link_aktivitas_sales;
            $data['hasil_kata']            = $request->get('cari_kata', '');
            $data['hasil_bulan']          = $request->get('cari_bulan', '');
            $data['hasil_tahun']          = $request->get('cari_tahun', '');
            $url_sekarang                  = $request->fullUrl();
            $hasil_kata                    = $data['hasil_kata'];

            $query = Aktivitas_sales::join('master_kegiatan_sales','aktivitas_sales.kegiatan_sales_id','=','master_kegiatan_sales.id_kegiatan_sales')
                ->join('master_segmentasi_sales','aktivitas_sales.segmentasi_sales_id','=','master_segmentasi_sales.id_segmentasi_sales')
                ->join('master_project_sales','aktivitas_sales.project_sales_id','=','master_project_sales.id_project_sales')
                ->leftJoin('master_status_sales','aktivitas_sales.status_sales_id','=','master_status_sales.id_status_sales')
                ->join('users','aktivitas_sales.users_id','=','users.id')
                ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                ->leftJoin('master_divisis','master_level_sistems.divisis_id','=','master_divisis.id_divisis');

            if(Auth::user()->level_sistems_id != 1) {
                $query->where('aktivitas_sales.users_id', Auth::user()->id);
            }
            if($hasil_kata !== '') {
                $query->where(function($q) use ($hasil_kata) {
                    $q->where('master_kegiatan_sales.nama_kegiatan_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_segmentasi_sales.nama_segmentasi_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.nama_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.pic_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.kontak_personal_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_project_sales.nama_project_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('master_status_sales.nama_status_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhere('aktivitas_sales.jangka_waktu_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%')
                        ->orWhereRaw('CAST(aktivitas_sales.total_aktivitas_sales AS CHAR) LIKE ?', ['%'.$hasil_kata.'%'])
                        ->orWhere('aktivitas_sales.catatan_aktivitas_sales', 'LIKE', '%'.$hasil_kata.'%');
                });
            }
            if($data['hasil_bulan'] !== '' && $data['hasil_tahun'] !== '') {
                $query->whereMonth('aktivitas_sales.tanggal_aktivitas_sales', (int)$data['hasil_bulan'])
                    ->whereYear('aktivitas_sales.tanggal_aktivitas_sales', (int)$data['hasil_tahun']);
            }
            $data['lihat_aktivitas_sales'] = $query->orderBy('aktivitas_sales.tanggal_aktivitas_sales','desc')->paginate(20)->withQueryString();

            session(['halaman' => $url_sekarang]);
            session(['hasil_kata' => $data['hasil_kata'], 'hasil_bulan' => $data['hasil_bulan'], 'hasil_tahun' => $data['hasil_tahun']]);
            return view('dashboard.aktivitas_sales.lihat', $data);
        }
        return redirect('dashboard/aktivitas_sales');
    }

    public function cetakexcel()
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if (General::hakAkses($link_aktivitas_sales, 'cetak') == 'true') {
            $hasil_bulan = session('hasil_bulan', '');
            $hasil_tahun = session('hasil_tahun', '');
            $label = 'Aktivitas Sales';
            if ($hasil_bulan !== '' && $hasil_tahun !== '') {
                $label = 'Aktivitas Sales ' . General::ubahDBKeBulan($hasil_bulan) . ' ' . $hasil_tahun;
            }
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\AktivitasSalesExport,
                $label . '.xlsx'
            );
        }
        return redirect('dashboard/aktivitas_sales');
    }

    public function tambah()
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if(General::hakAkses($link_aktivitas_sales,'tambah') == 'true')
        {
            $data['tambah_kegiatan_sales']      = Master_kegiatan_sales::orderBy('nama_kegiatan_sales','asc')->get();
            $data['tambah_segmentasi_sales']    = Master_segmentasi_sales::orderBy('nama_segmentasi_sales','asc')->get();
            $data['tambah_status_sales']        = Master_status_sales::orderBy('nama_status_sales','asc')->get();
            $data['tambah_project_sales']       = Master_project_sales::orderBy('nama_project_sales','asc')->get();
            $data['tambah_users']               = User::join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                        ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                        ->orderBy('name')->get();
            return view('dashboard.aktivitas_sales.tambah',$data);
        }
        else
            return redirect('dashboard/aktivitas_sales');
    }

    public function prosestambah(Request $request)
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if(General::hakAkses($link_aktivitas_sales,'tambah') == 'true')
        {
            if(Auth::user()->level_sistems_id == 1) {
                $aturan = [
                    'users_id'                          => 'required',
                    'kegiatan_sales_id'                 => 'required',
                    'segmentasi_sales_id'               => 'required',
                    'project_sales_id'                  => 'required',
                    'status_sales_id'                   => 'required',
                    'tanggal_aktivitas_sales'           => 'required',
                    'nama_aktivitas_sales'              => 'required',
                    'alamat_aktivitas_sales'            => 'required',
                    'pic_aktivitas_sales'               => 'required',
                    'total_aktivitas_sales'             => 'required',
                ];
            } else {
                $aturan = [
                    'kegiatan_sales_id'                 => 'required',
                    'segmentasi_sales_id'               => 'required',
                    'project_sales_id'                  => 'required',
                    'status_sales_id'                   => 'required',
                    'tanggal_aktivitas_sales'           => 'required',
                    'nama_aktivitas_sales'              => 'required',
                    'alamat_aktivitas_sales'            => 'required',
                    'pic_aktivitas_sales'               => 'required',
                    'total_aktivitas_sales'             => 'required',
                ];
            }
            $this->validate($request, $aturan);

            $kontak_personal_aktivitas_sales = '';
            if(!empty($request->kontak_personal_aktivitas_sales))
                $kontak_personal_aktivitas_sales = $request->kontak_personal_aktivitas_sales;

            $jangka_waktu_aktivitas_sales = '';
            if(!empty($request->jangka_waktu_aktivitas_sales))
                $jangka_waktu_aktivitas_sales = $request->jangka_waktu_aktivitas_sales;

            $catatan_aktivitas_sales = '';
            if(!empty($request->catatan_aktivitas_sales))
                $catatan_aktivitas_sales = $request->catatan_aktivitas_sales;

            $room_revenue = 0;
            if ($request->has('room_revenue') && $request->room_revenue !== null && $request->room_revenue !== '')
                $room_revenue = General::ubahHargaKeDB($request->room_revenue);
            $banquet_revenue = 0;
            if ($request->has('banquet_revenue') && $request->banquet_revenue !== null && $request->banquet_revenue !== '')
                $banquet_revenue = General::ubahHargaKeDB($request->banquet_revenue);

            $users_id = Auth::user()->id;
            if(Auth::user()->level_sistems_id == 1)
                $users_id = $request->users_id;

            $data = [
                'users_id'                          => $users_id,
                'kegiatan_sales_id'                 => $request->kegiatan_sales_id,
                'segmentasi_sales_id'               => $request->segmentasi_sales_id,
                'project_sales_id'                  => $request->project_sales_id,
                'status_sales_id'                   => $request->status_sales_id,
                'tanggal_aktivitas_sales'           => General::ubahTanggalKeDB($request->tanggal_aktivitas_sales),
                'nama_aktivitas_sales'              => $request->nama_aktivitas_sales,
                'alamat_aktivitas_sales'            => $request->alamat_aktivitas_sales,
                'pic_aktivitas_sales'               => $request->pic_aktivitas_sales,
                'kontak_personal_aktivitas_sales'   => $kontak_personal_aktivitas_sales,
                'jangka_waktu_aktivitas_sales'      => $jangka_waktu_aktivitas_sales,
                'room_revenue'                      => $room_revenue,
                'banquet_revenue'                   => $banquet_revenue,
                'total_aktivitas_sales'             => General::ubahHargaKeDB($request->total_aktivitas_sales),
                'catatan_aktivitas_sales'           => $catatan_aktivitas_sales,
                'created_at'                        => date('Y-m-d H:i:s'),
            ];
            Aktivitas_sales::insert($data);

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
                    $redirect_halaman  = 'dashboard/aktivitas_sales';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/aktivitas_sales');
    }

    public function edit($id_aktivitas_sales=0)
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if(General::hakAkses($link_aktivitas_sales,'edit') == 'true')
        {
            $cek_aktivitas_sales = Aktivitas_sales::where('id_aktivitas_sales',$id_aktivitas_sales)->count();
            if($cek_aktivitas_sales != 0)
            {
                $data['edit_kegiatan_sales']        = Master_kegiatan_sales::orderBy('nama_kegiatan_sales','asc')->get();
                $data['edit_segmentasi_sales']      = Master_segmentasi_sales::orderBy('nama_segmentasi_sales','asc')->get();
                $data['edit_status_sales']          = Master_status_sales::orderBy('nama_status_sales','asc')->get();
                $data['edit_project_sales']         = Master_project_sales::orderBy('nama_project_sales','asc')->get();
                $data['edit_users']                 = User::join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                        ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                        ->orderBy('name')->get();
                $data['edit_aktivitas_sales']       = Aktivitas_sales::where('id_aktivitas_sales',$id_aktivitas_sales)
                                                                        ->first();
                return view('dashboard.aktivitas_sales.edit',$data);
            }
            else
                return redirect('dashboard/aktivitas_sales');
        }
        else
            return redirect('dashboard/aktivitas_sales');
    }

    public function prosesedit($id_aktivitas_sales=0, Request $request)
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if(General::hakAkses($link_aktivitas_sales,'edit') == 'true')
        {
            $cek_aktivitas_sales = Aktivitas_sales::where('id_aktivitas_sales',$id_aktivitas_sales)->first();
            if(!empty($cek_aktivitas_sales))
            {
                if (Auth::user()->level_sistems_id == 1) {
                    $aturan = [
                        'users_id'                          => 'required',
                        'kegiatan_sales_id'                 => 'required',
                        'segmentasi_sales_id'               => 'required',
                        'project_sales_id'                  => 'required',
                        'status_sales_id'                   => 'required',
                        'tanggal_aktivitas_sales'           => 'required',
                        'nama_aktivitas_sales'              => 'required',
                        'alamat_aktivitas_sales'            => 'required',
                        'pic_aktivitas_sales'               => 'required',
                        'total_aktivitas_sales'             => 'required',
                    ];
                } else {
                    $aturan = [
                        'kegiatan_sales_id'                 => 'required',
                        'segmentasi_sales_id'               => 'required',
                        'project_sales_id'                  => 'required',
                        'status_sales_id'                   => 'required',
                        'tanggal_aktivitas_sales'           => 'required',
                        'nama_aktivitas_sales'              => 'required',
                        'alamat_aktivitas_sales'            => 'required',
                        'pic_aktivitas_sales'               => 'required',
                        'total_aktivitas_sales'             => 'required',
                    ];
                }
                $this->validate($request, $aturan);
    
                $kontak_personal_aktivitas_sales = '';
                if(!empty($request->kontak_personal_aktivitas_sales))
                    $kontak_personal_aktivitas_sales = $request->kontak_personal_aktivitas_sales;
    
                $jangka_waktu_aktivitas_sales = '';
                if(!empty($request->jangka_waktu_aktivitas_sales))
                    $jangka_waktu_aktivitas_sales = $request->jangka_waktu_aktivitas_sales;
    
                $catatan_aktivitas_sales = '';
                if(!empty($request->catatan_aktivitas_sales))
                    $catatan_aktivitas_sales = $request->catatan_aktivitas_sales;

                $room_revenue = $cek_aktivitas_sales->room_revenue ?? 0;
                if ($request->has('room_revenue') && $request->room_revenue !== null && $request->room_revenue !== '')
                    $room_revenue = General::ubahHargaKeDB($request->room_revenue);
                $banquet_revenue = $cek_aktivitas_sales->banquet_revenue ?? 0;
                if ($request->has('banquet_revenue') && $request->banquet_revenue !== null && $request->banquet_revenue !== '')
                    $banquet_revenue = General::ubahHargaKeDB($request->banquet_revenue);

                $users_id = Auth::user()->id;
                if(Auth::user()->level_sistems_id == 1)
                    $users_id = $request->users_id;
    
                $data = [
                    'users_id'                          => $users_id,
                    'kegiatan_sales_id'                 => $request->kegiatan_sales_id,
                    'segmentasi_sales_id'               => $request->segmentasi_sales_id,
                    'project_sales_id'                  => $request->project_sales_id,
                    'status_sales_id'                   => $request->status_sales_id,
                    'tanggal_aktivitas_sales'           => General::ubahTanggalKeDB($request->tanggal_aktivitas_sales),
                    'nama_aktivitas_sales'              => $request->nama_aktivitas_sales,
                    'alamat_aktivitas_sales'            => $request->alamat_aktivitas_sales,
                    'pic_aktivitas_sales'               => $request->pic_aktivitas_sales,
                    'kontak_personal_aktivitas_sales'   => $kontak_personal_aktivitas_sales,
                    'jangka_waktu_aktivitas_sales'      => $jangka_waktu_aktivitas_sales,
                    'room_revenue'                      => $room_revenue,
                    'banquet_revenue'                   => $banquet_revenue,
                    'total_aktivitas_sales'             => General::ubahHargaKeDB($request->total_aktivitas_sales),
                    'catatan_aktivitas_sales'           => $catatan_aktivitas_sales,
                    'updated_at'                        => date('Y-m-d H:i:s'),
                ];
                Aktivitas_sales::where('id_aktivitas_sales', $id_aktivitas_sales)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/aktivitas_sales';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/aktivitas_sales');
        }
        else
            return redirect('dashboard/aktivitas_sales');
    }

    public function hapus($id_aktivitas_sales=0)
    {
        $link_aktivitas_sales = 'aktivitas_sales';
        if(General::hakAkses($link_aktivitas_sales,'hapus') == 'true')
        {
            $cek_aktivitas_sales = Aktivitas_sales::where('id_aktivitas_sales',$id_aktivitas_sales)->first();
            if(!empty($cek_aktivitas_sales))
            {
                Aktivitas_sales::where('id_aktivitas_sales',$id_aktivitas_sales)
                                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/aktivitas_sales');
        }
        else
            return redirect('dashboard/aktivitas_sales');
    }
}