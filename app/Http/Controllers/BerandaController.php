<?php
namespace App\Http\Controllers;

use App\Models\Master_sosial_media;
use App\Models\Master_konfigurasi_aplikasi;

class BerandaController extends Controller
{

    public function index()
    {
        $data['lihat_konfigurasi_aplikasis']    = Master_konfigurasi_aplikasi::first();
        $data['lihat_sosial_medias']            = Master_sosial_media::get();
        return view('beranda',$data);
    }

}