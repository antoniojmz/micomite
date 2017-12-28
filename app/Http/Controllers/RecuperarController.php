<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// Facades
use Session;
use Lang;
use Hash;
use Auth;
use View;
use Log;
use Crypt;
use SerializesModels;
use DB;

use App\Http\Requests;
//Models
use App\Models\User;
use App\Models\Contacto;
class RecuperarController extends Controller{

    protected function getRecuperar(Request $request){
      $data['title'] = 'Recuperar Contraseña';
      return View::make('recuperar.recuperar',$data);
    }
    protected function postRecuperar(Request $request){
      $data = $request->all();
      $model = new User();
      $result= $model->recuperarPass($data);
      return $result;
    }

    protected function postContacto(Request $request){
      $data = $request->all();
      $model = new Contacto();
      $result= $model->enviarContacto($data);
      return $result;
    }

    protected function postPerfil(Request $request){
      $data = $request->all();
      $model = new Contacto();
      $result= $model->buscarPerfil($data);
      return $result;
    }
}