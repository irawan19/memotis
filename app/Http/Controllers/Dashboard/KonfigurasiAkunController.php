<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class KonfigurasiAkunController extends AdminCoreController
{
    public function index()
    {
        session()->forget('halaman');
       	return view('dashboard.konfigurasi_akun.lihat');
    }

    public function prosesedit(Request $request)
    {
    	$id_users = Auth::user()->id;
    	if(!empty($request->password))
    	{
	        $aturan = [
                'username'          => 'required|unique:users,username,'.$id_users.',id',
                'email'             => 'required|unique:users,email,'.$id_users.',id',
                'password'			=> 'required'
            ];
            $this->validate($request, $aturan);

	        $data = [
                'username'              => $request->username,
	        	'email'					=> $request->email,
	            'updated_at'          	=> date('Y-m-d H:i:s'),
	            'password'            	=> bcrypt($request->password),
	        ];
	    }
	    else
	    {
	        $aturan = [
                'username'          => 'required|unique:users,username,'.$id_users.',id',
                'email'             => 'required|unique:users,email,'.$id_users.',id',
            ];
            $this->validate($request, $aturan);

	        $data = [
                'username'              => $request->username,
	        	'email'					=> $request->email,
	            'updated_at'          	=> date('Y-m-d H:i:s'),
	        ];
	    }

        User::where('id',$id_users)->update($data);

        $setelah_simpan = [
    	    'alert'  => 'sukses',
    	    'text'   => 'Akun berhasil diperbarui',
    	];
    	return redirect()->back()->with('setelah_simpan', $setelah_simpan)->withInput($request->all());
    }
}