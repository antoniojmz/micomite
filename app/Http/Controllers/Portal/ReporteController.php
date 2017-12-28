<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReporteRequest;
use Illuminate\Http\Request;

// Servicios
use App\Services\AuthSrv;
// use Illuminate\Http\Response;
use JasperPHP\JasperPHP as JasperPHP;

//Facades
use Auth;
use Lang;
use View;
use Config;


use Log;

// $file = public_path() . '/ct.pdf';
// Funciona para descargar el archivo
// if (File::isFile($file)){
//     return Response::download($file, 'Constancia de trabajo');
// }
// Funciona abrir en la misma ventana
// if (File::isFile($file)){
//     $file = File::get($file);
//     $response = Response::make($file, 200);
//     $response->header('Content-Type', 'application/pdf');
//     return $response;
// }

class ReporteController extends Controller {
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

    ////////////////////////// consulta reportes //////////////////////////////////
    protected function getConsdulta(){
        $data['title'] = 'Consultas reportes';
        return View::make('consultas_reportes.reportes', $data);
    }

    protected function postProcesarConsulta(AuthSrv $authSrv, Request $request){

        try {
            $input = $request->all();
            // $jasper = new JasperPHP;
            Log::info('llega al controlador');
            Log::info($input['id_reporte']);

            switch ($input['id_reporte']) {
                case 3:
                    $salida = 'ctq'.Auth::user()->id_trabajador;
                    $parametros['id_trabajador'] = Auth::user()->id_trabajador;
                    $parametros['dia'] = date('d');
                    $parametros['mes'] = date('m');
                    $parametros['anio'] = date('o');
                   // $parametros['id_constancia'] = "36";
                    $parametros['diadehoy'] =  date('d');
                    $parametros['mesdehoy'] = "Junio";
                    $parametros['yeardehoy'] = date('o');
                    $parametros['logo'] = public_path().'/images/';

                    $jasper->process(
                        public_path() . '/reporte/fuente/ctq.jasper',
                        public_path() . '/reporte/out/'.$salida,
                        ['pdf'],
                        $parametros,
                        Config::get('database.connections.nomina')
                    )->executephp();
                    Log::info("pasóooctq");
                    break;
                case 2:
                    $salida = 'vch'.Auth::user()->id_trabajador;
                    dd($salida);
                    $parametros['cedula'] = '15023498';
                    $fecha = date('o')-1;
                   // Log::info($fecha);
                    $parametros['cedula'] = '3642829';
                    // $parametros['responsable'] = Auth::user()->;
                     // $parametros['anio'] = 2015;
                   // $parametros['anio'] = date('o')-100;
                     // Log::info("anio"+ $parametros['anio']);
                   // $parametros['ruta'] = public_path().'/images/';
                    // dd($parametros['anio']);
                    $jasper->process(
                        public_path() . '/reporte/fuente/myprintg.jasper',
                        public_path() . '/reporte/out/'.$salida,
                        ['pdf'],
                        $parametros,
                        Config::get('database.connections.nomina')
                    )->execute();
                    Log::info("pasóooooio3");
                    break;

                case 1:
                    $salida = 'ari'.Auth::user()->id_trabajador;
                    $parametros['id_trabajador'] = Auth::user()->id_trabajador;
                    $parametros['logo'] = public_path().'/images/';
                      Log::info("para3"+ $salida);
                    $jasper->process(
                        public_path() . '/reporte/fuente/consulta_arc_myprint.jasper',
                        public_path() . '/reporte/out/'.$salida,
                        ['pdf'],
                        $parametros,
                        Config::get('database.connections.nomina')
                    )->execute();
                    break;
                default:
                    // return Redirect::route('cambioacceso');
            };
            return ['nombre' => $salida.'.pdf'];
        } catch (Exception $e) {
            log::info($e->getMessage());
        }
    }
}