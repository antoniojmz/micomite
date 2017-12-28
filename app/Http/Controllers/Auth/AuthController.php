<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ModulosAdmRequest;
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
use DB;

//Models
use App\Models\User;
use App\Models\Cartelera;
use App\Models\Condominio;
use App\Models\Publicidad;
use App\Models\Encuestas;
use App\Models\Datos;

class AuthController extends Controller {
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
        $this->middleware(
            'request_attemps_limiter:ci,'
            . Config::get('auth.actdatos.max_attemps')
            . ',' . Config::get('auth.actdatos.max_attemps_time_window'),
            ['only' => [
                'postActDatos',
             ]
        ]);
    }

    //// Menu //////////////////////////////////////////////////
    protected function getMenu(Request $request){
        Session::forget('validado');
        $data['title'] = 'Menú';
        $data['id_pantalla'] = 1;
        $dats = $request->session()->all();
        $id_sede=$dats['user_portal']['usuario']['id_sede'];
        $data['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        $data['des_nivel']=$dats['user_portal']['usuario']['des_nivel'];
        $dat['id_sede']=$dats['user_portal']['usuario']['id_sede'];
        $dat['id_usuario'] = Auth::User()->user_id;
        $dat['cantidad'] = 1;
        $model = new Datos();
        $data['v_datos_incompletos']= $model->datosPersonalesIncompletos($dat['id_usuario']);
        $data['v_datos_incompletos']= json_encode($data['v_datos_incompletos']);
        $dat=json_encode($dat); 
        $model = new Encuestas();
        $data['v_encuestas']=$model->listEpendientes($dat);
        $data['v_encuestas']=$data['v_encuestas'][0]->f_consulta_encuesta;
        $model = new Cartelera();
        $data['v_msj']=$model->listMsjs($dat);
        $data['v_msj']=$data['v_msj'][0]->f_cantidad_msj;
        $data['name'] = Auth::User()->name;
        $data['rut'] = Auth::User()->rut;
        $data['urlimage'] = Auth::User()->urlimage;
        $data['condominio']=$dats['user_portal']['usuario']['des_sede'];
        $model= new Condominio();
        $result= $model->listFotos($id_sede);
        $data['foto1']=$result[0]->foto1;
        $data['foto2']=$result[0]->foto2;
        $data['foto3']=$result[0]->foto3;
        $model= new Publicidad();
        $data['v_publicidad']= $model->listPublicidadActivas($id_sede);
        $data['id_nivel']=$dats['user_portal']['usuario']['id_nivel'];
        return View::make('menu',$data);
    }
    ////////////////////////////////// Buscar /////////////////////////////
    protected function getBuscar(){
        $data['title'] = Lang::get('auth.buscarFuncionario');
        return View::make('auth.buscar',$data);
    }

    protected function postBuscar(UserRequest $request){
        $input = $request->only('cedula','nacionalidad');
        $ci = $input['nacionalidad'].$input['cedula'];
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // S.W DE NOMINA
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // log::warning($ci);
        $response = json_decode(file_get_contents('http://wsportal.int/ci/'.$ci));
        // $response = json_decode(file_get_contents('http://swnomina/ci/'.$ci));
        // dd($response);
        if ($response){
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            // NOTA:: Este buscar debe ser con el LDAP, pero en este caso va a buscar bd.
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            Session::flash('funcionario',
                [   'id_trabajador'   => $response->id_trabajador,
                    'n ombre'            => ucwords(strtolower($response->primer_nombre.' '.$response->segundo_nombre.' '.
                                   $response->primer_apellido.' '.$response->segundo_apellido)),
                    'nombre_corto'            => ucwords(strtolower($response->primer_nombre.' '.$response->primer_apellido)),
                    'telefonoresidencial' => $response->telefono_residencia,
                    'telefonocelular' => $response->telefono_celular,
                    'telefonooficina' => $response->telefono_oficina,
                    'direccion' => '',
                    'correo' => $response->email,
                    'estatus' => 'A',
                    'condicion' => 'Caso jubilado',
                ]
            );
            $currentRoute = Route::currentRouteName();
            switch ($currentRoute) {
                case "buscar":
                    // BUSCAR PARA CREAR
                    //////////////////////////////////////////////////////////////////////////////////////////////////////
                    // NOTA:: ESTE BUSCAR DEBE SER CON EL LDAP, PERO EN ESTE CASO VA A BUSCAR BD.
                    //////////////////////////////////////////////////////////////////////////////////////////////////////
                    $model = new User();
                    $data = json_decode($model->userExisteBD($ci));
                    // dd($data);
                    // log::warning($data);
                    if ($data){
                        //////////////////////////////////////////////////////////////////////////////////////////////////////
                        // SI YA ESTO FUNCIONA CON LDAP IGUAL DEBE CONECTARSE A BD. PARA VERIFICAR SI POSEE PREGUNTA SECRETA
                        // Existe; ahora debemos verificar si posee pregunta secreta
                        //////////////////////////////////////////////////////////////////////////////////////////////////////
                        // $data = (object) $data[0];
                        // dd($data[0]->preguntasecreta);
                        if (strlen($data[0]->preguntasecreta . '') > 0) {
                            // dd("SSSSIIIIIII tiene pregunta secreta");
                          $model = new User();
                          $datos_persona['combo'] = $model->arraypreguntasecreta($ci);
                            // log::warning($data[0]->preguntasecreta);
                            // El usuario posee pregunta secreta
                            // debemos enviarlo a recuperar la clave informandole usted ya posee cuenta si desea recuperar
                            // presione aquí.
                            // $title = Lang::get('auth.password_reset_invalid_token_browser_title');
                            Session::flash('no_existe',Lang::get('auth.signup_no_existe'));
                            // $datos['combo'] = $data;
                            // log::warning('va a la vista');
                            // Desarrollar
                            // return Redirect::route('recordar_clave')->with('funcionario',
                            //     [   'nacionalidad'    => $input['nacionalidad'],
                            //         'cedula'          => $input['cedula'],
                            //         'combo'           => $datos,
                            //     ]);
                            // log::warning('Si estoy pasando');
                            // dd($data);
                            $datos_persona['ci']  = $ci;
                            // $datos_persona['correo'] = $data[0]->email;
                            Session::put('validado',$datos_persona);
                            return Redirect::route('recordar_clave');
                        }else{
                            // dd("no tiene pregunta secreta");
                            Session::flash('no_existe',
                                Session::get('funcionario.nombre_corto'). Lang::get('auth.signup_existe_sin_ps')
                            );
                            Session::flash('funcionario', $input['cedula']);
                            return Redirect::route('buscar')->with('funcionario',
                                [   'nacionalidad' => $input['nacionalidad'],
                                    'cedula' => $input['cedula']]
                            );
                        }
                    }else{
                        //////////////////////////////////////////////////////////////////////////////////////////////////////
                        // NO EXISTE; no posee correo y por ende debemos dar la opción para enviar un correo electronico al
                        // centro de soporte con todos los datos del sw.
                        //////////////////////////////////////////////////////////////////////////////////////////////////////
                        // log::warning('Viene no existe');

                        // dd($correosoporte);

                        // dd("No funciona");
                        // Aqui tienes que dar la opción de enviar el correo electronico
                        // dd($response->cedula);
                        $datos = [
                        'nombre'                 => $response->primer_nombre . " " . $response->primer_apellido,
                        'primernombre'           => $response->primer_nombre,
                        'segundonombre'          => $response->segundo_nombre,
                        'primerapellido'         => $response->primer_apellido,
                        'segundoapellido'        => $response->segundo_apellido,
                        'cedula'                 => $response->nacionalidad . $response->cedula,
                        'cargo'                  => $response->descripcion_cargo,
                        'tipopersonal'           => $response->tipo_personal,
                        'dependencia'            => $response->dependencia,
                        'unidadadministradora'   => $response->unidad_administradora,
                        ];
                        // dd($datos['cedula']);

                        Session::put('validado',$datos);
                        // dd(Session::get('validado.tipopersonal'));
                        return Redirect::route('solicitudcuenta');
                    }
                    break;
            }
        }else{
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            // NO EXISTE EN LA NÓMINA NO ES FUNCIONARIO -- LISTO
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            Session::flash('no_existe',Lang::get('auth.signup_no_existe'));
            // Session::flash('nacionalidad', $input['nacionalidad']);
            // return Redirect::back()->withInput();
            Session::flash('funcionario', $input['cedula']);
            return Redirect::route('buscar')->with('funcionario',
                [   'nacionalidad' => $input['nacionalidad'],
                    'cedula' => $input['cedula']]
            );
        };
    }

/////////////////////////////////////// /Buscar ////////////////////////////////////////

    protected function getSalir(){
        Auth::logout();
        return Redirect::route('home');
        // return Redirect::route('home')->with('resultado',
        // [ 'tipo' => 'success',
        //   'titulo' => '¡Procesado!',
        //   'mensaje' => Lang::get('auth.logout_success_alert')
        // ]);
    }

    ///////////////////////////////////// login /////////////////////////////////
    protected function getLogin(){
        // log::warning("Esto es a ver si paso");
        $data['title'] = Lang::get('auth.login_browser_title');
        // $data['title'] = 'Sistema de videoconferencia';
        return View::make('auth.login',$data);
    }

    protected function postLogin(AuthSrv $authSrv, UserRequest $request){
        $input = $request->only('username','password');
        $model = new User();
        $data = $model->Validacion($input['password'], $input['username']);
        if (count($data)==0) {
            return Redirect::route('login')
            ->withImput($request->only('username'))
                ->withErrors(['username' => Lang::get('auth.email_error_login_attempt'),
            ]);
        }else{
            $certificado = $data[0]->rut;
            if (strlen($certificado)>0){
                $model = new User();
                $data = User::where('email',$request['username'])->orWhere('rut',$request['username'])->get()->first();
                Auth::login($data);
                $authSrv->Usuario_Accesos(Auth::user()->user_id);
                switch($authSrv->NroAccesos()){
                    case 1:
                        $authSrv->Menudefault();
                        return Redirect::route('menu');
                    default:
                        return Redirect::route('cambioacceso');
                };
            }
        }
    }


















    // $model = new User();
    // $data = $model->CheckUsuario($input);

    // if ($data){
    //         Auth::login($data);
    //         return Redirect::route('ingresodatos');
    //     }else{
    //         return Redirect::route('login')
    //         ->withImput($request->only('email','remember_me'))
    //             ->withErrors([
    //             'email' => Lang::get('auth.email_error_login_attempt'),
    //         ]);
    //     }

    ////////////////////////////////////////// /login //////////////////////////////////////

    //////////////////////////////////// actualizar pregunta secreta ///////////////////////
    protected function getActualizarps(){
        $data['title'] = 'Actualizar pregunta secreta';
        return View::make('auth.actualizarps',$data);
    }

    protected function postActualizarps(UserRequest $request){
      $input = $request->only('emailalternativo','preguntasecreta','respuestasecreta','nacionalidad','cedula','naci');
      // dd(Auth::user()->user_id);
      // log::warning("estoy pasando por post actualizarps");
        $model = new User();
        $data = $model->actualizarPS(Auth::user()->user_id,$input['emailalternativo'],$input['preguntasecreta'],$input['respuestasecreta'], $input['nacionalidad'] . $input['cedula']);

        // Enviar correo

        $user = User::find(Auth::user()->user_id);
        $data = [
            'title'            => Lang::get('auth.actualizar_ps_titulo_email'),
            'cedula'           => $input['nacionalidad'] . $input['cedula'],
            'emailalternativo' => $input['emailalternativo'],
            'preguntasecreta'  => $input['preguntasecreta'],
            'respuestasecreta' => $input['respuestasecreta'],
        ];

        Mail::queue('auth.emails.actualizarPS', $data, function ($message) use ($user) {
            $message->to($user->emailalternativo, $user->name);
            $message->subject(Lang::get('auth.actualizar_ps_titulo_subject'));
        });

        return Redirect::route('home')->with('resultado',
            [ 'tipo' => 'success',
              'titulo' => '¡Procesado!',
              'mensaje' => Lang::get('auth.actualizar_success_alert')
            ]);
    }

    protected function getSalirActualizarps(){
        // log::warning("Si esta entrando al salir por el boton");
        Auth::logout();
        return Redirect::route('home');
    }

    //////////////////////////// /actualizar pregunta secreta ///////////////////////////

    ///////////////////////////////// solicitud cuenta  /////////////////////////////////

    protected function getSolicitudcuenta(){
        if (Session::has('validado')){
            $data['title'] = Lang::get('auth.cambio_browser_title');
            return View::make('auth.solicitudcuenta',$data);
        }
        return Redirect::route('buscar');
    }

    protected function postSolicitudcuenta(UserRequest $request){
      $input = $request->only('cedula','nombre','telefono','emailalternativo','preguntasecreta','respuestasecreta');
      // dd($input);
      $model = new User();
      $data = $model->solicitudcuenta($input);

      if ($data->code_resultado == 200){
      // dd($data);

      // Enviar correo.

      // Envia correo al usuario:

        $user = User::find($data->user_id);
        // $user->user_id
        $data = [
            'title'                      => Lang::get('auth.bienvenido_titulo_email'),
            'nombre'                     => Session::get('validado.nombre'),
            'primernombre'               => Session::get('validado.primernombre'),
            'segundonombre'              => Session::get('validado.segundonombre'),
            'primerapellido'             => Session::get('validado.primerapellido'),
            'segundoapellido'            => Session::get('validado.segundoapellido'),
            'cedula'                     => Session::get('validado.cedula'),
            'telefono'                   => $input['telefono'],
            'emailalternativo'           => $input['emailalternativo'],
            'preguntasecreta'            => $input['preguntasecreta'],
            'respuestasecreta'           => $input['respuestasecreta'],
            'cargo'                      => Session::get('validado.cargo'),
            'tipopersonal'               => Session::get('validado.tipopersonal'),
            'dependencia'                => Session::get('validado.dependencia'),
            'unidadadministradora'       => Session::get('validado.unidadadministradora'),
        ];

        Mail::queue('auth.emails.solicitudinf', $data, function ($message) use ($user) {
            $message->to($user->emailalternativo, $user->name);
            $message->subject(Lang::get('auth.actualizar_dt_titulo_subject'));
        });

        //Envia correo a soporte:

         $data = [
            'title'                      => Lang::get('auth.correosoporte_titulo_email'),
            'nombre'                     => Session::get('validado.nombre'),
            'primernombre'               => Session::get('validado.primernombre'),
            'segundonombre'              => Session::get('validado.segundonombre'),
            'primerapellido'             => Session::get('validado.primerapellido'),
            'segundoapellido'            => Session::get('validado.segundoapellido'),
            'cedula'                     => Session::get('validado.cedula'),
            'telefono'                   => $input['telefono'],
            'emailalternativo'           => $input['emailalternativo'],
            'cargo'                      => Session::get('validado.cargo'),
            'tipopersonal'               => Session::get('validado.tipopersonal'),
            'dependencia'                => Session::get('validado.dependencia'),
            'unidadadministradora'       => Session::get('validado.unidadadministradora'),
        ];

        Mail::send('auth.emails.solicitudcuenta', $data, function($message) {
            $message->to('hdcorreophp@gmail.com')->subject(Lang::get('auth.actualizar_dt_titulo_subject'));
        });

        return Redirect::route('home')->with('resultado',
            [ 'tipo'      => 'success',
              'titulo'    => '¡Procesado!',
              'mensaje'   => Lang::get('auth.solicitud_success_alert')
            ]);
      }
    }

    ///////////////////////////////// /solicitud cuenta  //////////////////////////////

    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////
    ////OPCIONES DEL MENU SUPERIOR
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////

    protected function getCambioAcceso(){
        $data['title'] = 'Cambio de acceso';
        return View::make('menu.eligeacceso', $data);
    }
    protected function postCambioAcceso(AuthSrv $authSrv, Request $request){
        $authSrv->Menu($request->input('id_usuario_acceso'));
        // Log::info(route('menu'));
        return Redirect::route('menu');
    }

    ///////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    ////OPCIONES DEL MENU DERECHO
    ///////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////

    ////////////////////////////////// actualizar datos//////////////////////////////////
    protected function getActDatos(){
      $data['title'] = 'Actualizar Datos';
      // $todo['datos'] = ['direccion'=>direccion,]
      return View::make('auth.actdatos',$data);
    }

    protected function postActDatos(UserRequest $request){
        $input = $request->only('password');

        $certificado = AuthController::autenticarLdap(Auth::user()->username,$input['password']);
        if (strlen($certificado.'') > 0){
            // if(Hash::check($input['password'],Auth::user()->password)){
            // dd('si es correcta');
            // log::warning('Va a llamar la vista');
            // return Redirect::route('actdatos');
            // View::make('auth.clave',$data);

            $datos = [
            'nombre'              =>Auth::user()->name,
            'direccion'           =>Auth::user()->direccion,
            'telefono'            =>Auth::user()->telefono,
            'telefonoresidencial' =>Auth::user()->telefonoresidencial,
            'emailalternativo'    =>Auth::user()->emailalternativo,
            'preguntasecreta'     =>Crypt::decrypt(Auth::user()->preguntasecreta),
            'respuestasecreta'    =>Auth::user()->respuestasecreta,
            ];
            Session::put('validado',$datos);
            // dd( Session::get('validado'));
            return Redirect::route('actdatos');
        }else{
            // Session::forget('validado');
            return Redirect::route('actdatos')->with('resultado',
                [ 'tipo'    => 'error',
                'titulo'  => '¡Error!',
                'mensaje' =>  Lang::get('auth.no_coinciden')
                ]);
        }
    }

    protected function postProcesarActDatos(UserRequest $request){
      $input = $request->only('nombre','direccion','telefono','telefonoresidencial','emailalternativo');
      // dd($input);
      // dd('holaaaaaaaaa');
      $model = new User();
      $data = $model->actualizarDatos(Auth::user()->user_id,$input);
      Auth::user()->emailalternativo = $input['emailalternativo'];
      // dd(Auth::user()->emailalternativo);
      // dd($data);

      // Enviar correo.
        $user = User::find(Auth::user()->user_id);
        $data = [
            'nombre'                      => Auth::user()->name,
            'title'                       => Lang::get('auth.actualizar_dt_titulo_email'),
            'direccion'                   => $input['direccion'],
            'telefono'                    => $input['telefono'],
            'telefonoresidencial'         => $input['telefonoresidencial'],
            'emailalternativo'            => $input['emailalternativo'],
        ];

        Mail::queue('auth.emails.actualizarDatos', $data, function ($message) use ($user) {
            $message->to($user->emailalternativo, $user->name);
            $message->subject(Lang::get('auth.actualizar_dt_titulo_subject'));
        });

        return Redirect::route('menu')->with('resultado',
            [ 'tipo' => 'success',
              'titulo' => '¡Procesado!',
              'mensaje' => Lang::get('auth.actualizar_dt_success_alert')
            ]);
    }
    ////////////////////////////////////// /actualizar datos//////////////////////////////////

    ////////////////////////////////////// Modificar pregunta secreta ////////////////////////
    protected function getModificarps(){
      $data['title'] = 'Modificar pregunta secreta';
      // $todo['datos'] = ['direccion'=>direccion,]
      return View::make('auth.modificarps',$data);
    }

    protected function postModificarps(UserRequest $request){
        $input = $request->only('password');
        // Aqui debes de validar con ldap
        $certificado = AuthController::autenticarLdap(Auth::user()->username,$input['password']);
        if (strlen($certificado.'') > 0){
            // if(Hash::check($input['password'],Auth::user()->password)){
            // dd('si es correcta');
            // log::warning('Va a llamar la vista');
            // return Redirect::route('actdatos');
            // View::make('auth.clave',$data);

            // dd(Auth::user());

            $datos = [
            'emailalternativo'    =>Auth::user()->emailalternativo,
            'preguntasecreta'     =>Crypt::decrypt(Auth::user()->preguntasecreta),
            'respuestasecreta'    =>Auth::user()->respuestasecreta,
            ];
            Session::put('validado',$datos);
            return Redirect::route('modificarps');

        }else{
            return Redirect::route('modificarps')->with('resultado',
                [ 'tipo'    => 'error',
                'titulo'  => '¡Error!',
                'mensaje' =>  Lang::get('auth.no_coinciden')
                ]);
        }
    }

    protected function postProcesarps(UserRequest $request){
      $input = $request->only('emailalternativo','preguntasecreta','respuestasecreta');
      // dd($input);
      $user = new User();
      $data = $user->modificarPs(Auth::user()->user_id,$input);
      // dd($data);

      // Enviar correo.
        $user = User::find(Auth::user()->user_id);
        $data = [
            'title'                       => Lang::get('auth.modificar_dt_titulo_email'),
            'emailalternativo'            => $input['emailalternativo'],
            'preguntasecreta'             => $input['preguntasecreta'],
            'respuestasecreta'            => $input['respuestasecreta'],
        ];

        Mail::queue('auth.emails.modificarPs', $data, function ($message) use ($user) {
            // $message->to(Auth::user()->emailalternativo, Auth::user()->name);
            $message->to($user->emailalternativo, $user->name);
            $message->subject(Lang::get('auth.modificar_dt_titulo_subject'));
        });

        return Redirect::route('menu')->with('resultado',
            [ 'tipo' => 'success',
              'titulo' => '¡Procesado!',
              'mensaje' => Lang::get('auth.modificar_dt_success_alert')
            ]);
    }
    ////////////////////////// /Modificar pregunta secreta ////////////////////////

    ////////////////////////////////// Cambio clave ///////////////////////////////
    protected function getCambioClave(){
        $data['title'] = Lang::get('auth.cambio_browser_title');
        return View::make('auth.cambio_clave',$data);
    }

    protected function postCambioClave(UserRequest $request){
        $input = $request->only('password_anterior','password');
        // dd($input);
        // if(Hash::check($input['password_anterior'],Auth::user()->password)){

        // dd(Auth::user()->username);
        // dd($input['password_anterior']);

        $certificado = AuthController::autenticarLdap(Auth::user()->username,$input['password_anterior']);

        // log::info($certificado);

        // dd($certificado);

        if (strlen($certificado.'') > 0){
            // $certificado = AuthController::autenticarLdap(Auth::user()->username,$input['password']);

            // dd(Auth::user()->username);
            // dd($input['password_anterior']);

            // Nuevo
            // dd($input['password']);

            // $prueba = AuthController::autenticarLdap(Auth::user()->username,$input['password']);



            // if (strlen($certificado.'') = 0){
                // Quiere decir que no es la misma clave

                    // dd('El valor es:  '.$prueba);



                    $prueba = AuthController::modificarClaveLdap(Auth::user()->username,$input['password']);

                // $model = new User();
                // $data = $model->cambiarPassword(Auth::user()->user_id,$input['password']);
                // Auth::user()->user_id = $input['password'];
                // // dd(Auth::user()->user_id);

                // $model = new User();
                // $data = $model->cambiarPassword(Auth::user()->user_id,$input['password']);
                // Auth::user()->user_id = $input['password'];
                // // dd(Auth::user()->user_id);
                // // Auth::logout();
                return Redirect::route('home')->with('resultado',
                    [ 'tipo'      => 'success',
                    'titulo'    => '¡Procesado!',
                    'mensaje'   => Lang::get('auth.cambio_clave_success_alert')
                    ]);
            // }
            // return Redirect::back()->with('no_coinciden', 'Verfique; no puede ser la clave anterior');
        }else {
            return Redirect::back()->with('no_coinciden', Lang::get('auth.no_coinciden'));
        }
    }

    ////////////////////////// Actualizar cuenta //////////////////////////////////
    protected function getActCuenta(){
        if (Session::has('validado')){
            $data['title'] = 'Actualizar datos';
        return View::make('auth.actcuenta', $data);
        }
        return Redirect::route('home');
    }

    protected function postActCuenta(AuthSrv $authSrv, UserRequest $request){
        $input = $request->only('naci','nacionalidad','cedula','nombre','telefono','emailalternativo','preguntasecreta','respuestasecreta','username');
        $model = new User();
        // // Ojo debe ser insertar en la tabla usuario
        $data = $model->actcuenta($input);

        // dd($data);
        if ($data){
          // Envia correo al usuario:
            // $user = User::find($data->user_id);
            $datacorreo = [
                'title'                      => Lang::get('auth.bienvenido_titulo_email'),
                'nacionalidad'               => $input['nacionalidad'],
                'cedula'                     => $input['cedula'],
                'nombre'                     => $input['nombre'],
                'telefono'                   => $input['telefono'],
                'emailalternativo'           => $input['emailalternativo'],
                'preguntasecreta'            => $input['preguntasecreta'],
                'respuestasecreta'           => $input['respuestasecreta'],
            ];
            Auth::login($data);
            $authSrv->Usuario_Accesos(Auth::user()->user_id);
            switch ($authSrv->NroAccesos()) {
                case 0:
                    Auth::logout();
                    // Session::flash('alert.danger','Verifique; no posee ningun acceso asigado.');
                    return Redirect::route('home')->with('resultado',
                    [ 'tipo' => 'error',
                      'titulo' => '¡Bloqueado!',
                      'mensaje' => 'Verique; no posee ningún acceso asignado'
                    ]);
                case 1:
                    $authSrv->Menudefault();
                    return Redirect::route('menu')->with('resultado',
                    [ 'tipo' => 'success',
                      'titulo' => '¡Procesado!',
                      'mensaje' => Lang::get('auth.solicitud_success_alert')
                    ]);
                    // return Redirect::route('menu');
                default:
                    return Redirect::route('cambioacceso')->with('resultado',
                    [ 'tipo' => 'success',
                      'titulo' => '¡Procesado!',
                      'mensaje' => Lang::get('auth.solicitud_success_alert')
                    ]);
                    // return Redirect::route('menu');
            };
        }
    }

    protected function autenticarLdap($usuario , $clave_plana){
        $ldaprdn  = 'cn=Admin,dc=dem,dc=int';     // ldap rdn or dn
        $ldappass = 'Hola12357';  // associated password
        $ldapconn = ldap_connect("ldap.dem.int") or die("Could not connect to LDAP server.");
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        if ($ldapconn) {

            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            // if ($ldapbind) {
            //     echo "Conexión con LDAP exitosa";
            //     echo "<br>";
            // } else {
            //     echo "LDAP error :(";
            // }
        }
        $username = $usuario;
        $str=$clave_plana;
        //filtrar un usuario LDAP por el uid recibido de la pantalla login y nos traemos sólo su clave encriptada
        $dn = "ou=Personas,ou=Usuarios,dc=dem,dc=int";
        $filter="(uid=$username)";
        $justthese = array("userPassword");
        $result =ldap_search($ldapconn, $dn, $filter,$justthese);
        $info = ldap_get_entries($ldapconn, $result);
        $d = $info[0][0];
        $clave_encriptada=$info[0][$d][0];
        //
        //filtrar el mismo usuario LDAP y nos traemos el resto de su información
        $justthese2 = array("demCedula");
        $result2 =ldap_search($ldapconn, $dn, $filter,$justthese2);
        $info2 = ldap_get_entries($ldapconn, $result2);
        $c = $info2[0][0];
        $cedula=$info2[0][$c][0];
        //
        //función que compara el password obtenido del filtro en LDAp y la clave plana recibida desde la pantalla login
        function password_check( $cryptedpassword, $plainpassword ) {
        //if (DEBUG_ENABLED)
            if( preg_match( "/{([^}]+)}(.*)/", $cryptedpassword, $cypher ) ) {
                $cryptedpassword = $cypher[2];
                $_cypher = strtolower($cypher[1]);
            } else {
                $_cypher = NULL;
            }
            switch( $_cypher ) {
                case 'ssha':
                // check php mhash support before using it
                if( function_exists( 'mhash' ) ) {
                    $hash = base64_decode($cryptedpassword);
                    # OpenLDAP uses a 4 byte salt, SunDS uses an 8 byte salt - both from char 20.
                    $salt = substr($hash,20);
                    $new_hash = base64_encode( mhash( MHASH_SHA1, $plainpassword.$salt).$salt );

                    if( strcmp( $cryptedpassword, $new_hash ) == 0 )
                        return true;
                    else
                        return false;

                } else {
                    pla_error( _('Your PHP install does not have the mhash() function. Cannot do SHA hashes.') );
                }
                break;
            }
        }

        ldap_close($ldapconn);
        if (password_check($clave_encriptada,$str)) {
            return $cedula;
        }else{
            return '';
        }
    }

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