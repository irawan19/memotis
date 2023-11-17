<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use App\Models\Event;

class EventController extends AdminCoreController
{

    public function index(Request $request)
    {
        $link_event = 'event';
        if(General::hakAkses($link_event,'lihat') == 'true')
        {
            $data['link_event']         = $link_event;
            $data['hasil_kata']         = '';
            $url_sekarang               = $request->fullUrl();
        	$data['lihat_events']    	= Event::orderBy('mulai_events','desc')
                                                ->paginate(25);
            session()->forget('halaman');
            session()->forget('hasil_kata');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.event.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function cari(Request $request)
    {
        $link_event = 'event';
        if(General::hakAkses($link_event,'lihat') == 'true')
        {
            $data['link_event']         = $link_event;
            $url_sekarang               = $request->fullUrl();
            $hasil_kata                 = $request->cari_kata;
            $data['hasil_kata']         = $hasil_kata;
            $data['lihat_events']       = Event::where('nama_events', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('mulai_events','desc')
                                                ->paginate(25);
            session(['halaman'              => $url_sekarang]);
            session(['hasil_kata'		    => $hasil_kata]);
            return view('dashboard.event.lihat', $data);
        }
        else
            return redirect('dashboard/event');
    }

    public function tambah()
    {
        $link_event = 'event';
        if(General::hakAkses($link_event,'tambah') == 'true')
            return view('dashboard.event.tambah');
        else
            return redirect('dashboard/event');
    }

    public function prosestambah(Request $request)
    {
        $link_event = 'event';
        if(General::hakAkses($link_event,'tambah') == 'true')
        {
            $aturan = [
                'tanggal_events'            => 'required',
                'nama_events'               => 'required',
            ];
            $this->validate($request, $aturan);

            $tanggal_events         = $request->tanggal_events;
            $pecah_tanggal_events   = explode(' sampai ',$tanggal_events);
            $mulai_events           = General::ubahTanggalwaktuKeDB($pecah_tanggal_events[0]);
            $selesai_events         = General::ubahTanggalwaktuKeDB($pecah_tanggal_events[1]);

            $data = [
                'mulai_events'              => $mulai_events,
                'selesai_events'            => $selesai_events,
                'nama_events'               => $request->nama_events,
                'created_at'                => date('Y-m-d H:i:s'),
            ];
            Event::insert($data);

            $simpan           = $request->simpan;
            $simpan_kembali   = $request->simpan_kembali;
            if($simpan)
            {
                $setelah_simpan = [
                    'alert'  => 'sukses',
                    'text'   => 'Data berhasil ditambahkan',
                ];
    	    	return redirect()->back()->with('setelah_simpan', $setelah_simpan)->withInput($request->all());
            }
            if($simpan_kembali)
            {
                if(request()->session()->get('halaman') != '')
                    $redirect_halaman  = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/event';

                return redirect($redirect_halaman);
            }
        }
        else
            return redirect('dashboard/event');
    }

    public function edit($id_events=0)
    {
        $link_event = 'event';
        if(General::hakAkses($link_event,'edit') == 'true')
        {
            $cek_events = Event::where('id_events',$id_events)->count();
            if($cek_events != 0)
            {
                $data['edit_events']         = Event::where('id_events',$id_events)
                                                    ->first();
                return view('dashboard.event.edit',$data);
            }
            else
                return redirect('dashboard/event');
        }
        else
            return redirect('dashboard/event');
    }

    public function prosesedit($id_events=0, Request $request)
    {
        $link_event = 'event';
        if(General::hakAkses($link_event,'edit') == 'true')
        {
            $cek_events = Event::where('id_events',$id_events)->first();
            if(!empty($cek_events))
            {
                $aturan = [
                    'tanggal_events'    => 'required',
                    'nama_events'       => 'required',
                ];
                $this->validate($request, $aturan);

                $tanggal_events         = $request->tanggal_events;
                $pecah_tanggal_events   = explode(' sampai ',$tanggal_events);
                $mulai_events           = General::ubahTanggalwaktuKeDB($pecah_tanggal_events[0]);
                $selesai_events         = General::ubahTanggalwaktuKeDB($pecah_tanggal_events[1]);

                $data = [
                    'mulai_events'  => $mulai_events,
                    'selesai_events'=> $selesai_events,
		        	'nama_events'	=> $request->nama_events,
                    'updated_at'    => date('Y-m-d H:i:s')
                ];
                Event::where('id_events', $id_events)
                                        ->update($data);

                if(request()->session()->get('halaman') != '')
                    $redirect_halaman    = request()->session()->get('halaman');
                else
                    $redirect_halaman  = 'dashboard/event';
                
                return redirect($redirect_halaman);
            }
            else
                return redirect('dashboard/event');
        }
        else
            return redirect('dashboard/event');
    }

    public function hapus($id_events=0)
    {
        $link_event = 'event';
        if(General::hakAkses($link_event,'hapus') == 'true')
        {
            $cek_events = Event::where('id_events',$id_events)->first();
            if(!empty($cek_events))
            {
                Event::where('id_events',$id_events)
                    ->delete();
                return response()->json(["sukses" => "sukses"], 200);
            }
            else
                return redirect('dashboard/event');
        }
        else
            return redirect('dashboard/event');
    }

}