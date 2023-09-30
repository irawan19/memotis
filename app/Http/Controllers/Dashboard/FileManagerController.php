<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\General;

class FileManagerController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_file_manager = 'file_manager';
        if(General::hakAkses($link_file_manager,'lihat') == 'true')
        {
            $url_sekarang               = $request->fullUrl();
            session()->forget('halaman');
            session(['halaman'              => $url_sekarang]);
        	return view('dashboard.file_manager.lihat');
        }
        else
            return redirect('dashboard');
    }
}