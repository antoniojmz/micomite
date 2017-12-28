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
use App\Models\Publicidad;
use App\Models\Cartelera;

class PublicidadController extends Controller {
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

    protected function getPublicidad(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat=json_encode($dat);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $data['title'] = 'Seguridad';
        $data['id_pantalla'] = 55;
        $model = new Publicidad();
        $data['v_publicidad']=$model->listPublicidadAdmin();
        $data['v_comunas']=$model->listComunas();
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        return View::make('publicidad.publicidad',$data);
    }

    protected function postPublicidad(Request $request){
        $dats = $request->session()->all();
        $data = $request->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $data=json_encode($data);
        $model= new Publicidad();
        $result['f_registro_publicidad']= $model->regPublicidad($data);
        $result['v_publicidad']=$model->listPublicidadAdmin($id_sede);
        return $result;
    }

    public function postSubirfotoPu(Request $request){
        $id=$request->input('id_publicidad');
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
            $nuevo_nombre="pubImg-".$id.".".$extension;
            $r1=Storage::disk('fotos-publicidad')->put($nuevo_nombre,  \File::get($archivo) );
            $rutadelaimagen="/fotos-publicidad/".$nuevo_nombre;
            if ($r1){
                $sql="UPDATE publicidad SET urlimage='".$rutadelaimagen."' WHERE id_publicidad='".$id."';";
                DB::select($sql);
                $model= new Publicidad();
                $result['v_publicidad']=$model->listPublicidadAdmin();
                $result['rutadelaimagen']=$rutadelaimagen;
                return $result;
            }else{
            }
        }
    }

    public function postDelfotoPu(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $sql="UPDATE publicidad SET urlimage='' WHERE id_publicidad='".$data['id_publicidad']."';";
        $result=DB::select($sql);
        $model= new Publicidad();
        $result=$model->listPublicidadAdmin();
        return  $result;
    }
}