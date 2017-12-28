<?php

namespace App\Http\Controllers\Comite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

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
use Input;

//Models
use App\Models\Reglamentos;
use App\Models\Cartelera;
use App\Models\Encuestas;

class ReglamentosController extends Controller {
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

    protected function getReglamentos(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = 1;
        $dat=json_encode($dat);
        $model = new Encuestas();
        $data['v_encuestas']=$model->listEpendientes($dat);
        $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $model= new Reglamentos();
        $data['title'] = 'reglamentos';
        $data['v_reglamentos']= $model->listReglamentos($data['id_sede']);
        $data['id_pantalla'] = 46;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        switch ($data['nivel']) {
            case 2:
                $data['v_tipo']= $model->listTipo();
                return View::make('reglamentos.reglamentosA',$data);
            break;
            case 3:
                //Aqui van los reglamentos para descargar
                return View::make('reglamentos.reglamentosU',$data);
            break;           
            default:
                $result='{"code":"-2", "des_code":"Acceso no autorizado"}';
            break;
        }
    }

    public function postDownload(Request $request){
        $data = $request->all();
        $url = substr($data['urlreglamento'], 1);
        $file_path = public_path($url);
        return response()->file($file_path);  // Para ver online
        // return response()->file($pathToFile); // Para descargar
    }

    protected function postSubirpdf(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['activo']='f';
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede']; 
        $id_sede=$dats['user_portal']['usuario']['id_sede']; 
        if($request->input('estatus')==1){$data['activo']='t'; }
        $data=json_encode($data);
        $model= new Reglamentos();
        $result= $model->registrarR($data);
        if($result[0]->f_registro_reglamento>1){
            $id=$request->input('id_reglamento');
            $archivo = $request->file('urlreglamento');
            $input  = array('urlreglamento' => $archivo) ;
            $reglas = array('urlreglamento' => 'required|mimes:pdf|max:5000');
            $validacion = Validator::make($input,  $reglas);
            if ($validacion->fails()){
              return "-2";
            }else{
                $nombre_original=$archivo->getClientOriginalName();
                $extension=$archivo->getClientOriginalExtension();
                $nuevo_nombre="reglamento-".$result[0]->f_registro_reglamento.".".$extension;
                $r1=Storage::disk('reglamentos')->put($nuevo_nombre,  \File::get($archivo) );
                $rutadelarchivo="/reglamentos/".$nuevo_nombre;
                if ($r1){
                    $sql="UPDATE reglamentos SET urlreglamento='".$rutadelarchivo."' WHERE id_reglamento='".$result[0]->f_registro_reglamento."';";
                    DB::select($sql);
                    $result['v_reglamentos']= $model->listReglamentos($id_sede);
                    $result['f_registro_reglamento']= '{"code":"200","des_code":"Proceso con exito."}';
                    return $result;
                }else{

                }
            }
        }else{
            return '{"code":"-2","des_code":"Error al cargar archivo."}';
        }
    }

    protected function postDelpdf(Request $request){
        $data = $request->all();
        $data=json_encode($data);
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede']; 
        $model= new Reglamentos();
        $result['f_registro_reglamento']= $model->registrarR($data);
        $result['v_reglamentos']= $model->listReglamentos($id_sede);
        return $result;
    }
}