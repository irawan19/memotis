<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;
use Storage;
use App\Models\Master_konfigurasi_aplikasi;

class KonfigurasiAplikasiController extends AdminCoreController
{
    public function index()
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(General::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $data['lihat_konfigurasi_aplikasis']       = Master_konfigurasi_aplikasi::first();
            session()->forget('halaman');
            return view('dashboard.konfigurasi_aplikasi.lihat', $data);
        }
        else
            return redirect('dashboard');
    }

    public function prosesedit(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if (General::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'nama_konfigurasi_aplikasis'                => 'required',
                'deskripsi_konfigurasi_aplikasis'           => 'required',
                'keywords_konfigurasi_aplikasis'            => 'required',
                'email_konfigurasi_aplikasis'               => 'required',
            ];
            $this->validate($request, $aturan);

            $telepon_konfigurasi_aplikasis = '';
            if(!empty($request->telepon_konfigurasi_aplikasis))
                $telepon_konfigurasi_aplikasis = $request->telepon_konfigurasi_aplikasis;

            $konfigurasi_aplikasi_data = [
                'nama_konfigurasi_aplikasis'                    => $request->nama_konfigurasi_aplikasis,
                'deskripsi_konfigurasi_aplikasis'               => $request->deskripsi_konfigurasi_aplikasis,
                'keywords_konfigurasi_aplikasis'                => $request->keywords_konfigurasi_aplikasis,
                'email_konfigurasi_aplikasis'                   => $request->email_konfigurasi_aplikasis,
                'telepon_konfigurasi_aplikasis'                 => $telepon_konfigurasi_aplikasis,
                'updated_at'                                    => date('Y-m-d H:i:s'),
            ];
            Master_konfigurasi_aplikasi::query()->update($konfigurasi_aplikasi_data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan)->withInput($request->all());
        }
        else
            return redirect('dashboard');
    }

    public function proseseditlogo(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(General::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_logo'     => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $this->validate($request, $aturan);

            $cek_logo       = Master_konfigurasi_aplikasi::first();
            if (!empty($cek_logo)) {
                $logo_lama        = $cek_logo->logo_konfigurasi_aplikasis;
                if (Storage::disk('public')->exists($logo_lama))
                    Storage::disk('public')->delete($logo_lama);
            }

            $nama_logo = date('Ymd') . date('His') . str_replace(')', '', str_replace('(', '', str_replace(' ', '-', $request->file('userfile_logo')->getClientOriginalName())));
            $path_logo = 'logo/';
            Storage::disk('public')->put($path_logo.$nama_logo, file_get_contents($request->file('userfile_logo')));

            $data = [
                'logo_konfigurasi_aplikasis'    => $path_logo . $nama_logo,
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];

            Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_logo = [
                'alert'                     => 'sukses',
                'text'                      => 'Logo berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_logo', $setelah_simpan_logo);
        }
        else
            return redirect('dashboard');
    }

    public function prosesediticon(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(General::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_icon'             => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $this->validate($request, $aturan);

            $cek_icon       = Master_konfigurasi_aplikasi::first();
            if (!empty($cek_icon)) {
                $icon_lama        = $cek_icon->icon_konfigurasi_aplikasis;
                if (Storage::disk('public')->exists($icon_lama))
                    Storage::disk('public')->delete($icon_lama);
            }

            $nama_icon = date('Ymd') . date('His') . str_replace(')', '', str_replace('(', '', str_replace(' ', '-', $request->file('userfile_icon')->getClientOriginalName())));
            $path_icon = 'logo/';
            Storage::disk('public')->put($path_icon.$nama_icon, file_get_contents($request->file('userfile_icon')));

            $data = [
                'icon_konfigurasi_aplikasis'    => $path_icon . $nama_icon,
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];

            Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_icon = [
                'alert'                     => 'sukses',
                'text'                      => 'Icon berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_icon', $setelah_simpan_icon);
        }
        else
            return redirect('dashboard');
    }

    public function proseseditlogotext(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(General::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_logo_text'            => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $this->validate($request, $aturan);

            $cek_logo_text       = Master_konfigurasi_aplikasi::first();
            if (!empty($cek_logo_text)) {
                $logo_text_lama        = $cek_logo_text->logo_text_konfigurasi_aplikasis;
                if (Storage::disk('public')->exists($logo_text_lama))
                    Storage::disk('public')->delete($logo_text_lama);
            }

            $nama_logo_text = date('Ymd') . date('His') . str_replace(')', '', str_replace('(', '', str_replace(' ', '-', $request->file('userfile_logo_text')->getClientOriginalName())));
            $path_logo_text = 'logo/';
            Storage::disk('public')->put($path_logo_text.$nama_logo_text, file_get_contents($request->file('userfile_logo_text')));

            $data = [
                'logo_text_konfigurasi_aplikasis'   => $path_logo_text . $nama_logo_text,
                'updated_at'                        => date('Y-m-d H:i:s'),
            ];

            Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_logo_text = [
                'alert'                     => 'sukses',
                'text'                      => 'Logo Text berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_logo_text', $setelah_simpan_logo_text);
        }
        else
            return redirect('dashboard');
    }

    public function proseseditgambarsubscribe(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(General::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_gambar_subscribe'     => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $this->validate($request, $aturan);

            $cek_gambar_subscribe       = Master_konfigurasi_aplikasi::first();
            if (!empty($cek_gambar_subscribe)) {
                $gambar_subscribe_lama        = $cek_gambar_subscribe->gambar_subscribe_konfigurasi_aplikasis;
                if (Storage::disk('public')->exists($gambar_subscribe_lama))
                    Storage::disk('public')->delete($gambar_subscribe_lama);
            }

            $nama_gambar_subscribe = date('Ymd') . date('His') . str_replace(')', '', str_replace('(', '', str_replace(' ', '-', $request->file('userfile_gambar_subscribe')->getClientOriginalName())));
            $path_gambar_subscribe = 'logo/';
            Storage::disk('public')->put($path_gambar_subscribe.$nama_gambar_subscribe, file_get_contents($request->file('userfile_gambar_subscribe')));

            $data = [
                'gambar_subscribe_konfigurasi_aplikasis'    => $path_gambar_subscribe . $nama_gambar_subscribe,
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];

            Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_gambar_subscribe = [
                'alert'                     => 'sukses',
                'text'                      => 'Gambar Subscribe berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_gambar_subscribe', $setelah_simpan_gambar_subscribe);
        }
        else
            return redirect('dashboard');
    }
    
    public function proseseditheader(Request $request)
    {
        $link_konfigurasi_aplikasi = 'konfigurasi_aplikasi';
        if(General::hakAkses($link_konfigurasi_aplikasi, 'lihat') == 'true')
        {
            $aturan = [
                'userfile_header'     => 'required|mimes:png,jpg,jpeg,svg',
            ];
            $this->validate($request, $aturan);

            $cek_header       = Master_konfigurasi_aplikasi::first();
            if (!empty($cek_header)) {
                $header_lama        = $cek_header->header_konfigurasi_aplikasis;
                if (Storage::disk('public')->exists($header_lama))
                    Storage::disk('public')->delete($header_lama);
            }

            $nama_header = date('Ymd') . date('His') . str_replace(')', '', str_replace('(', '', str_replace(' ', '-', $request->file('userfile_header')->getClientOriginalName())));
            $path_header = 'logo/';
            Storage::disk('public')->put($path_header.$nama_header, file_get_contents($request->file('userfile_header')));

            $data = [
                'header_konfigurasi_aplikasis'    => $path_header . $nama_header,
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];

            Master_konfigurasi_aplikasi::query()->update($data);

            $setelah_simpan_header = [
                'alert'                     => 'sukses',
                'text'                      => 'Header berhasil diperbarui',
            ];
            return redirect()->back()->with('setelah_simpan_header', $setelah_simpan_header);
        }
        else
            return redirect('dashboard');
    }
}