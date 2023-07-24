<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Surat;
use App\Models\User;
use App\Models\Surat_user;
use App\Models\Master_klasifikasi_surat;
use App\Models\Master_derajat_surat;
use App\Models\Master_sifat_surat;
use Auth;

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
                                                        ->orderBy('surats.created_at','desc')
                                                        ->paginate(10);
            }
            else
            {
                $data['lihat_surats']    	        = Surat::selectRaw('*,
                                                                surats.created_at as tanggal_surats')
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
                                                    ->where('judul_surats', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orderBy('surats.created_at','desc')
                                                    ->paginate(10);
            }
            else
            {
                $data['lihat_surats']    	        = Surat::selectRaw('*,
                                                                surats.created_at as tanggal_surats')
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
}