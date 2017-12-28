<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model; 

use DB;
use Crypt;
use Log;
use Auth;
use Hash;

class Registrou extends Model {
	protected $table = "usuarios";
	protected $primaryKey='user_id';
	public $timestamps=false;

    public function listUsuario($id_sede){
        $result= DB::table('v_usuarios')->where('id_sede',$id_sede)->get();
		return $result;
    }
     public function listTipoUsuario(){
        $result= DB::table('v_tipo_usuario')->get();
        return $result;
    }
    
    public function regUsuario($data){
        switch ($data['datos']['caso']){
            case 2:
                $pass=bcrypt($data['datos']['rut']);
                $valor=encrypt($data['datos']['rut']);
                $data= $data['datos'];
                $data['password']= $pass;
                $data['valor']= $valor;
                $data=json_encode($data);
                $sql="select f_registro_usuario('".$data."');";
                $result['f_registro_usuario']=DB::select($sql);
                $result['v_usuarios']= DB::table('v_usuarios')->get();
            break;
            case 3:
                $pass=bcrypt($data['datos']['password']);
                $valor=encrypt($data['datos']['password']);
                $sql="UPDATE usuarios SET password='$pass', valor='$valor' WHERE user_id=".$data['datos']['user_id'].";";
                $result=DB::select($sql);
                $result['f_registro_usuario']='{"code":"200", "des_code":"Clave reiniciada exitosamente"}';
            break;           
            default:
               $result='{"code":"-2", "des_code":"Acceso no autorizado"}';
            break;
        }
		return $result;
    }
}