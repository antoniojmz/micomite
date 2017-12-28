<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Lang;
use Auth;
use Log;

use App\Http\Requests;

class WebController extends Controller{

	public function getHome(){
    	Session::forget('validado');
    	if (!Auth::guest()) {
    		Auth::logout();
    		// Session::flush();
    	}
        $data['title'] = Lang::get('auth.login_browser_title');
        return view('auth.login');
	}

	protected function getRecuperar(Request $request){
        return "hola mi contraseña";
    }
}
