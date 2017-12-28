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
use App\Models\Comite;
use App\Models\Cartelera;
use App\Models\Encuestas;

class ComiteController extends Controller {
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

    protected function getComite(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = 1;
        $datas=json_encode($dat);
        $dat['nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($datas);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $model = new Comite();
        $data['id_pantalla'] = 50;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        switch ($dat['nivel']) {
            case 2:
                $data['title'] = 'Registro de Comité';
                $dat['id_sede'] = $id_sede;
                $dat['id_usuario'] = "";
                $dat['caso'] = "";
                $dat['cargo'] = "";
                $dat=json_encode($dat);
                $result = $model->listaUsuariosComites($dat);
                $data['v_personas_comites'] = $result[0]->f_registro_comite;
                return View::make('comite.comiteAdmin',$data);
            break;
            case 3:
                $data['v_comites']= $model->listaComites($id_sede);
                $data['title'] = 'Integrantes del Comité';
                $model = new Encuestas();
                $data['v_encuestas']=$model->listEpendientes($datas);
                $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
            return View::make('comite.comiteUsuario',$data);
            break;
            default:
                $result='{"code":"-2", "des_code":"Acceso no autorizado"}';
            break;
        }
    }


    protected function postComite(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede'] = $dats['user_portal']['usuario']['id_sede'];
        $data['id_usuario'] = $data['user_id'];
        $data=json_encode($data);
        $model= new Comite();
        $result = $model->listaUsuariosComites($data);
        $result = $result[0]->f_registro_comite;
        return $result;
    }

   
}