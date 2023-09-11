<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use DB;
use App\Models\Master_level_sistem;
use App\Models\Master_menu;
use App\Models\Master_akses;
use App\Models\Master_divisi;
use App\Models\User;

class LevelSistemController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'lihat') == 'true')
        {
            $data['link_level_sistem']      = $link_level_sistem;
            $url_sekarang                   = $request->fullUrl();
            $data['hasil_kata']             = '';
        	$data['lihat_level_sistems']    = Master_level_sistem::selectRaw('master_level_sistems.id_level_sistems as id_level_sistems,
                                                                            master_level_sistems.nama_level_sistems as nama_level_sistems,
                                                                            sub_level_sistems.nama_level_sistems as nama_sub_level_sistems,
                                                                            nama_divisis')
                                                                    ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                    ->leftJoin('master_level_sistems as sub_level_sistems','master_level_sistems.level_sistems_id','=','sub_level_sistems.id_level_sistems')
                                                                    ->get();
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'                          => $url_sekarang]);
        	return view('dashboard.level_sistem.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'lihat') == 'true')
        {
            $data['link_level_sistem']          = $link_level_sistem;
            $url_sekarang                       = $request->fullUrl();
            $hasil_kata                         = $request->cari_kata;
            $data['hasil_kata']                 = $hasil_kata;
            $data['lihat_level_sistems']        = Master_level_sistem::selectRaw('master_level_sistems.id_level_sistems as id_level_sistems,
                                                                            master_level_sistems.nama_level_sistems as nama_level_sistems,
                                                                            sub_level_sistems.nama_level_sistems as nama_sub_level_sistems,
                                                                            nama_divisis')
                                                                    ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                    ->leftJoin('master_level_sistems as sub_level_sistems','master_level_sistems.level_sistems_id','=','sub_level_sistems.id_level_sistems')
                                                                    ->where('master_level_sistems.nama_level_sistems', 'LIKE', '%'.$hasil_kata.'%')
                                                                    ->orWhere('sub_level_sistems.nama_level_sistems', 'LIKE', '%'.$hasil_kata.'%')
                                                                    ->orWhere('nama_divisis', 'LIKE', '%'.$hasil_kata.'%')
                                                                    ->get();
            session(['halaman'                  => $url_sekarang]);
            session(['hasil_kata'               => $hasil_kata]);
            return view('dashboard.level_sistem.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function tambah()
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'tambah') == 'true')
        {
            $data['tambah_divisis']             = Master_divisi::orderBy('nama_divisis')
                                                                ->get();
            $data['tambah_sub_level_sistems']   = Master_level_sistem::orderBy('nama_level_sistems')
                                                                    ->get();
            $data['tambah_menus']               = Master_menu::where('menus_id',null)
                                                            ->orderBy('order_menus')
                                                            ->get();
            return view('dashboard.level_sistem.tambah',$data);
        }
        else
            return redirect('dashboard/level_sistem');
    }

    public function prosestambah(Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'tambah') == 'true')
        {
            $aturan = [
                'nama_level_sistems'           => 'required',
            ];
            $this->validate($request, $aturan);

            $level_sistems_id = null;
            if(!empty($request->level_sistems_id))
                $level_sistems_id = $request->level_sistems_id;
            
            $divisis_id = null;
            if(!empty($request->divisis_id))
                $divisis_id = $request->divisis_id;

            $data = [
                'nama_level_sistems'    => $request->nama_level_sistems,
                'level_sistems_id'      => $level_sistems_id,
                'divisis_id'            => $divisis_id,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ];
            $id_level_sistems = Master_level_sistem::insertGetId($data);

            foreach ($request->fiturs_id as $fiturs_id)
            {
                $akses_data = [
                    'level_sistems_id'      => $id_level_sistems,
                    'fiturs_id'             => $fiturs_id,
                    'created_at'            => date('Y-m-d H:i:s'),
                    'updated_at'            => date('Y-m-d H:i:s')
                ];
                Master_akses::insert($akses_data);
            }
            
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
                    $redirect_halaman  = 'dashboard/level_sistem';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/level_sistem');
    }

    public function baca($id_level_sistems=0)
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'baca') == 'true')
        {
            $cek_level_sistems = Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
            	$data['baca_admins']			= User::where('level_sistems_id',$id_level_sistems)
                									    ->get();
                $data['baca_menus']             = Master_menu::where('menus_id',null)
                                                                ->orderBy('order_menus')
                                                                ->get();
                $data['baca_level_sistems']     = Master_level_sistem::selectRaw('master_level_sistems.id_level_sistems as id_level_sistems,
                                                                            master_level_sistems.nama_level_sistems as nama_level_sistems,
                                                                            sub_level_sistems.nama_level_sistems as nama_sub_level_sistems,
                                                                            nama_divisis')
                                                                    ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                    ->leftJoin('master_level_sistems as sub_level_sistems','master_level_sistems.level_sistems_id','=','sub_level_sistems.id_level_sistems')
                                                                    ->where('master_level_sistems.id_level_sistems',$id_level_sistems)
                                                                    ->first();
                return view('dashboard.level_sistem.baca',$data);
            }
            else
                return redirect('dashboard/level_sistem');
        }
        else
            return redirect('dashboard/level_sistem');
    }

    public function edit($id_level_sistems=0)
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'edit') == 'true')
        {
            $cek_level_sistems = Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
                $data['edit_divisis']               = Master_divisi::orderBy('nama_divisis')
                                                                    ->get();
                $data['edit_sub_level_sistems']     = Master_level_sistem::orderBy('nama_level_sistems')
                                                                        ->get();
                $data['edit_menus']                 = Master_menu::where('menus_id',null)
                                                                ->orderBy('order_menus')
                                                                ->get();
                $data['edit_level_sistems']         = Master_level_sistem::where('id_level_sistems',$id_level_sistems)
                                                                      ->first();
                return view('dashboard.level_sistem.edit',$data);
            }
            else
                return redirect('dashboard/level_sistem');
        }
        else
            return redirect('dashboard/level_sistem');
    }

    public function prosesedit($id_level_sistems=0, Request $request)
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'edit') == 'true')
        {
            $cek_level_sistems = Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
                $aturan = [
                    'nama_level_sistems'            => 'required',
                ];
                $this->validate($request, $aturan);

                $level_sistems_id = null;
                if(!empty($request->level_sistems_id))
                    $level_sistems_id = $request->level_sistems_id;
                
                $divisis_id = null;
                if(!empty($request->divisis_id))
                    $divisis_id = $request->divisis_id;

                $data = [
                    'nama_level_sistems'    => $request->nama_level_sistems,
                    'level_sistems_id'      => $level_sistems_id,
                    'divisis_id'            => $divisis_id,
                    'updated_at'            => date('Y-m-d H:i:s')
                ];
                Master_level_sistem::where('id_level_sistems', $id_level_sistems)
                                        ->update($data);
                
                Master_akses::where('level_sistems_id',$id_level_sistems)->delete();
                foreach ($request->fiturs_id as $fiturs_id)
                {
                    $akses_data = [
                        'level_sistems_id'      => $id_level_sistems,
                        'fiturs_id'             => $fiturs_id,
                        'created_at'            => date('Y-m-d H:i:s'),
                        'updated_at'            => date('Y-m-d H:i:s'),
                    ];
                    Master_akses::insert($akses_data);
                }

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/level_sistem';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/level_sistem');
        }
        else
            return redirect('dashboard/level_sistem');
    }

    public function hapus($id_level_sistems=0)
    {
        $link_level_sistem = 'level_sistem';
        if(General::hakAkses($link_level_sistem,'hapus') == 'true')
        {
            $cek_level_sistems = Master_level_sistem::where('id_level_sistems',$id_level_sistems)->count();
            if($cek_level_sistems != 0)
            {
                if($id_level_sistems != 1)
                {
                    Master_level_sistem::where('id_level_sistems',$id_level_sistems)->delete();
                    return response()->json(["sukses" => "sukses"], 200);
                }
                else
                    return redirect('dashboard/level_sistem');
            }
            else
                return redirect('dashboard/level_sistem');
        }
        else
            return redirect('dashboard/level_sistem');
    }

}
