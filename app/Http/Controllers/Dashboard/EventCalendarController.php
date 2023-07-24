<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Mom;
use App\Models\Mom_user;
use Auth;

class EventCalendarController extends AdminCoreController
{
    public function index(Request $request)
    {
        $mulai  = date('Y-m-d', strtotime($request->start));
        $selesai= date('Y-m-d', strtotime($request->end));
        if(General::hakAkses('mom','tambah') == 'true')
        {
            $lihat_moms = Mom::whereRaw('DATE(tanggal_mulai_moms) >= "'.$mulai.'"')
                                ->whereRaw('DATE(tanggal_selesai_moms) <= "'.$selesai.'"')
                                ->get();
        }
        else
        {
            $lihat_moms = Mom::leftJoin('mom_users','moms.id_moms','=','mom_users.moms_id')
                                ->whereRaw('DATE(tanggal_mulai_moms) >= "'.$mulai.'"')
                                ->whereRaw('DATE(tanggal_selesai_moms) <= "'.$selesai.'"')
                                ->where('mom_users.users_id',Auth::user()->id)
                                ->get();
        }

        $calendar_data = [];
        foreach($lihat_moms as $moms)
        {
            $calendar_data[] = [
                'title'         => $moms->no_moms,
                'start'         => $moms->tanggal_mulai_moms,
                'end'           => $moms->tanggal_selesai_moms,
                'description'   => $moms->judul_moms,
                'color'         => General::randomWarna(),
            ];
        }
        
        return json_encode($calendar_data);
    }

    public function mom($bulan=0, $tahun=0)
    {
        $konversi_bulan = $bulan + 1;
        if(General::hakAkses('mom','tambah') == 'true')
        {
            $lihat_moms = Mom::selectRaw('*,
                                moms.created_at as tanggal_moms')
                                ->whereRaw('MONTH(tanggal_mulai_moms) = "'.$konversi_bulan.'"')
                                ->whereRaw('YEAR(tanggal_selesai_moms) = "'.$tahun.'"')
                                ->get();
        }
        else
        {
            $lihat_moms = Mom::selectRaw('*,
                                moms.created_at as tanggal_moms')
                                ->leftJoin('mom_users','moms.id_moms','=','mom_users.moms_id')
                                ->whereRaw('MONTH(tanggal_mulai_moms) = "'.$konversi_bulan.'"')
                                ->whereRaw('YEAR(tanggal_selesai_moms) = "'.$tahun.'"')
                                ->where('mom_users.users_id',Auth::user()->id)
                                ->get();
        }
        $data['lihat_event_moms']   = $lihat_moms;
        return view('dashboard.dashboard.cardeventmom',$data);
    }

    public function detail($id_moms=0)
    {
        $link_mom = 'mom';
        if(General::hakAkses($link_mom,'baca') == 'true')
        {
            $cek_moms = Mom::where('id_moms',$id_moms)->count();
            if($cek_moms != 0)
            {
                $status_baca_data = [
                    'status_baca_mom_users' => 1,
                ];
                Mom_user::where('moms_id',$id_moms)
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

}