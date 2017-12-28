<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Crypt;
use Hash;
use Log;
use Auth;

class Datos extends Model {
	protected $table = "usuarios";
	protected $primaryKey='user_id';
	public $timestamps=false;
    public function listUsuario(){
        $result= DB::table('v_usuarios')->get();
		return $result;
    }
    public function datosPersonales(){
        $user_id = Auth::User()->user_id;
        $sql="select * from v_usuarios where user_id=".$user_id.";";
        $result=DB::select($sql);
		return $result;
    }
    
    public function actualizarDatos($data){
        $data= $data['datos'];
        $data=json_encode($data);
        $sql="select f_actualizacion_usuario('".$data."');";
        $result['f_actualizacion_usuario']=DB::select($sql);
        return $result;
    }
    
    public function datosPersonalesIncompletos($user_id){
        $sql=("select count(1) from usuarios where user_id=".$user_id." and(name is null or email is null or direccion is null or telefonoresidencial is null or movil is null or fecha_nacimiento is null or sexo is null or urlimage is null);");
        $result['v_datos_incompletos']=DB::select($sql);
        $sql=("select rut,password from usuarios where user_id=".$user_id.";");
        $data=DB::select($sql);
        $result['v_cambio_pass']=0;
        if(isset($data[0]->password) && Hash::check($data[0]->rut,$data[0]->password)){$result['v_cambio_pass']=1;}
        return $result;
    }
}