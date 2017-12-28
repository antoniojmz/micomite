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
use App\Models\Apartamentos;


class ApartamentosController extends Controller {
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

    protected function getApartamentos(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['id_cartelera'] = "";
        $dat['nivel'] = $dats['user_portal']['usuario']['id_nivel'];
        $model = new Apartamentos();
        $data['v_usuariosAptos']=$model->listUsuariosAptos($dat);
        $dat=json_encode($dat);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['id_pantalla'] = 60;
        $data['title'] = 'Apartamentos';
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        return View::make('apartamentos.apartamentos',$data);
    }

    protected function postApartamentos(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede'] = $dats['user_portal']['usuario']['id_sede'];
        $data['id_usuario'] = $data['user_id'];
        $dat=json_encode($data);
        $model= new Apartamentos();
        $result['f_registro_apartamento'] = $model->regApartamento($dat);
        $result['v_usuariosAptos'] = $model->listUsuariosAptos($data);
        return $result;
    }

    protected function postUsuapartamentos(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede'] = $dats['user_portal']['usuario']['id_sede'];
        $model= new Apartamentos();
        $result=$model->listAptosUsuarios($data);
        return $result;
    }

    protected function postDelapartamentos(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede'] = $dats['user_portal']['usuario']['id_sede'];
        $model= new Apartamentos();
        $result['f_del_apartamento'] =$model->delApartamento($data);
        $result['v_aptosUsuarios']=$model->listAptosUsuarios($data);
        $result['v_usuariosAptos']=$model->listUsuariosAptos($data);
        return $result;
    }  
}