<?php
namespace app\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Encryption\DecryptException;

use DB;
use Log;
use Auth;
use Hash;
use Crypt;

class Recuperar extends Model {

    public function recuperarClave($dato){
        $sql="select password from usuarios where rut='".$dato."' or email='".$dato."';";
        $result=DB::select($sql);
        $pass=$result[0]->password;
        log::info($pass);
        $dec = Crypt::decrypt($pass);
        log::info($dec);
    }

    // public function cambiarClave($data){
    //     $data= $data;
    //     $user_id=Auth::User()->user_id;
    //     $pass = DB::table('usuarios')->where('user_id',$user_id)->value('password');
    //     if ($data['password_old']==$data['password']){
    //       $return='{"code":"-1","des_code":"La contraseña nueva no puede ser igual a la actual"}';
    //     }
    //     if(isset($pass) && Hash::check($data['password_old'],$pass)){
    //             if($data['password']==$data['password_confirmation']){
    //                 $data['password']=bcrypt($data['password']);
    //                 try{
    //                         DB::beginTransaction();
    //                         DB::update('update usuarios set password = ? where user_id = ?', [$data['password'],$user_id]);
    //                         DB::commit();
    //                         $return='{"code":"200","des_code":"La contraseña se cambio exitosamente"}';
    //                 }catch (Exception $e) {
    //                     DB::rollback();
    //                     return $e->getMessage();
    //                 }
    //             }else{
    //                 $return='{"code":"-1","des_code":"Las contraseñas no coinciden"}';
    //             }
    //     }else{
    //         $return='{"code":"-1","des_code":"La contraseña actual no es correcta"}';
    //     }
    //     return $return;
    // }

}