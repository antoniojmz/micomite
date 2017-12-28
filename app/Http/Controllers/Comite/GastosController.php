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
use SerializesModels;
use Storage;
use DB;
use Validator;


//Models
use App\Models\Gastos;
use App\Models\Cartelera;
use App\Models\Encuestas;

class GastosController extends Controller {
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

    protected function getGastos(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede = $dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = 1;
        $dat=json_encode($dat);
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);

        $model = new Gastos(); 
        $data['v_tipo_padre']=$model->listTipoPadre();
        $data['periodos_pago']=$model->searchPeriodo($id_sede);
        $data['v_gastos']=$model->listGastos($id_sede);
        $data['v_gastos_consulta']=$model->listGastosCons($id_sede);

        $data['v_gastos_adicionales']=$model->listGastosComunesA($id_sede);
        $data['v_gastos_adicionales_consulta']=$model->listGastosComunesAV($id_sede);
        $data['v_total_gastos']=$model->listPeriodosGastos($id_sede);
        $data['v_pagos_propietarios']=$model->listPagosPropietarios($id_sede);
        $data['v_anios']=$model->listAnios($id_sede);
        $data['v_apartamentos']= $model->listApartamentos($id_sede);
        $data['v_apartamentos_cbo']= $model->listApartamentosCbo($id_sede);
        $data['v_calculo_gcomunes'] = $model->listGastosApartamento($id_sede);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $model = new Encuestas();
        $data['v_encuestas']=$model->listEpendientes($dat);
        $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
        $data['title'] = 'Gastos comunes';
        $data['id_pantalla'] = 43;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];

        switch ($data['id_nivel']) {
            case 2:
                 return View::make('gastos.gastos',$data);
            break;
            case 3:
                return View::make('gastos.gastosU',$data);
            break;
            default:
                $result='{"code":"-2", "des_code":"Acceso no autorizado"}';
            break;
        }

    }

    protected function postCatalogos(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $model= new Gastos();
        $result= $model->regCatalogo($data);
        return $result;
    }

    protected function postPagosAptos(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $model= new Gastos();
        $result['v_conceptos'] = $model->BuscarCatalogoCombo($data['id_tipo_gasto']);
        $result['caso'] = $data['caso'];
        return $result;
    }

    protected function postConsultaGastos(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];

        $data = $data['parametros'];
        $arreglo['id_sede'] = $id_sede;
        $arreglo['mes'] = $data['mes'];
        $arreglo['anio'] = $data['anio'];
        $arreglo['id_apartamento'] = $data['id_apartamento'];

        $model= new Gastos();
        $result['v_totales_mes']=$model->listPeriodosGastosConsulta($arreglo);
        $id_periodo =$result['v_totales_mes'][0]->id_periodo;

        $result['v_gastos'] = $model->listGastosConsulta($id_periodo, $id_sede);
        $result['v_gastos_adicionales']=$model->listGastosComunesAConsulta($id_periodo, $id_sede);
        $result['v_calculo_gcomunes'] = $model->listGastosApartamentoConsulta($id_periodo, $id_sede, $arreglo['id_apartamento']);

        return $result;
    }


    protected function postConfirmarP(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);

        $model= new Gastos();
        $result = $model->confirmarPago($data['id_pago_propietario']);
        $result['v_calculo']=$model->calcularGastosComunes($parametros);
        $result['v_pagos_propietarios']=$model->listPagosPropietarios($id_sede);

        $datos = $model->buscarDatosPropietarios($data['id_pago_propietario'], $id_sede);

        $pathToFile="";
        $containfile=false;
        $destinatario=$datos[0]->email;
        $asunto="Confirmacion de Pago";

        $contenido="Estimado/a ".$datos[0]->propietario.". Esta notificación es para informarle su pago realizado en fecha:".$datos[0]->fecha_pago." con el codigo de verificacion:".$datos[0]->codigo_verificacion." por un monto de:".$datos[0]->monto."$ ha sido CONFIRMADO.";

        $data = array('contenido' => $contenido);
        $r= Mail::send('auth.emails.notificacion', $data, function ($message) use ($asunto,$destinatario,$containfile,$pathToFile){
            $message->from('moraanto2017@gmail.com', 'Mi comite online');
            $message->to($destinatario)->subject($asunto);
            if($containfile){
                $message->attach($pathToFile);
            }
        });

        return $result;
    }


    protected function postRechazarP(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);

        $model= new Gastos();
        $result['respuesta'] = $model->rechazarPago($data['id_pago_propietario']);
        $result['v_calculo']=$model->calcularGastosComunes($parametros);
        $result['v_pagos_propietarios']=$model->listPagosPropietarios($id_sede);

        $datos = $model->buscarDatosPropietarios($data['id_pago_propietario'], $id_sede);

        $pathToFile="";
        $containfile=false;
        $destinatario=$datos[0]->email;
        $asunto="Rechazo de Pago";

        $contenido="Estimado/a ".$datos[0]->propietario.". Esta notificación es para informarle su pago realizado en fecha:".$datos[0]->fecha_pago." con el codigo de verificacion:".$datos[0]->codigo_verificacion." por un monto de:".$datos[0]->monto."$ ha sido RECHAZADO. Por favor comunicarse con el comite.";

        $data = array('contenido' => $contenido);
        $r= Mail::send('auth.emails.notificacion', $data, function ($message) use ($asunto,$destinatario,$containfile,$pathToFile){
            $message->from('moraanto2017@gmail.com', 'Mi comite online');
            $message->to($destinatario)->subject($asunto);
            if($containfile){
                $message->attach($pathToFile);
            }
        });

        return $result;
    }


    protected function postPagos(Request $request){

        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede = $dats['user_portal']['usuario']['id_sede'];
        $data['id_usuario'] = Auth::User()->user_id;

        $data=json_encode($data);
        $model= new Gastos();
        $result['f_registro_pagos_comunes']= $model->regPago($data);
        $result['v_gastos'] = $model->listGastos($id_sede);
        $result['v_gastos_consulta']=$model->listGastosCons($id_sede);
    
        $result['v_gastos_adicionales_consulta']=$model->listGastosComunesA($id_sede);

        $result['v_totales_mes']=$model->listPeriodosGastos($id_sede);
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);
        $result['v_calculo']=$model->calcularGastosComunes($parametros);
        $result['v_total_gastos']=$model->listPeriodosGastos($id_sede);
        $result['v_calculo_gcomunes'] = $model->listGastosApartamento($id_sede);

        if($result['f_registro_pagos_comunes']['code']=='-2'){
            $salida['f_registro_pagos_comunes'] = $result['f_registro_pagos_comunes']['f_registro_pagos'][0]->f_registro_pagos;
        }

        if($result['f_registro_pagos_comunes']['code']=='200'){
            $id=$result['f_registro_pagos_comunes']['id_pago_gcomun'];
            $archivo = $request->file('urlimage');
            $input  = array('urlimage' => $archivo);
            $reglas = array('urlimage' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:5000');
            $validacion = Validator::make($input,  $reglas);
            if ($validacion->fails()){
              return "-2";
            }else{

                $nombre_original=$archivo->getClientOriginalName();
                $extension=$archivo->getClientOriginalExtension();
                $nuevo_nombre="gastosImagen-".$id.".".$extension;

                $r1=Storage::disk('fotos-gastos')->put($nuevo_nombre,  \File::get($archivo) );

                $rutadelaimagen="/fotos-gastos/".$nuevo_nombre;
                if ($r1){
                    $sql="UPDATE pagos_gcomunes SET urlimage='".$rutadelaimagen."' WHERE id_pago_gcomun='".$id."';";
                    DB::select($sql);
                    $result['rutadelaimagen']=$rutadelaimagen;
                    $result['f_registro_pagos_comunes']=$result['f_registro_pagos_comunes'][0]->f_registro_pagos_comunes;
                }else{
                }
            }
        }

        return $result;
    }

    protected function postPagosAdicionales(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede = $dats['user_portal']['usuario']['id_sede'];
        $data=json_encode($data);
        $model= new Gastos();

        $result['f_registro_pagos_adicionales']= $model->regPagoAdicional($data);
        $result['v_gastos_adicionales'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos'] = $model->listGastos($id_sede);
        $result['v_gastos_adicionales_consulta'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos_consulta'] = $model->listGastos($id_sede);
        $result['v_totales_mes']=$model->listPeriodosGastos($id_sede);
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);
        $result['v_calculo']=$model->calcularGastosComunes($parametros);
        $result['v_total_gastos']=$model->listPeriodosGastos($id_sede);
        $result['v_calculo_gcomunes'] = $model->listGastosApartamento($id_sede);

        return $result;
    }

protected function postPagosEliminar(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede = $dats['user_portal']['usuario']['id_sede'];
        $id_pago_gcomunes = $data['id_pago_gcomun'];
        $model= new Gastos();
        $result['v_gastos_eliminar'] = $model->deleteGastos($id_pago_gcomunes);

        $result['v_gastos_adicionales'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos'] = $model->listGastos($id_sede);
        $result['v_gastos_adicionales_consulta'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos_consulta'] = $model->listGastos($id_sede);
        $result['v_totales_mes']=$model->listPeriodosGastos($id_sede);
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);
        $result['v_calculo']=$model->calcularGastosComunes($parametros);
        $result['v_total_gastos']=$model->listPeriodosGastos($id_sede);
        $result['v_calculo_gcomunes'] = $model->listGastosApartamento($id_sede);

        return $result;
}


    protected function postPagosAdicionalesEliminar(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede = $dats['user_portal']['usuario']['id_sede'];
        $id_pago_adicional = $data['id_pago_adicional']['id_pago_adicional'];
        $model= new Gastos();
        $result['v_gastos_adicionales_eliminar'] = $model->deleteGastosComunesA($id_pago_adicional);

        $result['v_gastos_adicionales'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos'] = $model->listGastos($id_sede);
        $result['v_gastos_adicionales_consulta'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos_consulta'] = $model->listGastos($id_sede);
        $result['v_totales_mes']=$model->listPeriodosGastos($id_sede);
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);
        $result['v_calculo']=$model->calcularGastosComunes($parametros);
        $result['v_total_gastos']=$model->listPeriodosGastos($id_sede);
        $result['v_calculo_gcomunes'] = $model->listGastosApartamento($id_sede);
        return $result;
    }



    protected function postCierreMes(Request $request){

        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede = $dats['user_portal']['usuario']['id_sede'];
        $data['id_usuario'] = Auth::User()->user_id;
        $data['id_periodo'] = $data['id_periodo']['periodo_pago'];
        $data=json_encode($data);
        $model= new Gastos();
        $result['f_registro_cierre_mes']= $model->regCierreMes($data);
        $result['v_gastos_adicionales'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos'] = $model->listGastos($id_sede);
        $result['v_gastos_adicionales_consulta'] = $model->listGastosComunesA($id_sede);
        $result['v_gastos_consulta'] = $model->listGastos($id_sede);
        $result['v_totales_mes']=$model->listPeriodosGastos($id_sede);
        $parametros['id_sede'] = $id_sede;
        $parametros=json_encode($parametros);
        $result['v_calculo']=$model->calcularGastosComunes($parametros);
        $result['v_total_gastos']=$model->listPeriodosGastos($id_sede);
        $result['v_calculo_gcomunes'] = $model->listGastosApartamento($id_sede);
        $result['v_propietarios_correo'] = $model->listPropietariosCorreo($id_sede);
        $var = $result['f_registro_cierre_mes'][0]->f_registro_cierre_mes;
        $var= explode('"', $var);
        $result['code']=$var[3];
        if ($result['code']==200){
            foreach($result['v_propietarios_correo'] as $vpc){
                $nombre =$vpc->propietario;
                $email =$vpc->email;
                $apto =$vpc->numero;
                $pathToFile="";
                $containfile=false;
                $destinatario=$email;
                $asunto="Cierre de facturacion de mes";
                $contenido="Estimado/a ".$nombre.". Le notificamos que ya cerro su mes de gastos comunes en el condominio {{nombre_condominio}}"; 
                $data = array('contenido' => $contenido);
                $r= Mail::send('auth.emails.cierre_mes', $data, function ($message) use ($asunto,$destinatario,$containfile,$pathToFile){
                    $message->from('moraanto2017@gmail.com', 'Mi comite online');
                    $message->to($destinatario)->subject($asunto);
                    if($containfile){
                        $message->attach($pathToFile);
                    }
                });
                if($r){Log::info("Envio el correo");}else{Log::info("No envio el correo");}
            }
        }
        return $result;
    }
}