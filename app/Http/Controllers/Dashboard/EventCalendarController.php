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
                                            nama_events as title,
                                            mulai_events as start,
                                            selesai_events as end,
                                            CONCAT(DATE_FORMAT(mulai_events, "%d %M %Y %h:%i:%s")," <br/>sampai<br/> ",DATE_FORMAT(selesai_events, "%d %M %Y %h:%i:%s"),"<br/><br/> ",nama_events) as description')
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

    public function mom($tanggal_mulai='')
    {
        if(strtotime($tanggal_mulai) === strtotime(date('Y-m-d'))) {
            $awal_minggu = date('Y-m-d', strtotime('-'.date('w').' days'));
            $tanggal_mulai = date('Y-m-d', strtotime($awal_minggu.' 1 day'));
        }
        $tanggal_selesai = date("Y-m-d", strtotime($tanggal_mulai.' + 6 day'));

        if(General::hakAkses('mom','tambah') == 'true')
        {
            $lihat_moms = Mom::selectRaw('id_moms,
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
                                                status_prioritas_id,
                                                proyek_mom_users,
                                                tenggat_waktu_mom_users,
                                                dikirimkan_mom_users,
                                                tugas_mom_users,
                                                catatan_mom_users,
                                                status_baca_mom_users
                                                ')
                                        ->leftJoin('mom_users','moms.id_moms','=','mom_users.moms_id')
                                        ->whereRaw('tanggal_mulai_moms >= "'.$tanggal_mulai.'"')
                                        ->whereRaw('tanggal_selesai_moms <= "'.$tanggal_selesai.'"')
                                        ->groupBy('id_moms')
                                        ->orderBy('tanggal_mulai_moms','desc')
                                        ->get();
        }
        else
        {
            $lihat_moms = Mom::selectRaw('id_moms,
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
                                        status_prioritas_id,
                                        proyek_mom_users,
                                        tenggat_waktu_mom_users,
                                        dikirimkan_mom_users,
                                        tugas_mom_users,
                                        catatan_mom_users,
                                        status_baca_mom_users
                                        ')
                                ->leftJoin('mom_users','moms.id_moms','=','mom_users.moms_id')
                                ->whereRaw('tanggal_mulai_moms >= "'.$tanggal_mulai.'"')
                                ->whereRaw('tanggal_selesai_moms <= "'.$tanggal_selesai.'"')
                                ->where('mom_users.users_id',Auth::user()->id)
                                ->groupBy('id_moms')
                                ->orderBy('tanggal_mulai_moms','desc')
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
                    'status_baca_mom_users'     => 1,
                    'updated_at'                => date('Y-m-d H:i:s'),
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