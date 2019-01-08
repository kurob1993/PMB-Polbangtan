<?php

namespace App\Http\Controllers;

use App\Libs\Services\UserService;
use App\Libs\Traits\InfoSiswa;
use Illuminate\Http\Request;
use Redirect;

class HomeController extends Controller
{
	use InfoSiswa;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$data = $request->user()->person;
    	$kelengkapan = true;
    	$state = '';
    	$pendaftaran = '';

    	if ( $request->user()->person_type == 'siswa' ) {
    		$kelengkapan = $this->cekKelengkapanDokumen();
    		$state = $this->getPendaftaranState();
            $pendaftaran = $this->getPendaftaran();
    	}

        return view('home', [
        	'data' => $data,
        	'kelengkapan' => $kelengkapan,
        	'state' => $state,
            'pendaftaran' => $pendaftaran
        ]);
    }

    /**
     * [profile]
     * @param  Request $request
     */
    public function profile(Request $request)
    {
    	$data = $request->user();
    	return view('profile', ['data' => $data]);
    }

    /**
     * [update profile]
     * @param  Request $request
     * @param  int $id
     */
    public function update(Request $request, $id, UserService $service)
    {
        $request->validate([
            'password' => 'required|confirmed',
		]);

        $data = [];
        if ( $request->has('password') && !empty($request->password) ) {
            $data['password'] = bcrypt($request->password);
        }

        $service->updateUser($id, $data);
    	
        return Redirect::to('profile')->withSuccess('Berhasil merubah profile');
    }
}
