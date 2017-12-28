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
use App\Models\Consultas;

class ConsultasController extends Controller {
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

    protected function getConsultas(Request $request){
      $data['title'] = 'Consultas';
      $dats = $request->session()->all();
      $id_usuario_acceso=$dats['user_portal']['usuario']['id_usuario_acceso'];
      $model= new Consultas();
      $data['v_reportes']= $model->listReportes($id_usuario_acceso);
      return View::make('consultas.consultas',$data);
    }
    protected function postConsultas(Request $request){
        $data = $request->all();
        $id_reporte=$data['Selectconsulta'];
        $dats = $request->session()->all();
        $model= new Consultas();
        $result= $model->proConsulta($data,$dats);
        return $result;
    }
};