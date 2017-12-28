<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquen\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

// Facades
use Hash;
use Log;
use Crypt;
use SerializesModels;
use DB;
use Mail;

class User extends Model implements AuthenticatableContract {

    use Authenticatable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * The primary key table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     *
     * Disable the fields for defects
     *
     * @var boolean
     */
    // public $timestamps = false;

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'email', 'password','cedula','id_trabajador','direccion','telefono','telefonoresidencial','preguntasecreta','respuestasecreta','emailalternativo', 'rut'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string
     */
    protected $dates = ['deleted_at'];

    ///////////////////////////////////////////////////////////////////////////////////
    // Mutators
    ///////////////////////////////////////////////////////////////////////////////////

    // Set the format for the email
    public function setEmailAttribute($value){
        $this->attributes['email'] = mb_strtolower($value,'UTF-8');
    }

    // Set the format for the email
    public function setEmaialternativoAttribute($value){
        $this->attributes['emaialternativo'] = mb_strtolower($value,'UTF-8');
    }

    // Set the format for the username
    public function setUsernameAttribute($value){
        $this->attributes['username'] = mb_strtolower($value,'UTF-8');
    }

    // Set the format for the name
    public function setNameAttribute($value){
        $name = trim($value);
        $name = preg_replace('/\s\s+/', ' ', $name);
        $this->attributes['name'] = $name;
    }

    // Set the hash for the password
    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function setPreguntasecretaAttribute($value){
        $this->attributes['preguntasecreta'] = Crypt::encrypt($value);
    }

    public function setRespuestasecretaAttribute($value){
        $this->attributes['respuestasecreta'] = Hash::make($value);
    }

    public function cambiarPassword($id,$newPassword){
        $user = User::find($id);
        $user->password = $newPassword;
        $user->save();
        return json_decode('{"code_resultado":200,"des_code":"Procesado"}');
    }

    public function actualizarPS($id,$emailalternativo,$preguntasecreta,$respuestasecreta,$cedula){
        // dd($cedula);
        $user = User::find($id);
        $user->cedula = $cedula;
        $user->emailalternativo = $emailalternativo;
        $user->preguntasecreta  = $preguntasecreta;
        $user->respuestasecreta = $respuestasecreta;
        $user->save();
        return '{"code_resultado":200,"des_code":"Procesado"}';
    }

    // Verificar que existe en la base de datos como cuenta creada
    public function userExisteBD($cedula){
        try {
            $user = User::where('cedula','=',$cedula)->get();
            return $user->toJson();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Verificar que existe en la base de datos como cuenta creada
    public function userExistePS($id){
        try {
            $user = User::find($id);
            return $user->toJson();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function actualizarDatos($id, $input){
        // dd($input);
        $user = User::find($id);
        $user->name = $input['nombre'];
        $user->direccion = $input['direccion'];
        $user->telefono = $input['telefono'];
        $user->telefonoresidencial = $input['telefonoresidencial'];
        $user->emailalternativo = $input['emailalternativo'];
        $user->save();
        return '{"code_resultado":200,"des_code":"Procesado"}';
    }

    public function modificarPs($id, $input){
        // dd($input);
        $user = User::find($id);
        $user->emailalternativo = $input['emailalternativo'];
        $user->preguntasecreta = $input['preguntasecreta'];
        $user->respuestasecreta = $input['respuestasecreta'];
        $user->save();
        return '{"code_resultado":200,"des_code":"Procesado"}';
    }

    public function arraypreguntasecreta($cedula){
        try {
            // dd($cedula);
            $pregunta = DB::select("select * from v_preguntas_secretas order by random() limit 9;");
            $pregunta = $pregunta;
            $pregunta = (array) $pregunta;
            $user = User::where('cedula','=',$cedula)->get();
            $data = $user->toArray();
            $data = Crypt::decrypt($data[0]['preguntasecreta']);
            $es = (object) ['id'=>'999','text'=> $data];
            $in = array($es);
            $combo = array_merge($in,$pregunta);
            shuffle($combo);
            // dd($combo);
            return $combo;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function recordarclave($ci){
        $user = User::find($id);
        $user->password = $newPassword;
        $user->save();
        return '{"code_resultado":200,"des_code":"Procesado"}';
    }

    public function solicitudcuenta($input){
        $user = User::create(array('password' => $input['cedula'],
                                    'cedula' => $input['cedula'],
                                    'name' => $input['nombre'],
                                    'emailalternativo' => $input['emailalternativo'],
                                    'telefono' => $input['telefono'],
                                    'preguntasecreta' => $input['preguntasecreta'],
                                    'respuestasecreta' => $input['respuestasecreta']
                                    ));
        $user->save();
        return json_decode('{"code_resultado":200,"des_code":"Procesado","user_id":"'.$user->user_id.'"}');
    }

    public function Acceso($id_usuario){
        return json_decode(DB::select("select f_acceso($id_usuario)")[0]->f_acceso,true);
    }

    public function ModulosCombo(){
        return DB::table('v_modulos')->lists('des_cod_modulo','rel_id_modulo');
    }

    public function ModulosComboSelect2(){
        return DB::select("select des_cod_modulo as text, rel_id_modulo as id from v_modulos;");
    }

    public function PoderesCombo(){
        return DB::table('v_poderes')->lists('des_poder','id_poder');
    }

    public function ModulosPoderesCombo($id_tipo_modulo_id_modulo){
        return DB::select("select des_poder as text, id_poder as id from v_modulos_poderes
            where id_tipo_modulo_id_modulo = $id_tipo_modulo_id_modulo;");
    }

    public function Accesos($id_usuario_acceso){
        return DB::select("select id_acceso, id_tipo_modulo_id_modulo, des_cod_modulo, des_poder, id_poder from v_usuarios_perfil_accesos where id_usuario_acceso = $id_usuario_acceso");
    }

    public function TablaModulosPoderes($rel_id_modulo){
        if ($rel_id_modulo == 0 ){
            return DB::select("select id_modulo, id_poder, des_cod_modulo, des_poder, id_tipo_modulo_id_modulo, id_modulos_poderes from v_modulos_poderes");
        }
        return DB::select("select id_modulo, id_poder, des_cod_modulo, des_poder, id_tipo_modulo_id_modulo, id_modulos_poderes from v_modulos_poderes where id_tipo_modulo_id_modulo = $rel_id_modulo");
    }

    public function TablaPerfilModulosPoderes($rel_id_modulo){
        if ($rel_id_modulo == 0 ){
            return DB::select("select id_plantilla_nivel, id_nivel, id_tipo_modulo_id_modulo, id_modulo, id_poder, des_cod_modulo, des_poder from v_plantillas;");
        }
        return DB::select("select id_plantilla_nivel, id_nivel, id_tipo_modulo_id_modulo, id_modulo, id_poder, des_cod_modulo, des_poder from v_plantillas where id_nivel = $rel_id_modulo");
    }

    public function NivelesCombo(){
        return DB::table('v_niveles')->lists('des_nivel','id_nivel');
    }

    public function SedeCombo(){
        return DB::table('sedes')->lists('des_sede','id_sede');
    }
    // public function ComboPerfil($id_usuario){
    //     return DB::select("select id_usuario_acceso, user_id, id_sede, des_sede, id_nivel, des_nivel, activo_usuario_acceso from v_usuarios_perfil where user_id = $id_usuario;");
    // }

    public function UsernameExiste($username){
        $noexiste = DB::select("select 1 as existe from usuarios where username = '$username';");
        if ($noexiste) {
            return 1;
        }
        return 0;
    }

    public function actcuenta($input){
        DB::beginTransaction();
            $user = User::create(array(
                'cedula'            => $input['nacionalidad'].$input['cedula'],
                'name'              => $input['nombre'],
                'emailalternativo'  => $input['emailalternativo'],
                'telefonocelular'   => $input['telefono'],
                'preguntasecreta'   => $input['preguntasecreta'],
                'respuestasecreta'  => $input['respuestasecreta'],
                'username'          => $input['username']
            ));
            $user->save();

            $inssql = "insert into usuarios_accesos (id_usuario) values (?) returning id_usuario_acceso";
            $id_usuario_acceso = DB::select($inssql,[$user->user_id]);

            $inssql =   "insert into accesos (id_modulo,id_tipo_modulo,id_poder,id_usuario_acceso)
                        select id_modulo, id_tipo_modulo, id_poder, ? from plantillas_niveles
                        where id_nivel = 2;";

            $id_usuario_acceso = DB::select($inssql,[$id_usuario_acceso[0]->id_usuario_acceso]);
            DB::commit();
            // log::info($id_usuario_acceso[0]->id_usuario_acceso);
        return $user;
    }

    public function DeleteModulo_poder($id_tipo_modulo_poder){
        return DB::select("delete from modulos_poderes where
            id_modulos_poderes in($id_tipo_modulo_poder)");
    }

    public function DeletePlantillaPerfil($id_plantilla_nivel){
        return DB::select("delete from plantillas_niveles where
            id_plantilla_nivel in($id_plantilla_nivel)");
    }

    public function AddModulo_poder($poderes , $id_tipo_modulo_id_modulo){
        $cadena_poderes = implode(",", $poderes);
        DB::beginTransaction();
            if ($cadena_poderes == 1){
                DB::select("delete from modulos_poderes where (id_tipo_modulo::text || id_modulo::text)::int = $id_tipo_modulo_id_modulo;");
            };
            DB::select("insert into modulos_poderes (id_tipo_modulo, id_modulo, id_poder)
            select id_tipo_modulo, id_modulo, unnest(array[$cadena_poderes] )
            from v_modulos where rel_id_modulo = $id_tipo_modulo_id_modulo;");
        return ['status' => DB::commit()];
    }

    public function AddPlantillaPerfil($id_sede, $id_perfil, $poderes, $id_tipo_modulo_id_modulo){
        $cadena_poderes = implode(",", $poderes);
        DB::beginTransaction();
            if ($cadena_poderes == 1){
                DB::select("delete from plantillas_niveles where (id_tipo_modulo::text || id_modulo::text)::int = $id_tipo_modulo_id_modulo and id_nivel = $id_perfil;");
            };
            // Log::warning('Eliminó');
            DB::select("insert into plantillas_niveles (id_nivel, id_modulo, id_tipo_modulo, id_poder, id_sede)
                select $id_perfil, id_modulo, id_tipo_modulo, unnest(array[$cadena_poderes]), $id_sede
                from v_modulos where rel_id_modulo = $id_tipo_modulo_id_modulo;");
        return ['status' => DB::commit()];
    }

    public function BuscarUsuarioPerfiles($rut){
        $inssql = "select id_usuario_acceso, id_sede, des_sede, id_nivel, des_nivel, activo_usuario_acceso, des_estado from v_usuarios_perfil where rut = '$rut'";
        Log::info($inssql);
        $data['TablaUsuarioPerfil'] = DB::select($inssql);
        $inssql = "select user_id, name, activo, urlimage from usuarios where rut = '$rut'";
        $data['usuario'] = DB::select($inssql);
        return $data;
    }

    public function BuscarUsuarioPerfilesxid($id_usuario){
        $inssql = "select id_usuario_acceso, id_sede, des_sede, id_nivel, des_nivel, activo_usuario_acceso, des_estado from v_usuarios_perfil where user_id = $id_usuario";
        $data['TablaUsuarioPerfil'] = DB::select($inssql);
        $inssql = "select user_id, name, activo, urlimage from usuarios where user_id = $id_usuario";
        $data['usuario'] = DB::select($inssql);
        return $data;
    }

    public function EstatusUsuario($id_usuario, $estatus){
        DB::beginTransaction();
            $inssql = "update usuarios set activo = '$estatus' where user_id = $id_usuario;";
            DB::select($inssql);
            $estatus = ($estatus === 'true');
            if (!$estatus){
                User::EliminarSession($id_usuario);
            }
        DB::commit();
        return User::BuscarUsuarioPerfilesxid($id_usuario);
    }

    public function EstatusUsuarioPerfil($id_usuario_acceso, $estatus, $id_usuario){
        DB::beginTransaction();
            $inssql = "update usuarios_accesos set activo_usuario_acceso = '$estatus' where id_usuario_acceso = $id_usuario_acceso;";
            DB::select($inssql);
        DB::commit();
        return User::BuscarUsuarioPerfilesxid($id_usuario);
    }

    public function ActualizarPlantilla($id_usuario_acceso, $id_perfil){
        DB::beginTransaction();
            $inssql = "delete from accesos where id_usuario_acceso = $id_usuario_acceso;";
            DB::select($inssql);
            $inssql = "insert into accesos (id_modulo,id_tipo_modulo,id_poder,id_usuario_acceso)
                        select id_modulo, id_tipo_modulo, id_poder, $id_usuario_acceso from plantillas_niveles
                        where id_nivel = $id_perfil;";
            DB::select($inssql);
        DB::commit();
        return;
    }

    public function AsignarPerfil($id_usuario, $id_sede, $id_perfil){
        DB::beginTransaction();
            $inssql = "insert into usuarios_accesos (id_usuario, id_sede, id_nivel) values
            ($id_usuario, $id_sede, $id_perfil) returning id_usuario_acceso;";

            $v_id_usuario_acceso = DB::select($inssql);
            $v_id_usuario_acceso = $v_id_usuario_acceso[0]->id_usuario_acceso;

            $inssql = "insert into accesos (id_modulo,id_tipo_modulo,id_poder,id_usuario_acceso)
                        select id_modulo, id_tipo_modulo, id_poder, $v_id_usuario_acceso from plantillas_niveles
                        where id_nivel = $id_perfil;";

            DB::select($inssql);
        DB::commit();
        return User::BuscarUsuarioPerfilesxid($id_usuario);
    }

    public function EliminarAcceso($id_acceso){
        $inssql = "delete from accesos where id_acceso = $id_acceso";
        DB::select($inssql);
    }

    public function EliminarSession($id_usuario){
        $inssql = "delete from sessions where user_id = $id_usuario";
        DB::select($inssql);
    }

    public function Validacion($password, $username){
        $sql="select password from usuarios where email='$username' OR RUT='$username'";
        $user = DB::select($sql);
        if(isset($user[0]->password) && Hash::check($password,$user[0]->password)){
            $inssql = "Select rut from usuarios where email = '".$username."' OR rut = '".$username."'";
            $data = DB::select($inssql);
            return $data;
        }
    }
    public function recuperarPass($data){
        $query= DB::table('v_usuarios')->where('email',$data['recuperar'])->orWhere('rut', $data['recuperar'])
        ->get();
        $result='{"code":"-2", "des_code":"No se encontro RUT o Correo"}';
        if ($query!=null){
            $pass= Crypt::decrypt($query[0]->valor);
            $email=$query[0]->email;
            $inicio=str_split($query[0]->email, 3);
            $fin = substr($query[0]->email, -9);
            $pathToFile="";
            $containfile=false; 
            $destinatario=$query[0]->email;
            $asunto="Recuperación de contraseña";
            $contenido="Estimado/a ".$query[0]->name.".<br />La Recuperación de contraseña se realizó satisfactoriamente.<br /><br /><b>Su contraseña es: ".$pass."</b><br /><br />Por su seguridad se le recomienda cambiar su contraseña de acceso al entrar nuevamente al sistema.<br /><br />El presente correo es enviado automáticamente por nuestro sistema, por favor, no responda, ni reenvíe mensajes a esta cuenta.";
            $data = array('contenido' => $contenido);
            $r= Mail::send('auth.emails.notificacion', $data, function ($message) use ($asunto,$destinatario,$containfile,$pathToFile){
                $message->from('moraanto2017@gmail.com', 'Mi comite online');
                $message->to($destinatario)->subject($asunto);
                if($containfile){
                    $message->attach($pathToFile);
                }
            });
            if($r){
                $result='{"code":"200", "des_code":"Su contraseña ha sido enviada al correo electrónico '.$inicio[0].'...'.$fin.'"}';
            }
            else{
                $result='{"code":"-2", "des_code":"Ocurrio un error mientras se Enviaba la contraseña a su correo electrónico"}';
            }
        }
        return $result;
    }
}