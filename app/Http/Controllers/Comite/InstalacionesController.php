<?php

namespace App\Http\Controllers\Comite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PreingresoRequest;


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
 use App\Models\Instalaciones;
 use App\Models\Cartelera;
 use App\Models\Encuestas;

class InstalacionesController extends Controller {
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

    protected function getInstalaciones(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = 1;
        $dat=json_encode($dat);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['nivel']=$dats['user_portal']['usuario']['id_nivel']; 
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $model= new Instalaciones();
        $data['v_instalaciones']= $model->listInstalaciones($data['id_sede']);
        $data['id_pantalla'] = 45;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        switch ($data['nivel']) {
            case 2:
                $data['title'] = 'Registro de instalaciones';
                $data['v_instalaciones_combo']= $model->listInstalacionesCombos();
                return View::make('instalaciones.instalacionesA',$data);
            break;
            case 3:
                $data['title'] = 'Mis instalaciones';
                $model = new Encuestas();
                $data['v_encuestas']=$model->listEpendientes($dat);
                $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
                return View::make('instalaciones.instalacionesU',$data);
            break;           
            default:
                $result='{"code":"-2", "des_code":"Acceso no autorizado"}';
            break;
        }
    }

    protected function postInstalaciones(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $model= new Instalaciones();
        $result['f_registro_instalacion']= $model->registrarI($data);
        $result['v_instalaciones']= $model->listInstalaciones($data['id_sede']);
        return $result;
    }

    public function postSubirfotoI(Request $request){
        $id=$request->input('id_instalacion2');
        $archivo1 = $request->file('foto1');       
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];      
        $result['foto1']="";
        $result['foto2']="";
        $result['foto3']="";
        if ($archivo1!=null){
            $input1  = array('foto1' => $archivo1);
            $reglas1 = array('foto1' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:4000');
            $validacion1 = Validator::make($input1,  $reglas1);
            if ($validacion1->fails()){
                Log::info("Fallo la imagen 1");  
            }else{
                $nombre_original1=$archivo1->getClientOriginalName();
                $extension1=$archivo1->getClientOriginalExtension();
                $nuevo_nombre1="instImg-".$id."-01.".$extension1;
                $r1=Storage::disk('fotos-instalaciones')->put($nuevo_nombre1,  \File::get($archivo1));
                $rutadelaimagen1="/fotos-instalaciones/".$nuevo_nombre1;
                if ($r1){
                    $result['foto1']=$rutadelaimagen1;
                }else{}
            }
        }

        if (strlen($result['foto1'])>3){
            $sql="UPDATE instalaciones SET foto1='".$result['foto1']."' WHERE id_instalacion='".$id."';";
            DB::select($sql);
            $model= new Instalaciones();
            $result['v_instalaciones']= $model->listInstalaciones($data['id_sede']);  
            $result['code']="200";
            $result['des_code']="Foto cargadas correctamente";
            $result = json_encode($result);
            return  $result;
        }else{
            return '{"code":"-2","des_code":"Ocurrio un error mientras se cargaban las fotos"}';
        }
    }

    public function postDelfotoI(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $sql="UPDATE instalaciones SET foto1=null, foto2=null, foto3=null WHERE id_instalacion='".$data['id_instalacion']."';";
        $result=DB::select($sql);
        $model= new Instalaciones();
        $result= $model->listInstalaciones($data['id_sede']); 
        return  $result;
    }
}