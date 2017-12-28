<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;

class Comite extends Model {

    public function actualizarComite($data){
        $sql = "INSERT INTO comites(user_id, id_sede, cargo) values
        (".$data['datos']['user_id'].",".$data['id_sede'].",'".$data['datos']['cargo']."')";
        $result=DB::select($sql);
        return '200';
    }

    public function eliminarComite($data){
        $sql = "DELETE FROM comites where id_sede =".$data['id_sede']." and user_id=".$data['datos']['user_id'].";";
        $result=DB::select($sql);
        return '300';
    }

   public function verificarComite($data){
        $sql = "select cargo from comites where user_id=".$data['user_id']." and id_sede=".$data['id_sede'].";";
        $result=DB::selectOne($sql);
        return $result;
    }

    // public function listMsjs($data){
    //     $sql="select f_cantidad_msj('".$data."');";
    //     $result=DB::select($sql);
    //     return $result;
    // }


    public function listaComites($id_sede){
        $result= DB::table('v_comites')->where('id_sede', $id_sede)->get();
        return $result;
    }


    public function listaUsuariosComites($data){
        $sql="select f_registro_comite('".$data."');";
        $result=DB::select($sql);
        return $result;
    }

}