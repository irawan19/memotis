<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\Master_level_sistem;
use App\Models\Master_status_tugas;
use App\Models\Mom_user;
use Auth;
use DB;

class TugasController extends AdminCoreController
{

    public function index($id_status_tugas=0)
    {
        $cek_status_tugas = Master_status_tugas::where('id_status_tugas',$id_status_tugas)
                                                ->first();
        if(!empty($cek_status_tugas))
        {
            $data['lihat_status_tugas'] = $cek_status_tugas;
            $ambil_divisis = Master_level_sistem::where('id_level_sistems',Auth::user()->level_sistems_id)
                                                ->first();
            if(Auth::user()->level_sistems_id == 1 || $ambil_divisis->divisis_id == null)
            {
                $data['lihat_tugas']        = Mom_user::join('moms','mom_users.moms_id','=','moms.id_moms')
                                                    ->join('users','mom_users.users_id','=','users.id')
                                                    ->join('master_level_sistems','users.level_sistems_id','=','master_level_sistems.id_level_sistems')
                                                    ->leftJoin('master_divisis','divisis_id','=','master_divisis.id_divisis')
                                                    ->whereRaw('moms.id_moms IN (SELECT max(id_moms) FROM moms JOIN mom_users ON mom_users.moms_id=moms.id_moms WHERE status_tugas_id = '.$id_status_tugas.' GROUP BY tugas_mom_users)')
                                                    ->where('status_tugas_id',$id_status_tugas)
                                                    ->orderBy('moms.created_at','desc')
                                                    ->get();
            }
            else
            {
                $data['lihat_tugas']        = Mom_user::join('moms','mom_users.moms_id','=','moms.id_moms')
                                                    ->whereRaw('moms.id_moms IN (SELECT max(id_moms) FROM moms JOIN mom_users ON mom_users.moms_id=moms.id_moms WHERE status_tugas_id = '.$id_status_tugas.' AND mom_users.users_id = '.Auth::user()->id.' GROUP BY tugas_mom_users)')
                                                    ->where('status_tugas_id',$id_status_tugas)
                                                    ->where('mom_users.users_id',Auth::user()->id)
                                                    ->orderBy('moms.created_at','desc')
                                                    ->get();
            }
            return view('dashboard.tugas.lihat',$data);
        }
        else
            return redirect('dashboard');
    }

}