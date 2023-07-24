<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Mom;

class EventCalendarController extends AdminCoreController
{
    public function index(Request $request)
    {
        $mulai  = date('Y-m-d', strtotime($request->start));
        $selesai= date('Y-m-d', strtotime($request->end));

        $lihat_moms = Mom::whereRaw('DATE(tanggal_mulai_moms) >= "'.$mulai.'"')
                            ->whereRaw('DATE(tanggal_selesai_moms) <= "'.$selesai.'"')
                            ->get();

        $calendar_data = [];
        foreach($lihat_moms as $moms)
        {
            $calendar_data[] = [
                'title'         => $moms->judul_moms,
                'start'         => $moms->tanggal_mulai_moms,
                'end'           => $moms->tanggal_selesai_moms,
                'description'   => 'Venue : '.$moms->venue_moms,
                'color'         => General::randomWarna(),
            ];
        }
        
        return json_encode($calendar_data);
    }

    public function mom($bulan=0, $tahun=0)
    {
        $konversi_bulan = $bulan + 1;
        $data['lihat_event_moms']   = Mom::selectRaw('*,
                                            moms.created_at as tanggal_moms')
                                            ->whereRaw('MONTH(tanggal_mulai_moms) = "'.$konversi_bulan.'"')
                                            ->whereRaw('YEAR(tanggal_selesai_moms) = "'.$tahun.'"')
                                            ->get();
        return view('dashboard.dashboard.cardeventmom',$data);
    }

}