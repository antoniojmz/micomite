<?php

namespace App\Http\Controllers\Comite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Servicios
use App\Services\AuthSrv;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

//Facades
use Auth;
use Form;
use Lang;
use View;
use Redirect;
use Config;
use Mail;
use Log;
use SerializesModels;
use Storage;
use DB;

//Models
use App\Models\Pagos;
use App\Models\Cartelera;
use App\Models\Encuestas;

class PagosController extends Controller {
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

    protected function getPagos(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = 1;

        $id_usuario = $dat['id_usuario'];
        $id_sede = $dat['id_sede'];

        $dat=json_encode($dat);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $data['title'] = 'Pagos';
        $data['id_pantalla'] = 62;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $model = new Encuestas();
        $data['v_encuestas']=$model->listEpendientes($dat);
        $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
        $model = new Pagos();
        $data['v_tipo_pago_combos']=$model->listTipoPagos();
        $data['v_pagos'] = $model->listPagosPendientes($id_usuario,$id_sede);
        $data['v_pagos_resumen']=$model->listPagosPropietariosResumen($id_usuario, $id_sede) ;
        $data['v_pagos_propietarios']=$model->listPagosPropietarios($id_sede, $id_usuario) ;
        return View::make('pagos.pagosU',$data);
    }

    protected function postPagos(Request $request){
        $dats = $request->session()->all();
        $data = $request->all();
       
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $data['id_usuario'] = Auth::User()->user_id;
        $id_sede=$data['id_sede'];
        $id_usuario=$data['id_usuario'];
  
        $model= new Pagos();
        $data['v_pagos_propietarios']=$model->listPagosPropietarios($data['id_sede'], $id_usuario);
        $result['f_registro_pago']= $model->regPagoPropietario($data);

        if($result['f_registro_pago']['code']=='-2'){
            $salida['f_registro_pagos'] = $result['f_registro_pago']['f_registro_pagos'][0]->f_registro_pagos;
        }

        if($result['f_registro_pago']['code']=='200'){
            $id=$result['f_registro_pago']['id_pago_propietario'];
            $archivo = $request->file('foto');
            $input  = array('foto' => $archivo);
            $reglas = array('foto' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:5000');
            $validacion = Validator::make($input,  $reglas);
            if ($validacion->fails()){
              return "-2";
            }else{
                $nombre_original=$archivo->getClientOriginalName();
                $extension=$archivo->getClientOriginalExtension();
                $nuevo_nombre="pagoImagen-".$id.".".$extension;
                $r1=Storage::disk('fotos-pagos')->put($nuevo_nombre,  \File::get($archivo) );
                $rutadelaimagen="/fotos-pagos/".$nuevo_nombre;
                if ($r1){
                    $sql="UPDATE pagos_propietarios SET urlimage='".$rutadelaimagen."' WHERE id_pago_propietario='".$id."';";
                    DB::select($sql);
                    $salida['rutadelaimagen']=$rutadelaimagen;
                    $salida['f_registro_pagos']=$result['f_registro_pago']['f_registro_pagos'][0]->f_registro_pagos;
                    $salida['v_pagos_resumen']=$model->listPagosPropietariosResumen($id_usuario, $id_sede) ;
                    $salida['v_pagos_propietarios']=$model->listPagosPropietarios($id_sede, $id_usuario) ;
                    $salida['v_pagos'] = $model->listPagosPendientes($id_usuario,$id_sede);
                }else{
                }
            }
        }
        return $salida;
    }
}