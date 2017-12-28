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
use Crypt;
use SerializesModels;
use Storage;
use DB;
//Models
use App\Models\Registrou;
use App\Models\Cartelera;

class RegistrouController extends Controller {
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
//////////////////Registrar usuario/////////////// 

    protected function getRegistrou(Request $request){
        $dats = $request->session()->all();
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat=json_encode($dat);
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $data['title'] = 'Registro de usuarios';
        $data['id_pantalla'] = 27;
        $model= new Registrou();
        $data['v_usuarios']= $model->listUsuario($data['id_sede']);
        $data['v_tipo_usuario']= $model->listTipoUsuario();
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        return View::make('registrou.registrou',$data);
    }
 
    protected function postProcesaru(Request $request){
        $data = $request->all();
        $model= new Registrou();
        $f_registro_usuario=$model->regUsuario($data);
        if ($data['datos']['caso']==2){
            $var= explode('"', $f_registro_usuario['f_registro_usuario'][0]->f_registro_usuario);
            if($var[3]=='200'){
                $pathToFile="";
                $containfile=false; 
                $destinatario=$data['datos']['email'];
                $asunto="Registro de usuario";
                $contenido="Estimado/a ".$data['datos']['name'].". Esta notificación es para informarle que ud. ha sido registrado/a en el sistema de administración de condominios Mi Comité Online, ud. puede ingresar a nuestro sistema con su dirección de correo electrónico y su RUT como contraseña, Así mismo le recomendamos cambiar su contraseña una vez haya ingresado al sistema.";
                $data = array('contenido' => $contenido);
                $r= Mail::send('auth.emails.notificacion', $data, function ($message) use ($asunto,$destinatario,$containfile,$pathToFile){ 
                    $message->from('moraanto2017@gmail.com', 'Mi comite online');
                    $message->to($destinatario)->subject($asunto);
                    if($containfile){
                        $message->attach($pathToFile);
                    }
                });
                if($r){Log::info("Envio el correo");}else{Log::info("No envio el correo");}
            }
        }
        return json_encode($f_registro_usuario);
    }

    public function postSubirfoto(Request $request){
        $id=$request->input('user_id');
        $archivo = $request->file('foto');
        $input  = array('foto' => $archivo) ;
        $reglas = array('foto' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:5000');
        $validacion = Validator::make($input,  $reglas);
        if ($validacion->fails()){
          return "No guardo";
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
}