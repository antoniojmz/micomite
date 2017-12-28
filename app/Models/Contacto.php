<?php
namespace app\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Encryption\DecryptException;
use Mail;

use DB;
use Log;
use Auth;
use Hash;
use Crypt;

class Contacto extends Model {

    public function buscarPerfil($data){
        $sql="select name,urlimage from usuarios where email='".$data ['username']."' OR RUT='".$data ['username']."'";
        $data = DB::select($sql);
        return $data;
    }

    public function enviarContacto($data){
        $pathToFile="";
        $containfile=false;
        $destinatario='micoteonline@gmail.com';
        $asunto="Comentarios de ".$data['name'];
        $contenido="<br />Comentario del usuario: ".$data['name']."<br />correo:".$data['email']."<br />".$data['mensaje']."<br />";
        $data = array('contenido' => $contenido);
        $r= Mail::send('auth.emails.comentarios', $data, function ($message) use ($asunto,$destinatario,$containfile,$pathToFile){
            $message->from('moraanto2017@gmail.com', $asunto);
            $message->to($destinatario)->subject($asunto);
            if($containfile){
                $message->attach($pathToFile);
            }
        });
        if($r){
            $result='{"code":"200", "des_code":"Su comentario ha sido enviado correctamente"}';
        }
        else{
            $result='{"code":"-2", "des_code":"Ocurrio un error mientras se enviaba el comentario"}';
        }
        return $result;
    }
}