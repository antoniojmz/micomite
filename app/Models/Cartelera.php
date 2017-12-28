<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

use DB;
use Log;
use Auth;

class Cartelera extends Model {
    public function listCartelera($id_sede){
        // $sql="select * from v_carteleras where id_sede='$id_sede';";
        // $result= DB::select($sql);
        $result= DB::table('v_carteleras')->where('id_sede', $id_sede)->get();
        return $result;
    }
    public function listCarteleraActivasH($id_sede){
        $sql="select * from v_carteleras where estatus='t' and id_sede='$id_sede';";
        $result= DB::select($sql);
        return $result;
    }
    public function listCarteleraActivas($data){
        $sql="select f_consulta_carteleras('".$data."');";
        $result= DB::select($sql);
        return $result;
    }
   public function registrarCartelera($data){
        $data=json_encode($data);
        $data=str_replace(array("\r","\n","\r\n","\\n","\\r"),' ',$data);
        $sql="select f_registro_carteleras('".$data."');";
        $result=DB::select($sql);
        return $result;
    }
    public function listMsjs($data){
        $sql="select f_cantidad_msj('".$data."');";
        $result=DB::select($sql);
        return $result;
    }
}