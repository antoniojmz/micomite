<?php
namespace app\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;
use Hash;
use Crypt;

class Clave extends Model {
	protected $table = "usuarios";
	protected $primaryKey='user_id';
	public $timestamps=false;


    public function cambiarClave($data){
        $data= $data;
        $user_id=Auth::User()->user_id;
        $pass = DB::table('usuarios')->where('user_id',$user_id)->value('password');
        if ($data['password_old']==$data['password']){
          $return='{"code":"-1","des_code":"La contraseña nueva no puede ser igual a la actual"}';
        }
        if(isset($pass) && Hash::check($data['password_old'],$pass)){
                if($data['password']==$data['password_confirmation']){
                    $valor=encrypt($data['password']);
                    $data['password']=bcrypt($data['password']);
                    try{
                        DB::beginTransaction();
                        DB::update('update usuarios set password = ?,valor = ? where user_id = ?', [$data['password'],$valor,$user_id]);
                        DB::commit();
                            $return='{"code":"200","des_code":"La contraseña se cambio exitosamente"}';
                    }catch (Exception $e) {
                        DB::rollback();
                        return $e->getMessage();
                    }
                }else{
                    $return='{"code":"-1","des_code":"Las contraseñas no coinciden"}';
                }
        }else{
            $return='{"code":"-1","des_code":"La contraseña actual no es correcta"}';
        }
        return $return;
    }

}