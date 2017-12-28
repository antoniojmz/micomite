<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Servicios
use App\Services\AuthSrv;
// use Illuminate\Http\Response;
// use JasperPHP\JasperPHP as JasperPHP;

//Facades
use Auth;
use Lang;
use View;
use Config;
use Log;

//Models
use App\Models\User;

class ModulosPoderesController extends Controller {
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

////////////////////////////////Modulos Poderes///////////////////////////////////////////////////////////////////
    protected function getModulosPoderes(Request $request){
        $dats = $request->session()->all();
        $data['title'] = 'Módulos poderes';
        $data['id_pantalla'] = 15;
        $model = new User();
        $data['moduloscombo'] = $model->ModulosCombo();
        $data['poderescombo'] = $model->PoderesCombo();
        $data['TablaModulosPoderes'] = $model->TablaModulosPoderes(0);
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        return View::make('adm.modulos_poderes', $data);
    }

    protected function postListarModulosPoderes(Request $request){
        $model = new User();
        $data = $model->TablaModulosPoderes($request->input('rel_id_modulo'));
        return $data;
    }

    protected function postDeleteModulosPoderes(Request $request){
        $model = new User();
        $model->DeleteModulo_poder($request->input('id_tipo_modulo_poder'));
        return $model->TablaModulosPoderes(0);
    }

    protected function postAddModulosPoderes(Request $request){
        $model = new User();
        $result = $model->AddModulo_poder(
            $request->input('poderes'), $request->input('id_tipo_modulo_id_modulo'));
        return $model->TablaModulosPoderes(0);
    }
}