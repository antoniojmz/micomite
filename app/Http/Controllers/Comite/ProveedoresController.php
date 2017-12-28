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
use App\Models\Proveedores;
use App\Models\Cartelera;
use App\Models\Encuestas;
use App\Models\Publicidad;


class ProveedoresController extends Controller {
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

    protected function getProveedores(Request $request){
        $dats = $request->session()->all();
        $data['nivel']=$dats['user_portal']['usuario']['id_nivel'];
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
        $model = new Publicidad();
        $data['v_comunas']=$model->listComunas();
        $data['title'] = 'Proveedores y servicios';
        $model = new Proveedores();
        $data['v_proveedores']= $model->listProveedores();
        $data['v_categorias']= $model->listCategoria();
        $data['id_pantalla'] = 49;
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        switch ($data['nivel']){
            case 1:
                return View::make('proveedores.proveedoresA',$data);
            break;
            case 2:
                $data['v_proveedores']= $model->listProveedoresVotacion();
                $data['v_categorias_activas']= $model->listCategoriasActivas();
                return View::make('proveedores.proveedoresU',$data);
            break;
            case 3:
                $data['v_proveedores']= $model->listProveedoresVotacion();
                $data['v_proveedores_array']= json_decode(json_encode($data['v_proveedores']), True);

                $data['v_categorias_activas']= $model->listCategoriasActivas();
                return View::make('proveedores.proveedoresP',$data);
            break;
            default:
                $result='{"code":"-2", "des_code":"Acceso no autorizado"}';
            break;
        }
    }

    protected function postProveedores(Request $request){
        $dats = $request->session()->all();
        $data = $request->all();
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $data=json_encode($data);
        $model= new Proveedores();
        $result['f_registro_proveedor']= $model->regProveedor($data);
        $result['v_proveedores']= $model->listProveedores();
        return $result;
    }


    protected function postConsultaV(Request $request){
        $dats = $request->session()->all();
        $data = $request->all();

        $model= new Proveedores();
        $result= $model->listComentariosProveedor($data['id_proveedor']);
        $result= json_decode(json_encode($result), True);

        return $result;
    }

    public function postSubirfotoP(Request $request){
        $id=$request->input('id_proveedor');
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
            $nuevo_nombre="provImg-".$id.".".$extension;
            $r1=Storage::disk('fotos-proveedores')->put($nuevo_nombre,  \File::get($archivo) );
            $rutadelaimagen="/fotos-proveedores/".$nuevo_nombre;
            if ($r1){
                $sql="UPDATE proveedores SET urlimage='".$rutadelaimagen."' WHERE id_proveedor='".$id."';";
                DB::select($sql);
                $model= new Proveedores();
                $result['v_proveedores']= $model->listProveedores();
                $result['rutadelaimagen']=$rutadelaimagen;
                return $result;
            }else{
            }
        }
    }

    public function postDelfotoP(Request $request){
        $data = $request->all();
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $sql="UPDATE proveedores SET urlimage='' WHERE id_proveedor='".$data['id_proveedor']."';";
        $result=DB::select($sql);
        $model= new Proveedores();
        $result['v_proveedores']= $model->listProveedores();
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
        $model= new Proveedores();
        $result= $model->regVotacionProveedor($data);
        $result = $result[0]->f_registro_votacion_prov;
        return $result;
    }

}