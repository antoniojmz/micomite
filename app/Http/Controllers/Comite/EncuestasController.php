<?php
namespace App\Http\Controllers\Comite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\Encuestas;
use App\Models\Cartelera;;

class EncuestasController extends Controller {
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
//////////////////Registrar encuestas///////////////
    protected function getEncuesta(Request $request){
        $dats = $request->session()->all();
        $data['nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede=$dat['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = "";
        $dat=json_encode($dat);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['title'] = 'Encuestas';
        $model = new Encuestas();
        $data['id_pantalla'] = 54;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        switch ($data['nivel']){
            case 2:
                // Caso comite
                $data['v_encuestas']= $model->listEncuestasActivas($id_sede);
                return View::make('encuestas.encuestasA',$data);
            break;
            case 3:
                // Caso usuario
                $data['v_encuestasA']=$model->listEpendientes($dat);
                $data['v_encuestasA']=$data['v_encuestasA'][0]->f_consulta_encuesta;
                $dat2['id_sede']=$dats['user_portal']['usuario']['id_sede'];
                $dat2['id_usuario'] = Auth::User()->user_id;
                $dat2['cantidad'] = 1;
                $dat2=json_encode($dat2);
                $data['v_encuestas']=$model->listEpendientes($dat2);
                $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
                return View::make('encuestas.encuestasU',$data);
            break;
            default:
                $result='{"code":"-2", "des_code":"Acceso no autorizado"}';
            break;
        }
    }

    protected function postEncuesta(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $data=json_encode($data);
        $data = str_replace(array("\r","\n","\r\n","\\n","\\r"),' ',$data);
        $model= new Encuestas();
        $result['f_registro_encuesta']= $model->regEncuesta($data);
        $result['v_encuestas']= $model->listEncuestasActivas($id_sede);
        return $result;
    }

    protected function postEncuestaO(Request $request){
        $data = $request->all();
        $id_encuesta=$data['id_encuesta'];
        $model= new Encuestas();
        $result['v_opciones']= $model->listOpcion($id_encuesta);
        return $result;
    }
    protected function postEncuestaP(Request $request){
        $data = $request->all();
        $id_encuesta=$data['id_encuesta2'];
        $model= new Encuestas();
        $result['f_result']= $model->regOpcion($data);
        $result['v_opciones']= $model->listOpcion($id_encuesta);
        return $result;
    }
    protected function postEncuestaD(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $id_encuesta=$data['id_encuesta'];
        $model= new Encuestas();
        $result['f_result']= $model->delEncuesta($data);
        $result['v_encuestas']= $model->listEncuestasActivas($id_sede);
        return $result;
    }
    protected function postEncuestaR(Request $request){
        $data = $request->all();
        $id_encuesta=$data['id_encuesta'];
        $model= new Encuestas();
        $resultados= $model->listResultados($id_encuesta);
        return $resultados;
    }
    protected function postEncuestaE(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $model= new Encuestas();
        $data['id_usuario']=Auth::User()->user_id;
        $data=json_encode($data);
        $result['f_votar_encuesta']= $model->procesarVoto($data);
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = "";
        $dat=json_encode($dat);
        $result['v_encuestasA']=$model->listEpendientes($dat);
        $result['v_encuestasA']=$result['v_encuestasA'][0]->f_consulta_encuesta;
        $dat2['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat2['id_usuario'] = Auth::User()->user_id;
        $dat2['cantidad'] = 1;
        $dat2=json_encode($dat2);
        $result['v_encuestas']=$model->listEpendientes($dat);
        $result['v_encuestas']=$result['v_encuestas'][0]->f_consulta_encuesta;
        return $result;
    }
}