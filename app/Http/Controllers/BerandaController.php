<?php
namespace App\Http\Controllers;

use App\Models\Master_sosial_media;
use App\Models\Master_subscribe;
use Illuminate\Http\Request;
use App\Models\Master_konfigurasi_aplikasi;

class BerandaController extends Controller
{

    public function index()
    {
        $data['lihat_konfigurasi_aplikasis']    = Master_konfigurasi_aplikasi::first();
        return view('beranda',$data);
    }

}