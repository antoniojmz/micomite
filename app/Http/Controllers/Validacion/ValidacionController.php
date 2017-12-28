<?php

namespace App\Http\Controllers\Validacion;

use App\Http\Controllers\Controller;
// use App\Http\Requests\UserRequest;
// use App\Http\Requests\ReporteRequest;
use Illuminate\Http\Request;
// Servicios
use App\Services\AuthSrv;

//Facades
use Auth;
use Form;
use Lang;
use View;
use Redirect;
use Config;
// use Request;
use Route;
use Hash;
use Session;
use Mail;
use Crypt;

use Log;

//Models
// use App\Models\User;
use App\Models\Postulados;
use App\Models\EstatusPreingreso;
use App\Models\Evaluados;
use App\Models\Personas;
use App\Models\Educacion;
use App\Models\Cursos;
use App\Models\Experiencias;
use App\Models\CargaFamiliar;
use App\Models\Tablas;
// use App\Models\SectoresPublicos;
use App\Models\ReferenciaPersonal;
use App\Models\Recaudos;



class ValidacionController extends Controller {

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

    protected function getIndex(){
        $data['title'] = 'Validación';
        return View::make('Validacion.index',$data);
    }



    protected function getListaPostulados(){
         $model = new Postulados();
         $lista = $model->postuladosVu();
         return $lista;
    }

    protected function getListapostuladosvalidados(){
         //return "Entré al controlador";
         $model = new Postulados();
         $lista = $model->postuladosVd();
         return $lista;
    }

    protected function postValidarPostulacion(Request $request){
        $model2 = new Postulados();
        $model = new EstatusPreingreso();
            if ($request['accion'] == 'v'){
                 $row = $model->where('id_persona', '=', $request['id_persona'])->first();
                 $row->estatus_central = true;
                 $row->central_fecha_f = date('Y-m-d');
                 $row->obs_central = $request->observacion;
                 $row->save();
            }else{
                 $row = $model->where('id_persona', '=', $request['id_persona'])->first();
                 $row->estatus_central = false;
                 $row->estatus_unidad = false;
                 $row->central_fecha_f = date('Y-m-d');
                 $row->obs_central = $request->observacion;
                 $row->save();
            }

         $lista = $model2->postuladosPorId($request['id_persona']);
         return $lista;
    }
    protected function postBuscarPostuladoV(Request $request){
         $model = new Postulados();
         $lista = $model->postuladosPorCedula($request['cedula']);
         return $lista;
    }
    protected function postCargaInfPostulado(Request $request){
         $input = $request->all();
        // Log::info($input);
        $model = new Personas();
        $data['persona'] = $model->BuscarPersonaid($input['id_persona']);
        // $data['persona'] = $model->BuscarPersonaid(45);
        // Log::info($data['persona']);
        $model = new Tablas();
        $data['parentescocombo'] = $model->ComboParentesco();
        $data['educacionformalcombo'] = $model->ComboEducacionFormal();
        // $data['sectortipocombo'] = $model->ComboSectorPublico();
        $data['edocivilcombo'] = $model->ComboEstadoCivil();
        $data['direccion'] = $model->Combodireccion();
        $model = new Educacion();
        $data['educacion'] = $model->TablaEducacion($data['persona'][0]->id_persona);
        // Log::info($data['educacion']);
        $model = new Cursos();
        $data['cursos'] = $model->TablaCursos($data['persona'][0]->id_persona);
        $model = new Experiencias();
        $data['experiencias'] = $model->TablaExperiencias($data['persona'][0]->id_persona);
        $model = new CargaFamiliar();
        $data['cargafamiliar'] = $model->TablaCargaFamiliar($data['persona'][0]->id_persona);
        // $model = new SectoresPublicos();
        // $data['sectorespublicos'] = $model->TablaSectoresPublicos($data['persona'][0]->id_persona);
        $model = new ReferenciaPersonal();
        $data['refereciapersonal'] = $model->TablaReferenciaPersonal($data['persona'][0]->id_persona);
        $model = new Evaluados();
        $data['resultadoEvaluacion'] = $model->ResultadoEvaluacionFicha($data['persona'][0]->id_persona);
        $model = new Recaudos();
        $data['recaudos'] = $model->TablaPdf($data['persona'][0]->id_persona);
         // dd($data);
         $data['title'] = 'Detalle';
         return $data;
    }
    protected function postGrafPostEstados(){
         $model = new Postulados();
         $data['datos'] = $model->postuladosVuXe();
         return $data;
    }



}

