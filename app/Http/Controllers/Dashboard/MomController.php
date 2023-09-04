<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Mom;
use App\Models\User;
use App\Models\Mom_user;
use App\Models\Mom_user_external;
use App\Models\Master_status_tugas;
use Auth;

class MomController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'lihat') == 'true')
        {
            $data['link_mom']               = $link_mom;
            $data['hasil_kata']             = '';
            $url_sekarang                   = $request->fullUrl();
            if(General::hakAkses($link_mom,'tambah') == 'true')
            {
                $data['lihat_moms']    	        = Mom::selectRaw('id_moms,
                                                                moms.moms_id as sub_moms_id,
                                                                moms.users_id as created_users,
                                                                kategori_moms,
                                                                no_moms,
                                                                judul_moms,
                                                                tanggal_mulai_moms,
                                                                tanggal_selesai_moms,
                                                                venue_moms,
                                                                deskripsi_moms,
                                                                moms.created_at as tanggal_moms,
                                                                mom_users.moms_id as moms_id,
                                                                mom_users.users_id as users_id,
                                                                status_tugas_id,
                                                                proyek_mom_users,
                                                                tenggat_waktu_mom_users,
                                                                dikirimkan_mom_users,
                                                                tugas_mom_users,
                                                                catatan_mom_users,
                                                                status_baca_mom_users
                                                                ')
                                                        ->orderBy('moms.tanggal_mulai_moms','desc')
                                                        ->groupBy('id_moms')
                                                        ->paginate(10);
            }
            else
            {
                $data['lihat_moms']    	        = Mom::selectRaw('id_moms,
                                                                moms.moms_id as sub_moms_id,
                                                                moms.users_id as created_users,
                                                                kategori_moms,
                                                                no_moms,
                                                                judul_moms,
                                                                tanggal_mulai_moms,
                                                                tanggal_selesai_moms,
                                                                venue_moms,
                                                                deskripsi_moms,
                                                                moms.created_at as tanggal_moms,
                                                                mom_users.moms_id as moms_id,
                                                                mom_users.users_id as users_id,
                                                                status_tugas_id,
                                                                proyek_mom_users,
                                                                tenggat_waktu_mom_users,
                                                                dikirimkan_mom_users,
                                                                tugas_mom_users,
                                                                catatan_mom_users,
                                                                status_baca_mom_users
                                                                ')
                                                        ->leftJoin('mom_users','moms.id_moms','=','mom_users.moms_id')
                                                        ->where('mom_users.users_id',Auth::user()->id)
                                                        ->groupBy('moms.id_moms')
                                                        ->orderBy('moms.tanggal_mulai_moms','desc')
                                                        ->paginate(10);
            }
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
            if(General::hakAkses($link_mom,'tambah') == 'true')
            {
                $data['lihat_moms']         = Mom::selectRaw('id_moms,
                                                                    moms.moms_id as sub_moms_id,
                                                                    moms.users_id as created_users,
                                                                    kategori_moms,
                                                                    no_moms,
                                                                    judul_moms,
                                                                    tanggal_mulai_moms,
                                                                    tanggal_selesai_moms,
                                                                    venue_moms,
                                                                    deskripsi_moms,
                                                                    moms.created_at as tanggal_moms,
                                                                    mom_users.moms_id as moms_id,
                                                                    mom_users.users_id as users_id,
                                                                    status_tugas_id,
                                                                    proyek_mom_users,
                                                                    tenggat_waktu_mom_users,
                                                                    dikirimkan_mom_users,
                                                                    tugas_mom_users,
                                                                    catatan_mom_users,
                                                                    status_baca_mom_users
                                                                    ')
                                                    ->where('judul_moms', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->groupBy('id_moms')
                                                    ->orderBy('moms.tanggal_mulai_moms','desc')
                                                    ->paginate(10);
            }
            else
            {
                $data['lihat_moms']    	        = Mom::selectRaw('id_moms,
                                                                    moms.moms_id as sub_moms_id,
                                                                    moms.users_id as created_users,
                                                                    kategori_moms,
                                                                    no_moms,
                                                                    judul_moms,
                                                                    tanggal_mulai_moms,
                                                                    tanggal_selesai_moms,
                                                                    venue_moms,
                                                                    deskripsi_moms,
                                                                    moms.created_at as tanggal_moms,
                                                                    mom_users.moms_id as moms_id,
                                                                    mom_users.users_id as users_id,
                                                                    status_tugas_id,
                                                                    proyek_mom_users,
                                                                    tenggat_waktu_mom_users,
                                                                    dikirimkan_mom_users,
                                                                    tugas_mom_users,
                                                                    catatan_mom_users,
                                                                    status_baca_mom_users
                                                                    ')
                                                        ->leftJoin('mom_users','moms.id_moms','=','mom_users.moms_id')
                                                        ->where('judul_moms', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->where('mom_users.users_id',Auth::user()->id)
                                                        ->orwhere('no_moms', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->where('mom_users.users_id',Auth::user()->id)
                                                        ->groupBy('id_moms')
                                                        ->orderBy('moms.tanggal_mulai_moms','desc')
                                                        ->paginate(10);
            }
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
        {
            $data['tambah_sub_moms']            = Mom::orderBy('no_moms')->get();
            $data['tambah_status_tugas']        = Master_status_tugas::get();
            $data['tambah_mom_user_externals']  = Mom_user_external::groupBy('nama_user_externals')
                                                                    ->get();
            return view('dashboard.mom.tambah',$data);
        }
        else
            return redirect('dashboard/mom');
    }

    public function prosestambah(Request $request)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true')
        {
            $aturan = [
                'judul_moms'                => 'required',
                'tanggal_moms'              => 'required',
                'venue_moms'                => 'required',
                'deskripsi_moms'            => 'required',
            ];
            $this->validate($request, $aturan);

            $tanggal_moms           = $request->tanggal_moms;
            $pecah_tanggal_moms     = explode(' sampai ',$tanggal_moms);
            $tanggal_mulai_moms     = $pecah_tanggal_moms[0];
            $tanggal_selesai_moms   = $pecah_tanggal_moms[1];

            $moms_id = null;
            if(!empty($request->sub_moms_id))
                $moms_id = $request->sub_moms_id;

            $kategori_moms = 'Internal';
            if(!empty($request->nama_user_externals))
                $kategori_moms = 'External';

            $data = [
                'moms_id'                   => $moms_id,
                'kategori_moms'             => $kategori_moms,
                'no_moms'                   => General::generateNoMOM(),
                'users_id'                  => Auth::user()->id,
                'tanggal_mulai_moms'        => General::ubahTanggalwaktuKeDB($tanggal_mulai_moms),
                'tanggal_selesai_moms'      => General::ubahTanggalwaktuKeDB($tanggal_selesai_moms),
                'venue_moms'                => $request->venue_moms,
                'judul_moms'                => $request->judul_moms,
                'deskripsi_moms'            => $request->deskripsi_moms,
                'created_at'                => date('Y-m-d H:i:s'),
            ];
            $id_moms = Mom::insertGetId($data);

            if(!empty($request->nama_user_externals))
            {
                foreach($request->nama_user_externals as $nama_user_externals)
                {
                    $mom_user_externals_data = [
                        'moms_id'               => $id_moms,
                        'nama_user_externals'   => $nama_user_externals,
                        'created_at'            => date('Y-m-d H:i:s')
                    ];
                    Mom_user_external::insert($mom_user_externals_data);
                }
            }

            if($moms_id != null)
            {
                $ambil_mom_users = Mom_user::where('moms_id',$moms_id)->get();
                foreach($ambil_mom_users as $mom_users)
                {
                    $mom_users_data = [
                        'moms_id'               => $id_moms,
                        'users_id'              => $mom_users->users_id,
                        'status_tugas_id'       => $mom_users->status_tugas_id,
                        'proyek_mom_users'      => $mom_users->proyek_mom_users,
                        'tenggat_waktu_mom_users'=> $mom_users->tenggat_waktu_mom_users,
                        'dikirimkan_mom_users'  => $mom_users->dikirimkan_mom_users,
                        'tugas_mom_users'       => $mom_users->tugas_mom_users,
                        'catatan_mom_users'     => $mom_users->catatan_mom_users,
                        'status_baca_mom_users' => 0,
                        'created_at'            => date('Y-m-d H:i:s'),
                    ];
                    Mom_user::insert($mom_users_data);
                }
            }

            return redirect('dashboard/mom/tugas/'.$id_moms);
        }
        else
            return redirect('dashboard/mom');
    }

    public function tugas($id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true' || General::hakAkses($link_mom,'edit' == 'true'))
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->first();
            if(!empty($cek_moms))
            {
                $data['lihat_moms']                 = $cek_moms;
                $data['lihat_mom_users']            = Mom_user::join('users','users_id','=','users.id')
                                                                ->join('master_status_tugas','status_tugas_id','=','master_status_tugas.id_status_tugas')
                                                                ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                                ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                ->where('moms_id',$id_moms)
                                                                ->orderBy('proyek_mom_users','asc')
                                                                ->get();
                $data['tambah_status_tugas']        = Master_status_tugas::get();
                $data['tambah_users']               = User::join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                            ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                            ->where('id','!=',1)
                                                            ->get();
                return view('dashboard.mom.tugas',$data);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

    public function prosestambahtugas(Request $request, $id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true' || General::hakAkses($link_mom,'edit' == 'true'))
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->count();
            if($cek_moms != 0)
            {
                $aturan = [
                    'users_id'              => 'required',
                    'proyek_mom_users'      => 'required',
                    'tugas_mom_users'       => 'required',
                    'status_tugas_id'       => 'required',
                    'catatan_mom_users'     => 'required',
                    
                ];
                $this->validate($request, $aturan);

                $tenggat_waktu_mom_users = null;
                if(!empty($request->tenggat_waktu_mom_users))
                    $tenggat_waktu_mom_users = General::ubahTanggalKeDB($request->tenggat_waktu_mom_users);

                $dikirimkan_mom_users = '';
                if(!empty($request->dikirimkan_mom_users))
                    $dikirimkan_mom_users = $request->dikirimkan_mom_users;
    
                $data = [
                    'moms_id'               => $id_moms,
                    'users_id'              => $request->users_id,
                    'proyek_mom_users'      => $request->proyek_mom_users,
                    'tenggat_waktu_mom_users'=> $tenggat_waktu_mom_users,
                    'dikirimkan_mom_users'  => $dikirimkan_mom_users,
                    'tugas_mom_users'       => $request->tugas_mom_users,
                    'status_tugas_id'       => $request->status_tugas_id,
                    'catatan_mom_users'     => $request->catatan_mom_users,
                    'created_at'            => date('Y-m-d H:i:s'),
                ];
                Mom_user::insert($data);
                
                $redirect_halaman  = 'dashboard/mom/tugas/'.$id_moms;
    
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

    public function edittugas($id_mom_users=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true' || General::hakAkses($link_mom,'edit' == 'true'))
        {
            $cek_mom_users = Mom_user::where('id_mom_users',$id_mom_users)->first();
            if(!empty($cek_mom_users))
            {
                $ambil_moms                         = Mom::where('id_moms',$cek_mom_users->moms_id)->first();
                $data['lihat_moms']                 = $ambil_moms;
                $data['lihat_mom_users']            = Mom_user::join('users','users_id','=','users.id')
                                                                ->join('master_status_tugas','status_tugas_id','=','master_status_tugas.id_status_tugas')
                                                                ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                                ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                ->where('moms_id',$ambil_moms->id_moms)
                                                                ->get();
                $data['edit_status_tugas']          = Master_status_tugas::get();
                $data['edit_mom_users']             = Mom_user::join('master_status_tugas','status_tugas_id','=','master_status_tugas.id_status_tugas')
                                                                ->join('users','mom_users.users_id','=','users.id')
                                                                ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                                ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                                ->where('id_mom_users',$id_mom_users)
                                                                ->first();
                return view('dashboard.mom.tugas',$data);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

    public function prosesedittugas(Request $request, $id_mom_users=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true' || General::hakAkses($link_mom,'edit' == 'true'))
        {
            $cek_mom_users = Mom_user::where('id_mom_users',$id_mom_users)->first();
            if(!empty($cek_mom_users))
            {
                $ambil_moms                         = Mom::where('id_moms',$cek_mom_users->moms_id)->first();
                $aturan = [
                    'proyek_mom_users'      => 'required',
                    'tugas_mom_users'       => 'required',
                    'status_tugas_id'       => 'required',
                    'catatan_mom_users'     => 'required',
                    
                ];
                $this->validate($request, $aturan);

                $tenggat_waktu_mom_users = null;
                if(!empty($request->tenggat_waktu_mom_users))
                    $tenggat_waktu_mom_users = General::ubahTanggalKeDB($request->tenggat_waktu_mom_users);

                $dikirimkan_mom_users = '';
                if(!empty($request->dikirimkan_mom_users))
                    $dikirimkan_mom_users = $request->dikirimkan_mom_users;
    
                $data = [
                    'proyek_mom_users'      => $request->proyek_mom_users,
                    'tenggat_waktu_mom_users'=> $tenggat_waktu_mom_users,
                    'dikirimkan_mom_users'  => $dikirimkan_mom_users,
                    'tugas_mom_users'       => $request->tugas_mom_users,
                    'status_tugas_id'       => $request->status_tugas_id,
                    'catatan_mom_users'     => $request->catatan_mom_users,
                    'updated_at'            => date('Y-m-d H:i:s'),
                ];
                Mom_user::where('id_mom_users', $id_mom_users)
                        ->update($data);

                return redirect('dashboard/mom/tugas/'.$ambil_moms->id_moms);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

    public function proseshapustugas($id_mom_users=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'tambah') == 'true' || General::hakAkses($link_mom,'edit' == 'true'))
        {
            $cek_mom_users = Mom_user::where('id_mom_users',$id_mom_users)->first();
            if(!empty($cek_mom_users))
            {
                Mom_user::where('id_mom_users',$id_mom_users)
                                ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/mom');
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
                $data['edit_sub_moms']              = Mom::orderBy('no_moms')->where('id_moms','!=',$id_moms)->get();
                $data['edit_status_tugas']          = Master_status_tugas::get();
                $data['edit_moms']                  = Mom::where('id_moms',$id_moms)
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
                    'judul_moms'                => 'required',
                    'tanggal_moms'              => 'required',
                    'venue_moms'                => 'required',
                    'deskripsi_moms'            => 'required',
                ];
                $this->validate($request, $aturan);
    
                $tanggal_moms           = $request->tanggal_moms;
                $pecah_tanggal_moms     = explode(' sampai ',$tanggal_moms);
                $tanggal_mulai_moms     = $pecah_tanggal_moms[0];
                $tanggal_selesai_moms   = $pecah_tanggal_moms[1];

                $moms_id = null;
                if(!empty($request->sub_moms_id))
                    $moms_id = $request->sub_moms_id;
    
                $kategori_moms = 'Internal';
                if(!empty($request->nama_user_externals))
                    $kategori_moms = 'External';
    
                $data = [
                    'moms_id'                   => $moms_id,
                    'kategori_moms'             => $kategori_moms,
                    'users_id'                  => Auth::user()->id,
                    'tanggal_mulai_moms'        => General::ubahTanggalwaktuKeDB($tanggal_mulai_moms),
                    'tanggal_selesai_moms'      => General::ubahTanggalwaktuKeDB($tanggal_selesai_moms),
                    'venue_moms'                => $request->venue_moms,
                    'judul_moms'                => $request->judul_moms,
                    'deskripsi_moms'            => $request->deskripsi_moms,
                    'updated_at'                => date('Y-m-d H:i:s'),
                ];
                Mom::where('id_moms', $id_moms)
                    ->update($data);

                Mom_user_external::where('moms_id',$id_moms)->delete();
                if(!empty($request->nama_user_externals))
                {
                    foreach($request->nama_user_externals as $nama_user_externals)
                    {
                        $mom_user_externals_data = [
                            'moms_id'               => $id_moms,
                            'nama_user_externals'   => $nama_user_externals,
                            'created_at'            => date('Y-m-d H:i:s')
                        ];
                        Mom_user_external::insert($mom_user_externals_data);
                    }
                }

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
                Mom_user_external::where('moms_id',$id_moms)
                                ->delete();
                Mom_user::where('moms_id',$id_moms)
                        ->delete();
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

    public function cetak($id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'cetak') == 'true')
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->count();
            if($cek_moms != 0)
            {
                $data['lihat_moms'] = Mom::selectRaw('*,
                                                    moms.created_at as tanggal_moms')
                                            ->where('id_moms',$id_moms)
                                            ->first();
                return view('dashboard.mom.cetak',$data);
            }
            else
                return redirect('dashboard/mom');
        }
        else
            return redirect('dashboard/mom');
    }

    public function ambilmom($id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'cetak') == 'true')
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->first();
            if(!empty($cek_moms))
            {
                return response()->json(["data" => $cek_moms, "pesan" => "sukses"], 200);
            }
            else
                return response()->json(["pesan" => "error"], 400);
        }
        else
            return response()->json(["pesan" => "error"], 400);
    }

    public function ambilmomuserexternal($id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'cetak') == 'true')
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->count();
            if($cek_moms != 0)
            {
                $ambil_mom_users = Mom_user_external::where('moms_id',$id_moms)->get();
                return response()->json(["data" => $ambil_mom_users, "pesan" => "sukses"], 200);
            }
            else
                return response()->json(["pesan" => "error"], 400);
        }
        else
            return response()->json(["pesan" => "error"], 400);
    }

}