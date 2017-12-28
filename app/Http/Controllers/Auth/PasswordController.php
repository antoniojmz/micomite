<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Malahierba\Token\Token;

//Facades
// use Auth;
use Lang;
use View;
use Config;
use Mail;
use URL;
use Redirect;
use Session;
use App;
use Log;
use Crypt;
use Hash;

//Models
use App\Models\User;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');

        $this->middleware('verify.password_reset_token', ['only' => [
            'getReset',
            'postReset',
        ]]);

        $this->middleware(
            'request_attemps_limiter:prueba,'
            . Config::get('auth.recordar_clave.max_attemps')
            . ',' . Config::get('auth.recordar_clave.max_attemps_time_window'),
            ['only' => [
                'postRecordarClave',
             ]
        ]);
    }

    public function getInvalidToken()
    {
        if (! Session::get('password_reset_invalid_token'))
            return Redirect::route('home');

        $title = Lang::get('auth.password_reset_invalid_token_browser_title');
        return View::make('auth.password_reset_invalid_token',compact('title'));
    }

///////////////////////////////// Recordar Clave /////////////////////////////////

    protected function getRecordarClave(){
        if (Session::has('validado')) {
            // Session::flash('combo', json_encode($model->arraypreguntasecreta(Auth::user()->cedula))
            $data['title'] = Lang::get('auth.recordar_clave_titulo');
            $model = new User();
            // dd(Session::get('validado.ci'));
            $data['combo'] = $model->arraypreguntasecreta(Session::get('validado.ci'));

            return View::make('auth.recordar_clave', $data);
        }else{
            return Redirect::route('home');
        }
    }

    protected function postRecordarClave(UserRequest $request){
        $input = $request->only('txtPreguntaSecreta','respuestasecreta');
        //trim = elimina los espacios de izquierda y derecha
        $pregunta = trim(json_decode($input['txtPreguntaSecreta'])->des);
        // dd($pregunta);
        $respuesta = Hash::make($input['respuestasecreta']);
        // dd($respuesta);
        $model = new User();
        $data = User::where('cedula',Session::get('validado.ci'))->get()->first();

        // $data = json_decode($model->userExisteBD(Session::get('validado.ci')));
        // dd($data[0]->user_id);
        $preguntadb = Crypt::decrypt($data->preguntasecreta);
        // dd($data);
        // dd($preguntadb);
        $respuestadb = $data->respuestasecreta;
        // dd($respuestadb);
        ///////////////////////
        // Comparar
        ///////////////////////
        if((Hash::check($input['respuestasecreta'],$respuestadb)) && (($pregunta == $preguntadb))){
            Session::put('validado',$data->user_id);
            return Redirect::route('nueva_clave')->with('resultado',
                [ 'username' => $data->username]);
        }else{
            return Redirect::route('recordar_clave')->with('resultado',
            [ 'tipo' => 'error',
              'titulo' => '¡Error!',
              'mensaje' => Lang::get('auth.no_coinciden')
            ]);
        }
    }

////////////////////////////////////////////// Recordar Clave ////////////////////////////////////////////

/////////////////////////////////////////////// Nueva Clave //////////////////////////////////////////////

    protected function getNuevaClave(){
        if (! Session::get('validado'))
            return Redirect::route('home');

        $data['title'] = Lang::get('auth.recordar_clave_titulo');
        return View::make('auth.nueva_clave', $data);
    }

    protected function postNuevaClave(UserRequest $request){
        // Programar validar pregunta secreta
        $input = $request->only('password','username');
        // $model = new User();
        // $data = $model->cambiarPassword(Session::get('validado'),$input['password']);

        // dd(Auth::user()->username);

        $prueba = PasswordController::modificarClaveLdap($input['username'],$input['password']);
        // dd($data);
        // $data['title'] = Lang::get('auth.login_browser_title');


        if ($prueba){
            return Redirect::route('home')->with('resultado',
            [ 'tipo' => 'success',
              'titulo' => '¡Procesado!',
              'mensaje' => Lang::get('auth.password_reset_success_alert')
            ]);
        }else{
            return Redirect::route('home')->with('resultado',
            [ 'tipo' => 'error',
              'titulo' => '¡Error!',
              'mensaje' => Lang::get('auth.Error_app')
            ]);
        }
    }
/////////////////////////////////////////////// Nueva Clave //////////////////////////////////////////////

    protected function modificarClaveLdap($usuario, $clave_plana){
        $ldaprdn  = 'cn=Admin,dc=dem,dc=int';     // ldap rdn or dn
        $ldappass = 'Hola12357';  // associated password
        $ldapconn = ldap_connect("ldap.dem.int") or die("Could not connect to LDAP server.");
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        if ($ldapconn) {
            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
            if ($ldapbind) {
                echo "Conexión exitosa";
                echo "<br>";
            } else {
                echo "LDAP error :(";
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////
        function generar_clave($password_clear) {
            if( function_exists( 'mhash' ) && function_exists( 'mhash_keygen_s2k' ) ) {
                mt_srand( (double) microtime() * 1000000 );
                $salt = mhash_keygen_s2k( MHASH_SHA1, $password_clear, substr( pack( "h*", md5( mt_rand() ) ), 0, 8 ), 4 );
                $new_value = "{SSHA}".base64_encode( mhash( MHASH_SHA1, $password_clear.$salt ).$salt );

            } else {
                pla_error( _('Your PHP install does not have the mhash() function. Cannot do SHA hashes.') );
            }
            $nueva_clave = $new_value;
            return $nueva_clave;
        }
        ////////////////////////////////////////////////////////////////////////////////////////////
        $n_clave=$clave_plana;
        $username=$usuario;
        $nueva_clave_encriptada=generar_clave($n_clave);
        /////
        $dn = "ou=Personas,ou=Usuarios,dc=dem,dc=int";
        $filter="(uid=$username)";
        $justthese = array("uid");
        $result =ldap_search($ldapconn, $dn, $filter,$justthese);
        $info = ldap_get_entries($ldapconn, $result);
        if ($info)
        {
            $userDn = $info[0]['dn'];
            $info2['userPassword'] = $nueva_clave_encriptada;

            if (ldap_mod_replace ($ldapconn, $userDn, $info2))
            {
                $cambio = true;
            } else {
                $cambio = false;
            }
        }
        ldap_close($ldapconn);
        return $cambio;
    }
}
