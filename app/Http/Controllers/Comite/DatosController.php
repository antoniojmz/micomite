<?php
namespace App\Http\Controllers\Comite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PreingresoRequest;

// Servicios
use App\Services\AuthSrv;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use JasperPHP\JasperPHP as JasperPHP;

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
use App\Models\Datos;
use App\Models\Cartelera;
use App\Models\Comite;
use App\Models\Encuestas;

class DatosController extends Controller {
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

    protected function getDatos(Request $request){
        $dats = $request->session()->all();
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $data['title'] = 'Datos personales';
        $data['id_pantalla'] = 42;
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
        $model= new Datos();
        $data['id_nivel'] = $dats['user_portal']['usuario']['id_nivel'];
        $data['id_sede'] = $dats['user_portal']['usuario']['id_sede'];
        $data['user_id'] = Auth::User()->user_id;
        $data['v_datos']= $model->datosPersonales();
        $model= new Comite();
        $data['comite']= $model->verificarComite($data);
        if($data['comite'] != null ){
              $data['comite']=$data['comite']->cargo;
        }else{
              $data['comite']= false;
        }$data['condominio']=$dats['user_portal']['usuario']['des_sede'];
        return View::make('datos.datos',$data);
    }

    protected function postDatosC(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $result['cargo']=$data['datos']['cargo'];
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        Log::info($data);
        $model= new Comite();
        if($data['datos']['boton'] == 2){
            $result['resultado']= $model->actualizarComite($data);
        } else {
            $result['resultado']= $model->eliminarComite($data);
        }
        $data['user_id'] = Auth::User()->user_id;
        $data['comite']= $model->verificarComite($data);
        return $result;
    }

    protected function postDatos(Request $request){
        $data = $request->all();
        $model= new Datos();
        $result= $model->actualizarDatos($data);
        return $result;
    }

    public function postSubirfoto(Request $request){
        $id=$request->input('user_id');
        $archivo = $request->file('foto');
        $input  = array('foto' => $archivo) ;
        $reglas = array('foto' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:5000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails()){
          return "-2";
        }else{
            $nombre_original=$archivo->getClientOriginalName();
            $extension=$archivo->getClientOriginalExtension();
            $nuevo_nombre="userimagen-".$id.".".$extension;
            $r1=Storage::disk('fotos-perfil')->put($nuevo_nombre,  \File::get($archivo) );
            $rutadelaimagen="/fotos-perfil/".$nuevo_nombre;
            if ($r1){
                $sql="UPDATE usuarios SET urlimage='".$rutadelaimagen."' WHERE user_id='".$id."';";
                DB::select($sql);
                return  $rutadelaimagen;
            }else{
            }
        }
    }
    public function postDelfoto(Request $request){
        $data = $request->all();
        $sql="UPDATE usuarios SET urlimage=null WHERE user_id='".$data['user_id']."';";
        $result=DB::select($sql);
        return  "200";
    }
}