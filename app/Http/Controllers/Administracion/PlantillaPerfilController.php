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

class PlantillaPerfilController extends Controller {
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

////////////////////////////////Plantilla Perfil///////////////////////////////////////////////////////////////////
    protected function getPlantillaNivel(Request $request){
        $dats = $request->session()->all();
        $data['title'] = 'Plantilla perfil';
        $data['id_pantalla'] = 14;
        $model = new User();
        $data['nivelcombo'] = $model->NivelesCombo();
        $data['moduloscombo'] = $model->ModulosCombo();
        $data['poderescombo'] = $model->PoderesCombo();
        $data['TablaPerfilModulosPoderes'] = $model->TablaPerfilModulosPoderes(0);
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        return View::make('adm.plantilla_perfil', $data);
    }

    protected function postFiltrarPoder(Request $request){
        $model = new User();
        return $model->ModulosPoderesCombo($request->input('id_tipo_modulo_id_modulo'));
    }

    protected function postDeletePlantillaPerfil(Request $request){
        $model = new User();
        $model->DeletePlantillaPerfil($request->input('id_plantilla_nivel'));
        return $model->TablaPerfilModulosPoderes(0);
    }

    protected function postAddPlantillaPerfil(AuthSrv $authSrv, Request $request){
        $model = new User();
        $result = $model->AddPlantillaPerfil(
                $authSrv->DatosAccesoSeleccionado()['id_sede'],
                $request->input('id_perfil'),
                $request->input('poderes'),
                $request->input('id_tipo_modulo_id_modulo')
                );
        return $model->TablaPerfilModulosPoderes(0);
    }
}