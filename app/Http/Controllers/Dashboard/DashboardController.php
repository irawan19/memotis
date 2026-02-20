<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Master_status_tugas;
use Illuminate\Http\Request;
use Auth;
use App\Models\Session;
use App\Models\User;
use App\Models\Master_konfigurasi_aplikasi;
use Storage;
use App\Models\Surat;
use App\Models\Mom;

class DashboardController extends AdminCoreController
{
    public function logout(Request $request)
    {
        $check_session = Session::where('user_id',Auth::user()->id)->count();
        if($check_session != 0)
            Session::where('user_id',Auth::user()->id)->delete();

        $users_data = [
            'remember_token' => ''
        ];
        User::where('id',Auth::user()->id)
                ->update($users_data);

        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

    public function index()
    {
        $data['lihat_konfigurasi_aplikasis']    = Master_konfigurasi_aplikasi::first();
        $data['lihat_status_tugas']             = Master_status_tugas::get();
        $data['boleh_lihat_kalender']           = in_array(Auth::user()->unit_kerjas_id, [1, null], true);
        if(Auth::user()->level_sistems_id == 1)
        {
            $data['total_surats']    	            = Surat::count();
            $data['total_surat_selesais']           = Surat::where('status_selesai_surats',1)->count();
            $data['total_surat_belum_selesais']     = Surat::where('status_selesai_surats',0)->count();
            $data['total_moms']    	                = Mom::count();
        }
        else
        {
            $data['total_surats']    	            = Surat::join('surat_users','surats.id_surats','=','surat_users.surats_id')
                                                                ->where('surat_users.users_id',Auth::user()->id)
                                                                ->orderBy('surats.status_selesai_surats','asc')
                                                                ->count();
            $data['total_surat_selesais']           = Surat::join('surat_users','surats.id_surats','=','surat_users.surats_id')
                                                            ->where('surat_users.users_id',Auth::user()->id)
                                                            ->where('surat_users.status_selesai_surat_users',1)
                                                            ->count();
            $data['total_surat_belum_selesais']     = Surat::join('surat_users','surats.id_surats','=','surat_users.surats_id')
                                                            ->where('surat_users.users_id',Auth::user()->id)
                                                            ->where('surat_users.status_selesai_surat_users',0)
                                                            ->count();
            $data['total_moms']    	                = Mom::join('mom_users','moms.id_moms','=','mom_users.moms_id')
                                                            ->where('mom_users.users_id',Auth::user()->id)
                                                            ->groupBy('moms.id_moms')
                                                            ->count();
        }
        return view('dashboard.dashboard.lihat',$data);
    }

    public function uploadckeditor(Request $request)
    {
        if ($request->hasFile('upload')) {

            $nama_media = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('upload')->getClientOriginalName())));
            $path_media = 'media/';
            Storage::disk('public')->put($path_media.$nama_media, file_get_contents($request->file('upload')));
            $url = asset('storage/media/' . $nama_media);
            return response()->json(['fileName' => $nama_media, 'uploaded'=> 1, 'url' => $url]);
        }
    }

}