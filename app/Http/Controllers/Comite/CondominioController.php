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
use App\Models\Condominio;
use App\Models\Publicidad;

class CondominioController extends Controller {
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

    protected function getCondominio(){
        $data['title'] = 'Registro de Condominios';
        $data['id_pantalla'] = 51;
        $model = new Publicidad();
        $data['v_comunas']=$model->listComunas();
        $model= new Condominio();
        $data['v_sedes']= $model->listSedes();
        $data['v_ciudad']= $model->listCiudad();
        return View::make('condominio.condominio',$data);
    }

    protected function postCondominio(Request $request){
        $data = $request->all();
        $model= new Condominio();
        $result['f_registro_condominio']= $model->resgistrarC($data);
        $result['v_sedes']= $model->listSedes();
        return $result;
    }

    public function postSubirfotoC(Request $request){
        $id=$request->input('id_sede2');
        $archivo1 = $request->file('foto1');       
        $archivo2 = $request->file('foto2');       
        $archivo3 = $request->file('foto3');
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
                $nuevo_nombre1="condominio-".$id."-01.".$extension1;
                $r1=Storage::disk('fotos-condominios')->put($nuevo_nombre1,  \File::get($archivo1));
                $rutadelaimagen1="/fotos-condominios/".$nuevo_nombre1;
                if ($r1){
                    $result['foto1']=$rutadelaimagen1;
                }else{}
            }
        }
        if ($archivo2!=null){
            $input2  = array('foto2' => $archivo2);
            $reglas2 = array('foto2' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:4000');
            $validacion2 = Validator::make($input2,  $reglas2);
            if ($validacion2->fails()){
                Log::info("Fallo la imagen 2");  
            }else{
                $nombre_original2=$archivo2->getClientOriginalName();
                $extension2=$archivo2->getClientOriginalExtension();
                $nuevo_nombre2="condominio-".$id."-02.".$extension2;
                $r2=Storage::disk('fotos-condominios')->put($nuevo_nombre2,  \File::get($archivo2));
                $rutadelaimagen2="/fotos-condominios/".$nuevo_nombre2;
                if ($r2){
                    $result['foto2']=$rutadelaimagen2;
                }else{}
            }
        }
        if ($archivo3!=null){
            $input3  = array('foto3' => $archivo3);
            $reglas3 = array('foto3' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:4000');
            $validacion3 = Validator::make($input3,  $reglas3);
            if ($validacion3->fails()){
                Log::info("Fallo la imagen 3");  
            }else{
                $nombre_original3=$archivo3->getClientOriginalName();
                $extension3=$archivo3->getClientOriginalExtension();
                $nuevo_nombre3="condominio-".$id."-03.".$extension3;
                $r3=Storage::disk('fotos-condominios')->put($nuevo_nombre3,  \File::get($archivo3));
                $rutadelaimagen3="/fotos-condominios/".$nuevo_nombre3;
                if ($r3){
                   $result['foto3']=$rutadelaimagen3;
                }else{}
            }
        }
        if (strlen($result['foto1'])>3 or strlen($result['foto2'])>3 or strlen($result['foto3'])>3){
            $sql="UPDATE sedes SET foto1='".$result['foto1']."', foto2='".$result['foto2']."',foto3='".$result['foto3']."' WHERE id_sede='".$id."';";
            $resul=DB::select($sql);
            $model= new Condominio();
            $result['v_sedes']= $model->listSedes(); 
            $result['code']="200";
            $result['des_code']="Fotos cargadas correctamente";
            $result = json_encode($result);
            return  $result;
        }else{
            return '{"code":"-2","des_code":"Ocurrio un error mientras se cargaban las fotos"}';
        }
    }
    
    public function postDelfotoC(Request $request){
        $data = $request->all();
        $sql="UPDATE sedes SET foto1=null, foto2=null, foto3=null WHERE id_sede='".$data['id_sede']."';";
        $result=DB::select($sql);
        $model= new Condominio();
        $result= $model->listSedes(); 
        return  $result;
    }
}