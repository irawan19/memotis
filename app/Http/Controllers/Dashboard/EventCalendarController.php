<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Mom;
use App\Models\Mom_user;
use App\Models\Event;
use Auth;

class EventCalendarController extends AdminCoreController
{
    public function index(Request $request)
    {
        $mulai          = date('Y-m-d', strtotime($request->start));
        $selesai        = date('Y-m-d', strtotime($request->end));
        $lihat_events   = Event::selectRaw('"event" as type,
                                            "event" as title,
                                            mulai_events as start,
                                            selesai_events as end,
                                            nama_events as description')
                                ->whereRaw('DATE(mulai_events) >= "'.$mulai.'"')
                                ->whereRaw('DATE(selesai_events) <= "'.$selesai.'"');
        if(General::hakAkses('mom','tambah') == 'true')
        {
            $lihat_moms = Mom::selectRaw('"mom" as type,
                                        no_moms as title,
                                        tanggal_mulai_moms as start,
                                        tanggal_selesai_moms as end,
                                        CONCAT(judul_moms, " (", kategori_moms, ")<br>venue : ", venue_moms) as description')
                                ->whereRaw('DATE(tanggal_mulai_moms) >= "'.$mulai.'"')
                                ->whereRaw('DATE(tanggal_selesai_moms) <= "'.$selesai.'"')
                                ->union($lihat_events)
                                ->get();
        }
        else
        {
            $lihat_moms = Mom::selectRaw('"mom" as type,
                                        no_moms as title,
                                        tanggal_mulai_moms as start,
                                        tanggal_selesai_moms as end,
                                        CONCAT(judul_moms, " (", kategori_moms, ")<br>venue : ", venue_moms) as description')
                                ->leftJoin('mom_users','moms.id_moms','=','mom_users.moms_id')
                                ->whereRaw('DATE(tanggal_mulai_moms) >= "'.$mulai.'"')
                                ->whereRaw('DATE(tanggal_selesai_moms) <= "'.$selesai.'"')
                                ->where('mom_users.users_id',Auth::user()->id)
                                ->union($lihat_events)
                                ->get();
        }

        $calendar_data = [];
        foreach($lihat_moms as $moms)
        {
            $color = '';
            if($moms->type == 'event')
                $color = '#88bcf7';
            elseif($moms->type == 'mom')
                $color = '#f7888c';

            $calendar_data[] = [
                'title'         => $moms->title,
                'start'         => $moms->start,
                'end'           => $moms->end,
                'description'   => $moms->description,
                'color'         => $color,
                'textColor'     => "#000",
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
                                ->orderBy('tanggal_mulai_moms','asc')
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
                                ->orderBy('tanggal_mulai_moms','asc')
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