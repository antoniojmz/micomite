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
use App\Models\Seguridad;
use App\Models\Cartelera;
use App\Models\Encuestas;

class SeguridadController extends Controller {
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

    protected function getSeguridad(Request $request){
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
        $data['title'] = 'Seguridad';
        $data['id_pantalla'] = 44;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $model = new Seguridad();
        switch ($data['nivel']){
            case 3:
                $result= $model->listSeguridadVotacion($data['id_sede']);
                $data['v_seguridad']=$result;
                $model = new Encuestas();
                $data['v_encuestas']=$model->listEpendientes($dat);
                $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
                return View::make('seguridad.seguridadUsuario',$data);
                break;
            case 2:
                $data['v_seguridad']=$model->listSeguridad($data['id_sede']);
                $data['v_turnos']=$model->listTurno($data['id_sede']);
                $data['v_dias']=$model->listDias();
                $data['v_tipo_seguridad']=$model->listTipo();
                return View::make('seguridad.seguridadA',$data);
                break;
        }
    }

    protected function postSeguridad(Request $request){
        $dats = $request->session()->all();
        $data = $request->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $data=json_encode($data);
        $model= new Seguridad();
        $result['f_registro_seguridad']= $model->regSeguridad($data);
        $result['v_seguridad']=$model->listSeguridad($id_sede);
        return $result;
    }

    protected function postTurnos(Request $request){
        $dats = $request->session()->all();
        $data = $request->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $model= new Seguridad();
        $result['f_registro_turno']= $model->regTurno($data);
        $result['v_turnos']=$model->listTurno($data['id_sede']);
        return $result;
    }

    protected function postConsultar(Request $request){
        $data = $request->all();
        $rutE=$data['rutE'];
        $model= new Seguridad();
        $result= $model->consultarE($rutE);
        return $result;
    }

    public function postSubirfotoS(Request $request){
        $id=$request->input('id_seguridad');
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $archivo = $request->file('foto');
        $input  = array('foto' => $archivo) ;
        $reglas = array('foto' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:5000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails()){
          return "-2";
        }else{
            $nombre_original=$archivo->getClientOriginalName();
            $extension=$archivo->getClientOriginalExtension();
            $nuevo_nombre="segImagen-".$id.".".$extension;
            $r1=Storage::disk('fotos-seguridad')->put($nuevo_nombre,  \File::get($archivo) );
            $rutadelaimagen="/fotos-seguridad/".$nuevo_nombre;
            if ($r1){
                $sql="UPDATE seguridad SET urlimage='".$rutadelaimagen."' WHERE id_seguridad='".$id."';";
                DB::select($sql);
                $model= new Seguridad();
                $result['v_seguridad']=$model->listSeguridad($id_sede);
                $result['rutadelaimagen']=$rutadelaimagen;
                return $result;
            }else{
            }
        }
    }

    public function postDelfotoS(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $sql="UPDATE seguridad SET urlimage=null WHERE id_seguridad='".$data['id_seguridad']."';";
        $result=DB::select($sql);
        $model= new Seguridad();
        $result=$model->listSeguridad($id_sede);
        return  $result;
    }


    public function postVotar(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();

        // 1 id_usuario
        // 2 id_sede
        // 3 id_proveedor
        // 4 votacion
        // 5 comentario

        $data['id_sede'] = $dats['user_portal']['usuario']['id_sede'];
        $data['id_usuario'] = Auth::User()->user_id;
        $data['votacion'] = $data['estrellas'];

        $data = json_encode($data);
        $model= new Seguridad();
        $result= $model->regVotacionProveedor($data);
        $result = $result[0]->f_registro_votacion_seg;
        return $result;
    }


    protected function postConsultaV(Request $request){
        $dats = $request->session()->all();
        $data = $request->all();

        $model= new Seguridad();
        $result= $model->listComentariosSeguridad($data['id_seguridad']);
        $result= json_decode(json_encode($result), True);

        return $result;
    }


}
