<?php

namespace App\Http\Controllers\Comite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use App\Http\Requests\PreingresoRequest;


// Servicios
use App\Services\AuthSrv;
use Illuminate\Http\Response;
use JasperPHP\JasperPHP as JasperPHP;

//Facades
use Auth;
use Lang;
use View;
use Config;
use Mail;
use Redirect;
use Log;

//Models
use App\Models\Cartelera;
use App\Models\Encuestas;

class CarteleraController extends Controller {
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthSrv $authSrv){
        // Esto es de seguridad (invitado)
        $this->middleware('guest', [
            'except' => $authSrv->ValidarAcceso()
        ]);

        // Todas estas rutas son ejecutas solo si estas logeado
        $this->middleware('auth.strict', [
            'only' => $authSrv->ValidarAcceso()
        ]);
    }

    protected function getCartelera(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede = $dat['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['id_cartelera'] = "";
        $dat['nivel'] = $dats['user_portal']['usuario']['id_nivel'];;
        $dat['cantidad'] = 1;
        $dat=json_encode($dat);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $data['title'] = 'Cartelera Informativa';
        $data['id_pantalla'] = 48;
        $result= $model->listCarteleraActivas($dat);
        $data['v_carteleras_activas']=$result[0]->f_consulta_carteleras;
        $model = new Encuestas();
        $data['v_encuestas']=$model->listEpendientes($dat);
        $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
        return View::make('cartelera.cartelera',$data);
    }

    protected function postCartelera(Request $request){
      $data = $request->all();
      $dats = $request->session()->all();
      $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
      $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
      $dat['id_usuario'] = Auth::User()->user_id;
      $data['id_usuario'] = Auth::User()->user_id;
      $dat['id_cartelera'] = "";
      $dat=json_encode($dat);
      $model= new Cartelera();
      $result['f_registro_carteleras']= $model->registrarCartelera($data);
      $resul= $model->listCarteleraActivas($dat);
      $result['v_carteleras']=$resul[0]->f_consulta_carteleras;        
      return $result;
    }
    protected function postActcartelera(Request $request){
      $dats = $request->session()->all();
      $data = $request->all();
      $data ['id_sede'] =$dats['user_portal']['usuario']['id_sede'];
      $data ['id_usuario']  = Auth::User()->user_id;
      $var = json_encode($data);
      $model = new Cartelera();
      $result= $model->listCarteleraActivas($var);
      return $result[0]->f_consulta_carteleras;
    }
}

