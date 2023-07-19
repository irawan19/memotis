<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Auth;
use App\Models\Session;
use App\Models\User;
use App\Models\Master_konfigurasi_aplikasi;

class DashboardController extends AdminCoreController
{
    public function logout(Request $request)
    {
        $check_session = Session::where('user_id',Auth::user()->id)->count();
        if($check_session != 0)
            Session::where('user_id',Auth::user()->id)->delete();

        $users_data = [
            'remember_token' => ''
        ];
        User::where('id',Auth::user()->id)
                ->update($users_data);

        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

    public function index()
    {
        $data['lihat_konfigurasi_aplikasis']    = Master_konfigurasi_aplikasi::first();
        return view('dashboard.dashboard.lihat',$data);
    }

}