<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Surat;
use App\Models\User;
use App\Models\Surat_user;
use App\Models\Surat_lampiran;
use App\Models\Master_klasifikasi_surat;
use App\Models\Master_derajat_surat;
use App\Models\Master_sifat_surat;
use Auth;
use Storage;

class SuratController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat,'lihat') == 'true')
        {
            $data['link_surat']               = $link_surat;
            $data['hasil_kata']             = '';
            $url_sekarang                   = $request->fullUrl();
            if(General::hakAkses($link_surat,'tambah') == 'true')
            {
                $data['lihat_surats']    	        = Surat::selectRaw('*,
                                                                surats.created_at as tanggal_surats')
                                                            ->join('users','surats.tujuan_users_id','=','users.id')
                                                            ->join('master_klasifikasi_surats','klasifikasi_surats_id','=','master_klasifikasi_surats.id_klasifikasi_surats')
                                                            ->join('master_derajat_surats','derajat_surats_id','=','master_derajat_surats.id_derajat_surats')
                                                            ->join('master_sifat_surats','sifat_surats_id','=','master_sifat_surats.id_sifat_surats')
                                                            ->orderBy('surats.created_at','desc')
                                                            ->paginate(10);
            }
            else
            {
                $data['lihat_surats']    	        = Surat::selectRaw('*,
                                                                surats.created_at as tanggal_surats')
                                                        ->join('users','surats.tujuan_users_id','=','users.id')
                                                        ->join('master_klasifikasi_surats','klasifikasi_surats_id','=','master_klasifikasi_surats.id_klasifikasi_surats')
                                                        ->join('master_derajat_surats','derajat_surats_id','=','master_derajat_surats.id_derajat_surats')
                                                        ->join('master_sifat_surats','sifat_surats_id','=','master_sifat_surats.id_sifat_surats')
                                                        ->leftJoin('surat_users','surats.id_surats','=','surat_users.surats_id')
                                                        ->where('surat_users.users_id',Auth::user()->id)
                                                        ->orderBy('surats.created_at','desc')
                                                        ->paginate(10);
            }
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.surat.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat,'lihat') == 'true')
        {
            $data['link_surat']           = $link_surat;
            $url_sekarang               = $request->fullUrl();
            $hasil_kata                 = $request->cari_kata;
            $data['hasil_kata']         = $hasil_kata;
            if(General::hakAkses($link_surat,'tambah') == 'true')
            {
                $data['lihat_surats']         = Surat::selectRaw('*,
                                                        surats.created_at as tanggal_surats')
                                                    ->join('users','surats.tujuan_users_id','=','users.id')
                                                    ->join('master_klasifikasi_surats','klasifikasi_surats_id','=','master_klasifikasi_surats.id_klasifikasi_surats')
                                                    ->join('master_derajat_surats','derajat_surats_id','=','master_derajat_surats.id_derajat_surats')
                                                    ->join('master_sifat_surats','sifat_surats_id','=','master_sifat_surats.id_sifat_surats')
                                                    ->where('judul_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orderBy('surats.created_at','desc')
                                                    ->paginate(10);
            }
            else
            {
                $data['lihat_surats']    	        = Surat::selectRaw('*,
                                                                surats.created_at as tanggal_surats')
                                                        ->join('users','surats.tujuan_users_id','=','users.id')
                                                        ->join('master_klasifikasi_surats','klasifikasi_surats_id','=','master_klasifikasi_surats.id_klasifikasi_surats')
                                                        ->join('master_derajat_surats','derajat_surats_id','=','master_derajat_surats.id_derajat_surats')
                                                        ->join('master_sifat_surats','sifat_surats_id','=','master_sifat_surats.id_sifat_surats')
                                                        ->leftJoin('surat_users','surats.id_surats','=','surat_users.surats_id')
                                                        ->where('judul_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->where('surat_users.users_id',Auth::user()->id)
                                                        ->orwhere('no_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->where('surat_users.users_id',Auth::user()->id)
                                                        ->orderBy('surats.created_at','desc')
                                                        ->paginate(10);
            }
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.surat.lihat', $data);
        }
        else
            return redirect('dashboard/surat');
    }

    public function tambah()
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat,'tambah') == 'true')
        {
            $data['tambah_klasifikasi_surats']  = Master_klasifikasi_surat::orderBy('nama_klasifikasi_surats')->get();
            $data['tambah_derajat_surats']      = Master_derajat_surat::orderBy('nama_derajat_surats')->get();
            $data['tambah_sifat_surats']        = Master_sifat_surat::orderBy('nama_sifat_surats')->get();
            $data['tambah_users']               = User::join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                    ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                    ->where('id','!=',1)
                                                    ->get();
            return view('dashboard.surat.tambah',$data);
        }
        else
            return redirect('dashboard/surat');
    }

    public function prosestambah(Request $request)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat, 'tambah') == 'true')
        {
            $aturan = [
                'klasifikasi_surats_id'     => 'required',
                'derajat_surats_id'         => 'required',
                'sifat_surats_id'           => 'required',
                'tanggal_surats'            => 'required',
                'judul_surats'              => 'required',
                'perihal_surats'            => 'required',
                'ringkasan_surats'          => 'required',
                'status_agendakan_surats'   => 'required',
                'users_id'                  => 'required',
            ];
            $this->validate($request, $aturan);

            $no_asal_surat = '';
            if(!empty($request->no_asal_surats))
                $no_asal_surat = $request->no_asal_surats;
            
            $asal_surats = '';
            if(!empty($request->asal_surats))
                $asal_surats = $request->asal_surats;
            
            $tanggal_asal_surats = null;
            if(!empty($request->tanggal_asal_surats))
                $tanggal_asal_surats = General::ubahTanggalKeDB($request->tanggal_asal_surats);

            if(!empty($request->tanggal_surats))
            {
                $tanggal_surats         = explode(' sampai ', $request->tanggal_surats);
                $tanggal_mulai_surats   = General::ubahTanggalKeDB($tanggal_surats[0]);
                $tanggal_selesai_surats = General::ubahTanggalKeDB($tanggal_surats[1]);
            }
            else
            {
                $tanggal_mulai_surats   = null;
                $tanggal_selesai_surats = null;
            }
            
            $keterangan_surats = '';
            if(!empty($request->keterangan_surats))
                $keterangan_surats = $request->keterangan_surats;

            $surats_data = [
                'klasifikasi_surats_id'     => $request->klasifikasi_surats_id,
                'derajat_surats_id'         => $request->derajat_surats_id,
                'sifat_surats_id'           => $request->sifat_surats_id,
                'tujuan_users_id'           => $request->users_id,
                'dibuat_users_id'           => Auth::user()->id,
                'no_surats'                 => General::generateNoSurat(),
                'no_asal_surats'            => $no_asal_surat,
                'asal_surats'               => $asal_surats,
                'judul_surats'              => $request->judul_surats,
                'tanggal_asal_surats'       => $tanggal_asal_surats,
                'tanggal_mulai_surats'      => $tanggal_mulai_surats,
                'tanggal_selesai_surats'    => $tanggal_selesai_surats,
                'perihal_surats'            => $request->perihal_surats,
                'ringkasan_surats'          => $request->ringkasan_surats,
                'keterangan_surats'         => $keterangan_surats,
                'status_agendakan_surats'   => $request->status_agendakan_surats,
                'created_at'                => date('Y-m-d H:i:s'),
            ];
            $id_surats = Surat::insertGetId($surats_data);

            if(!empty($request->lampiran))
            {
                foreach($request->input('lampiran', []) as $file) {
                    $surat_lampirans_data = [
                        'surats_id'             => $id_surats,
                        'file_surat_lampirans'  => 'lampiran/'.$file,
                        'created_at'            => date('Y-m-d H:i:s'),
                    ];
                    Surat_lampiran::insert($surat_lampirans_data);
                }
            }

            if(request()->session()->get('halaman') != '')
                $redirect_halaman  = request()->session()->get('halaman');
            else
                $redirect_halaman  = 'dashboard/surat';

            return redirect($redirect_halaman);
        }
        else
            return redirect('dashboard/surat');
    }

    public function uploadlampiran(Request $request)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat, 'tambah') == 'true')
        {
            $path = public_path('storage/lampiran');

            $file = $request->file('file');
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $file->move($path, $name);

            return response()->json([
                'name'          => $name,
                'original_name' => $file->getClientOriginalName(),
            ],200);
        }
        else
            return response()->json(['error' => 'error'], 400);
    }

    public function hapuslampiran(Request $request)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat, 'tambah') == 'true')
        {
            Storage::disk('public')->delete('lampiran/'.$request->file);

            return response()->json([
                'success' => 'success'
            ],200);
        }
        else
            return response()->json(['error' => 'error'], 400);
    }

    public function edit($id_surats=0)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat, 'edit') == 'true')
        {
            $cek_surats = Surat::where('id_surats',$id_surats)->first();
            if(!empty($cek_surats))
            {
                $data['edit_surats']                = $cek_surats;
                $data['edit_klasifikasi_surats']    = Master_klasifikasi_surat::orderBy('nama_klasifikasi_surats')->get();
                $data['edit_derajat_surats']        = Master_derajat_surat::orderBy('nama_derajat_surats')->get();
                $data['edit_sifat_surats']          = Master_sifat_surat::orderBy('nama_sifat_surats')->get();
                $data['edit_users']                 = User::join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                            ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                            ->where('id','!=',1)
                                                            ->get();
                $data['edit_surat_lampirans']       = Surat_lampiran::where('surats_id',$id_surats)->get();
                return view('dashboard.surat.edit',$data);
            }
            else
                return redirect('dashboard/surat');
        }
        else
            return redirect('dashboard/surat');
    }

    public function prosesedit($id_surats=0, Request $request)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat,'edit') == 'true')
        {
            $cek_surats = Surat::where('id_surats',$id_surats)->count();
            if($cek_surats != 0)
            {
                $aturan = [
                    'klasifikasi_surats_id'     => 'required',
                    'derajat_surats_id'         => 'required',
                    'sifat_surats_id'           => 'required',
                    'judul_surats'              => 'required',
                    'perihal_surats'            => 'required',
                    'ringkasan_surats'          => 'required',
                    'status_agendakan_surats'   => 'required',
                    'users_id'                  => 'required',
                ];
                $this->validate($request, $aturan);
    
                $no_asal_surat = '';
                if(!empty($request->no_asal_surats))
                    $no_asal_surat = $request->no_asal_surats;
                
                $asal_surats = '';
                if(!empty($request->asal_surats))
                    $asal_surats = $request->asal_surats;
                
                $tanggal_asal_surats = null;
                if(!empty($request->tanggal_asal_surats))
                    $tanggal_asal_surats = General::ubahTanggalKeDB($request->tanggal_asal_surats);
                
                if(!empty($request->tanggal_surats))
                {
                    $tanggal_surats         = explode(' sampai ', $request->tanggal_surats);
                    $tanggal_mulai_surats   = General::ubahTanggalKeDB($tanggal_surats[0]);
                    $tanggal_selesai_surats = General::ubahTanggalKeDB($tanggal_surats[1]);
                }
                else
                {
                    $tanggal_mulai_surats   = null;
                    $tanggal_selesai_surats = null;
                }
                
                $keterangan_surats = '';
                if(!empty($request->keterangan_surats))
                    $keterangan_surats = $request->keterangan_surats;
    
                $surats_data = [
                    'klasifikasi_surats_id'     => $request->klasifikasi_surats_id,
                    'derajat_surats_id'         => $request->derajat_surats_id,
                    'sifat_surats_id'           => $request->sifat_surats_id,
                    'tujuan_users_id'           => $request->users_id,
                    'dibuat_users_id'           => Auth::user()->id,
                    'no_surats'                 => General::generateNoSurat(),
                    'no_asal_surats'            => $no_asal_surat,
                    'asal_surats'               => $asal_surats,
                    'judul_surats'              => $request->judul_surats,
                    'tanggal_asal_surats'       => $tanggal_asal_surats,
                    'tanggal_mulai_surats'      => $tanggal_mulai_surats,
                    'tanggal_selesai_surats'    => $tanggal_selesai_surats,
                    'perihal_surats'            => $request->perihal_surats,
                    'ringkasan_surats'          => $request->ringkasan_surats,
                    'keterangan_surats'         => $keterangan_surats,
                    'status_agendakan_surats'   => $request->status_agendakan_surats,
                    'updated_at'                => date('Y-m-d H:i:s'),
                ];
                $id_surats = Surat::insertGetId($surats_data);

                Surat_lampiran::where('surats_id',$id_surats)
                                ->delete();
    
                if(!empty($request->lampiran))
                {
                    foreach($request->input('lampiran', []) as $file) {
                        $surat_lampirans_data = [
                            'surats_id'             => $id_surats,
                            'file_surat_lampirans'  => 'lampiran/'.$file,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ];
                        Surat_lampiran::insert($surat_lampirans_data);
                    }
                }
    
                if(request()->session()->get('halaman') != '')
                    $redirect_halaman  = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/surat';
    
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/surat');
        }
        else
            return redirect('dashboard/surat');
    }

    public function detail($id_surats=0)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat,'baca') == 'true')
        {
            $cek_surats = Surat::where('id_surats',$id_surats)->count();
            if($cek_surats != 0)
            {
                $status_baca_data = [
                    'status_baca_surat_users' => 1,
                ];
                Surat_user::where('surats_id',$id_surats)
                        ->where('users_id',Auth::user()->id)
                        ->update($status_baca_data);
                return response()->json(['success' => 'success'], 200);
            }
            else
                return response()->json(["error" => "error"], 400);
        }
        else
            return response()->json(["error" => "error"], 400);
    }

    public function hapus($id_surats=0)
    {
        $link_surat = 'surat';
        if(General::hakAkses($link_surat,'hapus') == 'true')
        {
            $cek_surats = Surat::where('id_surats',$id_surats)->first();
            if(!empty($cek_surats))
            {
                $ambil_surat_lampirans = Surat_lampiran::where('surats_id',$id_surats)->get();
                foreach($ambil_surat_lampirans as $surat_lampirans)
                {
                    Storage::disk('public')->delete($surat_lampirans->file_lampirans);
                }
                Surat_lampiran::where('surats_id',$id_surats)
                                ->delete();
                Surat::where('id_surats',$id_surats)
                    ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/surat');
        }
        else
            return redirect('dashboard/surat');
    }
}