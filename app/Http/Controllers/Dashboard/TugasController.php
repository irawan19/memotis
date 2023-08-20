<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\Master_status_tugas;
use App\Models\Mom_user;
use Auth;

class TugasController extends AdminCoreController
{

    public function index($id_status_tugas=0)
    {
        $cek_status_tugas = Master_status_tugas::where('id_status_tugas',$id_status_tugas)
                                                ->first();
        if(!empty($cek_status_tugas))
        {
            $data['lihat_status_tugas'] = $cek_status_tugas;
            $data['lihat_tugas']        = Mom_user::join('moms','mom_users.moms_id','=','moms.id_moms')
                                                ->where('status_tugas_id',$id_status_tugas)
                                                ->where('mom_users.users_id',Auth::user()->id)
                                                ->get();
            return view('dashboard.tugas.lihat',$data);
        }
        else
            return redirect('dashboard');
    }

}