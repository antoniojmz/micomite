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



class UsuarioController extends Controller {
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

///////////////////////////////////////////////////////////////////////////////////////////////////
    // Usuario
    protected function getUsuario(Request $request){
        $dats = $request->session()->all();
        $data['title'] = 'Actualización de usuario'; 
        $data['id_pantalla'] = 13;
        $model = new User();
        $data['sedecombo'] = $model->SedeCombo();
        $data['perfilcombo'] = $model->NivelesCombo();
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        // $data['moduloscombo'] = $model->ModulosComboSelect2();
        return View::make('adm.usuario', $data);
    }

    protected function postUsuario(AuthSrv $authSrv, Request $request){
        $authSrv->Menu($request->input('id_usuario_acceso'));
        return Redirect::route('menu');
    }

    protected function postBuscarUsuariosPerfiles(Request $request){
        $data = $request->all();
        $rut=$data['rut'];
        $model = new User();
        return $model->BuscarUsuarioPerfiles($rut);
    }

    protected function postEstatusUsuario(Request $request){
        $model = new User();
        return $model->EstatusUsuario($request->input('id_usuario'), $request->input('estatus'));
    }

    protected function postEstatusUsuarioPerfil(Request $request){
        $model = new User();
        return $model->EstatusUsuarioPerfil($request->input('id_usuario_acceso'), $request->input('estatus'), $request->input('id_usuario'));
    }

    protected function postActualizarPlantilla(Request $request){
        $model = new User();
        $data['perfiles'] = $model->ActualizarPlantilla($request->input('id_usuario_acceso'), $request->input('id_perfil'));
        return $data;
    }

    protected function postAsignarPerfil(Request $request){
        $model = new User();
        return $model->AsignarPerfil($request->input('id_usuario'), $request->input('id_sede'), $request->input('id_perfil'));
    }

    protected function postAccesoAvanzado(Request $request){
        $model = new User();
        $data['moduloscombo'] = $model->ModulosComboSelect2();
        $data['acceso'] = $model->Accesos($request->input('id_usuario_acceso'));
        return $data;
    }

    protected function postAgregarAcceso(Request $request){
        $model = new User();
        $input = $request->all();
        $model->AgregarAcceso($input['id_usuario_acceso'], $input['id_tipo_modulo_id_modulo'], $input['id_poder']);
        return $model->Accesos($request->input('id_usuario_acceso'));
    }

    protected function postEliminarAcceso(Request $request){
        $model = new User();
        $input = $request->all();
        $model->EliminarAcceso($input['id_acceso']);
        return $model->Accesos($input['id_usuario_acceso']);
    }
}