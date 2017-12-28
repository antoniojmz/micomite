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
use App\Models\Clave;

class ClaveController extends Controller {
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

    protected function getClave(Request $request){
      $data['title'] = 'Cambio de clave';
      return View::make('cambioclave.cambioclave',$data);
    }
    protected function postclave(Request $request){
        $data = $request->all();
        $model= new Clave();
        $result= $model->cambiarClave($data);
        return $result;
    }
};