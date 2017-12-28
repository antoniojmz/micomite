<?php

namespace App\Http\Controllers\Fe_vida;

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
use Session;

//Models
use App\Models\Tablas;
use App\Models\Persona;
use App\Models\Personas;
use App\Models\PresentacionFvida;

class Fe_vidaController extends Controller {
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
//////////////////fe de vida presencial///////////////

    protected function getFe_de_vida(){
       $data['title'] = 'Presentación fe de vida';
       return View::make('fe_de_vida.fe_de_vida', $data);
    }

    // para validar la cedula si existe o no en una bd o en un servicio
    // if (isset($respuesta->cedula)){
    //         $model = new Tablas();
    //         $data['fe_vida'] = $model->TablaFe();
    //         return ($response);
    //         // return ($data);
    //         // log::info("bien");
    //     }else{
    //         // log::info("mal");
    //         return '{"code":"0","des_code":"Verifique la cédula no existe"}';
    //     }
    //     return;
    // }
    // para validar la cedula si existe o no en una bd o en un servicio

    protected function postGuardarGenerar(Request $request){
        $input = $request->all();
        $model = new PresentacionFvida();
        $data = $model->Presentacion_fe_vida($input);
        return;
    }

//////////////////fe de vida presencial///////////////

//////////////////reporte///////////////

    protected function getConsulta(){
        $data['title'] = 'Consultas reportes';
        return View::make('consultas_reportes.reportes', $data);
    }

    protected function postProcesarConsulta(AuthSrv $authSrv, Request $request){

        $input = $request->all();
        $jasper = new JasperPHP;
                $salida = 'fdv'. str_replace('.', '', $input['cedula']);
                $parametros['cedula'] = '"'.$input['cedula'].'"';
                $parametros['telefono'] = $input['telefono'];
                $parametros['direccion'] = '"'.$input['direccion'].'"';
                $parametros['fecharesolucion'] = '"'.$input['fecharesolucion'].'"';
                $parametros['numeroresolucion'] = '"'.$input['numeroresolucion'].'"';
                $parametros['nombre'] = '"'.$input['nombre'].'"';
                $parametros['codigo'] = '"'.$input['codigo'].'"';
                $parametros['responsable'] = '"'.Auth::user()->name.'"';
                $parametros['dia'] = date('d');
                $parametros['mes'] = date('m');
                $parametros['anio'] = date('o');
                log::info($parametros);
                $jasper->process(
                        public_path() . '/reporte/fuente/fe_vida_modificado.jasper',
                    public_path() . '/reporte/out/'.$salida,
                    ['pdf'],
                    $parametros
                    // Config::get('database.connections.nomina')
                )->executephp();
        return ['nombre' => $salida.'.pdf'];
    }

//////////////////reporte///////////////

//////////////////no jubilado///////////////

    // protected function getNvo_jubilado(){
    //     $data['title'] = 'Actualización nuevo jubilado';
    //     $model = new Tablas();
    //     $data['tipoSolicitudCombo'] = $model->ComboTipoSolicitud();
    //     return View::make('fe_de_vida.nvo_jubilado', $data);
    // }

    // protected function postNvo_jubilado(Request $request){

    //     $input = $request->only('cedula');
    //     $ci = $input['cedula'];

    //     $response = file_get_contents('http://wsconsulta.int/ci/'.$ci);
    //     $respuesta = json_decode($response);

    //     if (isset($respuesta->cedula)){
    //         $model = new Tablas();
    //         $data['fe_vida'] = $model->TablaFe();
    //         return ($response);
    //         // return ($data);
    //         // log::info("bien");
    //     }else{
    //         // log::info("mal");
    //         return '{"code":"0","des_code":"Verifique la cédula no existe"}';
    //     }
    //     return;
    // }

    // protected function postGuardarNJ(Request $request){

    //     log::info('esta llegando al postGuardarNJ');
    //     $input = $request->all();
    //     $model = new PresentacionFvida();
    //     $data = $model->NuevoJubilado($input);
    //     return;
    // }

    protected function postBuscar(Request $request){
        $input = $request->only('cedula');
        $ci = $input['cedula'];
        $año = date('Y');
        if($ci){
            $model = new Tablas();
            $data['sumatoria'] = $model->TablaSumatoria($ci);
            // log::info($data['sumatoria'][0]->n_intentos < 3);
            if(isset($data['sumatoria'][0])){
                if($data['sumatoria'][0]->n_intentos < 3 and $data['sumatoria'][0]->anio == $año){
                    return $this->procesar($ci);
                }else{
                    return '{"code":"0","des_code":"Usted tiene el máximo de intentos, por favor diríjase a su oficina Administrativa más cercana"}';
                }
            }else{
                return $this->procesar($ci);
            }
        }else{
            return '{"code":"0","des_code":"Verifique la cédula esta vacia"}';
        }
    }

    public function procesar($ci){
        $preg = '';
        $response = json_decode(file_get_contents('http://wsconsulta.int/ci/'.$ci));
        // log::info('http://wsconsulta.int/ci/'.$ci);
        // log::info($response);
        if (isset($response->cedula)){
            $datos = array($response);

            // $model = new Tablas();
            // $data['pregunta'] = $model->TablaPreguntas();
            // $data['respuesta']  = $model->TablaRespuestas();

            // $preguntasbd = json_decode($data['respuesta'][0]->fnc_pregunta,true)['pregunta'];
            // $respuestasbd = json_decode($data['respuesta'][0]->fnc_pregunta,true)['respuestas'];
            // $preguntasbdsal = ["2"=>""];
            //     //////COUNT////
            //     for ($i=0; $i <= count($preguntasbd)-1; $i++) {
            //         $preguntasbd[$i];
            //         $respuestasbd[$preguntasbd[$i]['id']];
            //         array_push($preguntasbdsal, $preguntasbd[$i]['text']);
            //     }
            //     //////COUNT////
            //     // log::info($datos);
            //     for ($i=3; $i <= 9 ; $i++) {
            //         $p = $i+215;
            //         $datosarray = array('id'=> 1,'text'=>$datos[0]->$i);
            //         // log::info($respuestasbd[$p]);
            //         array_push($respuestasbd[$p], $datosarray);
            //         $seleccion = array_rand($respuestasbd[$p]);
            //         $preg = $preg.',"pre'.$i.'":[{"correct":"'.$datos[0]->$i.'", "rand":"'.$respuestasbd[$p][$seleccion]['text'].'","preg":"'.$preguntasbdsal[$i].'"}]';
            //     }
            if(isset($response->TIPO_SOLICITUD)){
                return ('{"nombre":"'.$response->primer_nombre.' '.$response->segundo_nombre.' '.$response->primer_apellido.' '.$response->segundo_apellido.'","tipo_pension":"'.$response->TIPO_SOLICITUD.'","numero_resolucion":"'.$response->NUMERO_RESOLUCION.'","fecha_resolucion":"'.$response->FECHA_RESOLUCION.'","cargo":"'.$response->CARGO.'","cuenta_nomina":"'.$response->cuenta_nomina.'"}');

            }else{
                return ('{"nombre":"'.$response->primer_nombre.' '.$response->segundo_nombre.' '.$response->primer_apellido.' '.$response->segundo_apellido.'","tipo_pension":"","numero_resolucion":"","fecha_resolucion":"","cargo":"","cuenta_nomina":"'.$response->cuenta_nomina.'"}');
            }
        }else{
            return '{"code":"0","des_code":"Verifique la cedula no existe"}';
        }
    }

    public function postProcesar(Request $request){
        $input = $request->only('cedula');
        $ci = $input['cedula'];

        if ($ci) {
            $model = new Tablas();
            $data['intentos'] = $model->TablaIntentos($ci);
        }
        return($data);
    }

    public function postInsertar(Request $request){
        log::info('en el modelo de insertar');
        $input = $request->all();
        $usuario = Auth::user()->user_id;
        $input['usuario'] = $usuario;
        $model = new Tablas();
        $data = $model->RegistroPresentacion($input);
        return($data);
    }

     public function postCombo(){
        $model = new Tablas();
        $data['combo'] = $model->TablaGeo();

        return($data);
    }

    public function postExisteDatos(Request $request){
        log::info('esta llegando al controlador por aqui ');
        $input = $request->all();
        log::info($input);
        $model = new Personas();
        $data['cedula'] = $model->BuscarDatos($input);
        // log::info('aqui va a buscar los datos');
        // log::info($data['cedula'][0]->strcorreo);
        return($data);
    }
//////////////////no jubilado///////////////
}